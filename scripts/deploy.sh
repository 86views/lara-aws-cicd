#!/bin/bash
set -euxo pipefail

# Fix 1: direct redirect instead of tee subshell (causes SSM to hang)
exec > /var/log/deploy.log 2>&1

# Top of deploy.sh should be:
export AWS_REGION=us-east-1
export AWS_DEFAULT_REGION=us-east-1
APP_DIR="/var/www/lara-aws-cicd"   # ← must be defined BEFORE the if [ ! -d check
APP_IMAGE="${1:-}"

if [ -z "$APP_IMAGE" ]; then
  echo "❌ ERROR: No image URI provided."
  exit 1
fi

if [ ! -d "$APP_DIR" ]; then
  echo "📦 Repo missing — cloning..."
  git clone https://github.com/86views/lara-aws-cicd.git "$APP_DIR"
fi

echo "🚀 Deploying: $APP_IMAGE"
cd "$APP_DIR"

if [ ! -f "docker-compose.prod.yml" ]; then
  echo "❌ docker-compose.prod.yml missing"
  ls -la
  exit 1
fi

# ── Fetch secrets ───────────────────────────
DB_HOST=$(aws ssm get-parameter --name "/laravel/db/host" --query "Parameter.Value" --output text)
DB_NAME=$(aws ssm get-parameter --name "/laravel/db/name" --query "Parameter.Value" --output text)
DB_USER=$(aws ssm get-parameter --name "/laravel/db/username" --query "Parameter.Value" --output text)
DB_PASS=$(aws ssm get-parameter --name "/laravel/db/password" --with-decryption --query "Parameter.Value" --output text)
APP_KEY=$(aws ssm get-parameter --name "/laravel/app/key" --with-decryption --query "Parameter.Value" --output text)

for var in DB_HOST DB_NAME DB_USER DB_PASS APP_KEY; do
  if [ -z "${!var}" ]; then
    echo "❌ Missing $var"
    exit 1
  fi
done

# ── Write env ───────────────────────────────
cat > .env <<EOF
APP_IMAGE=${APP_IMAGE}
EOF

mkdir -p src
cat > src/.env <<EOF
APP_NAME=Laravel
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=http://localhost
LOG_CHANNEL=stack
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=3306
DB_DATABASE=${DB_NAME}
DB_USERNAME=${DB_USER}
DB_PASSWORD=${DB_PASS}
EOF
chmod 600 src/.env

# ── Docker login ────────────────────────────
AWS_ACCOUNT_ID=$(echo "$APP_IMAGE" | cut -d'.' -f1)
aws ecr get-login-password \
  | sudo docker login \
    --username AWS \
    --password-stdin \
    "${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com"

# ── Deploy ──────────────────────────────────
sudo docker pull "$APP_IMAGE"
sudo docker compose -f docker-compose.prod.yml up -d --force-recreate --remove-orphans

# Fix 2: use correct service name (laravel-app not app)
COMPOSE_SERVICE="app"

echo "⏳ Waiting for Laravel container..."
for i in {1..20}; do
  if sudo docker compose -f docker-compose.prod.yml exec -T $COMPOSE_SERVICE php artisan --version > /dev/null 2>&1; then
    echo "✅ Laravel ready"
    break
  fi
  echo "Waiting... ($i/20)"
  sleep 3
done

# ── Laravel commands ────────────────────────
set +e
sudo docker compose -f docker-compose.prod.yml exec -T $COMPOSE_SERVICE php artisan migrate --force
sudo docker compose -f docker-compose.prod.yml exec -T $COMPOSE_SERVICE php artisan config:cache
sudo docker compose -f docker-compose.prod.yml exec -T $COMPOSE_SERVICE php artisan route:cache
sudo docker compose -f docker-compose.prod.yml exec -T $COMPOSE_SERVICE php artisan view:cache
set -e

# ── Cleanup ─────────────────────────────────
sudo docker image prune -f

# ── Done ────────────────────────────────────
PUBLIC_IP=$(curl -sf http://169.254.169.254/latest/meta-data/public-ipv4 || echo "localhost")
echo ""
echo "════════════════════════════════════════"
echo "🎉  Deployment complete!"
echo "    URL: http://${PUBLIC_IP}"
echo "════════════════════════════════════════"