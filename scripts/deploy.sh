mkdir -p scripts
cat > scripts/deploy.sh << 'EOF'
#!/bin/bash
set -e

IMAGE=$1
if [ -z "$IMAGE" ]; then
  echo "Usage: ./deploy.sh <ECR_IMAGE>"
  exit 1
fi

APP_DIR="/var/www/laravel-aws-cicd"
cd $APP_DIR

echo "🚀 Starting deployment with image: $IMAGE"

# Fetch DB credentials from SSM Parameter Store
echo "Fetching secrets from AWS SSM..."
DB_HOST=$(aws ssm get-parameter --name "/laravel/db/host" --query "Parameter.Value" --output text)
DB_NAME=$(aws ssm get-parameter --name "/laravel/db/name" --query "Parameter.Value" --output text)
DB_USER=$(aws ssm get-parameter --name "/laravel/db/username" --query "Parameter.Value" --output text)
DB_PASS=$(aws ssm get-parameter --name "/laravel/db/password" --with-decryption --query "Parameter.Value" --output text)

# Create .env.prod file
cat > .env.prod << EOP
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4)

DB_CONNECTION=mysql
DB_HOST=$DB_HOST
DB_PORT=3306
DB_DATABASE=$DB_NAME
DB_USERNAME=$DB_USER
DB_PASSWORD=$DB_PASS

# Laravel optimization
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
EOF

echo "✅ .env.prod created"

# Pull and run containers
echo "Pulling Docker image..."
docker pull $IMAGE

echo "Starting containers..."
IMAGE=$IMAGE docker compose -f docker-compose.prod.yml --env-file .env.prod up -d --force-recreate

# Run Laravel commands
echo "Running migrations and optimizations..."
docker compose -f docker-compose.prod.yml exec -T app php artisan key:generate --force || true
docker compose -f docker-compose.prod.yml exec -T app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec -T app php artisan config:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan route:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan view:cache

echo "🎉 Deployment completed successfully!"
echo "App should be available at: http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4)"
EOF