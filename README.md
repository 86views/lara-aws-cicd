# Laravel AWS CI/CD with Terraform 🚀

Production-ready **Laravel 12 CI/CD deployment** using:

* Docker (PHP 8.3 + Nginx)
* GitHub Actions (OIDC authentication)
* Terraform (modular infrastructure)
* AWS EC2 (SSM only — no SSH)
* AWS RDS (MySQL/Postgres)
* AWS ECR (Docker registry)
* AWS S3 (storage)
* AWS VPC (public + private subnets)

---

# 📁 Project Structure

```
laravel-aws-cicd/
├── .github/
│   └── workflows/
│       └── deploy.yml
│
├── terraform/
│   ├── main.tf
│   ├── variables.tf
│   ├── outputs.tf
│   ├── terraform.tfvars.example
│   │
│   └── modules/
│       ├── vpc/
│       ├── ec2/
│       ├── rds/
│       ├── ecr/
│       ├── s3/
│       └── security_groups/
│
├── src/                 # Laravel 12 app
│
├── docker/
│   ├── php/
│   └── nginx/
│
├── docker-compose.yml
├── docker-compose.prod.yml
│
├── scripts/
│   ├── deploy.sh
│   └── setup-ec2.sh
│
├── .dockerignore
├── .gitignore
└── README.md
```
**Built with ❤️ using Laravel 12.x**

*Laravel Practical Task — Product Tag Manager*

---

# 🏗️ Architecture

```
GitHub Actions
      │
      ▼
OIDC Authentication
      │
      ▼
Terraform Apply
      │
      ├── VPC
      ├── EC2 (SSM only)
      ├── RDS
      ├── ECR
      ├── S3
      └── Security Groups
      │
      ▼
Docker Image → ECR
      │
      ▼
EC2 pulls image → deploy.sh
      │
      ▼
Laravel running (Docker + Nginx)
```

---

# ⚙️ Prerequisites

Install locally:

* Terraform ≥ 1.6
* Docker
* AWS CLI
* Git
* GitHub repository

---

# 🔐 GitHub OIDC Setup (No AWS Keys)

Create IAM role with:

* `sts:AssumeRoleWithWebIdentity`
* GitHub OIDC provider
* Terraform + ECR permissions

Add to GitHub repo:

```
Settings → Secrets → Actions
```

Add:

```
AWS_ROLE_ARN
AWS_REGION
```

---

# 🚀 Step 1 — Clone Repo

```
git clone https://github.com/YOUR_USERNAME/laravel-aws-cicd.git
cd laravel-aws-cicd
```

---

# 🚀 Step 2 — Configure Terraform

```
cd terraform
cp terraform.tfvars.example terraform.tfvars
```

Edit:

```
project_name = "laravel-cicd"
aws_region   = "eu-central-1"
instance_type = "t3.micro"
db_name = "laravel"
db_user = "admin"
```

---

# 🚀 Step 3 — Deploy Infrastructure

```
terraform init
terraform plan
terraform apply
```

Terraform will create:

* VPC
* EC2
* RDS
* ECR
* S3
* Security Groups
* SSM Parameters

---

# 🚀 Step 4 — Build & Push Image

Handled automatically by GitHub Actions when you push:

```
git add .
git commit -m "Initial deploy"
git push origin main
```

---

# 🔄 CI/CD Flow

1. Push to `main`
2. GitHub Actions builds Docker image
3. Pushes to ECR
4. Runs deploy script on EC2 via SSM
5. Laravel container restarts
6. Migration runs automatically

---

# 🐳 Local Development

```
docker-compose up -d
```

Access:

```
http://localhost
```

---

# 🏭 Production Deployment

Production uses:

```
docker-compose.prod.yml
```

Deployment script:

```
scripts/deploy.sh
```

Handles:

* Pull image
* Load SSM secrets
* Run migrations
* Restart containers

---

# 🔑 No SSH Access

This project uses **AWS SSM only**

To connect:

```
AWS Console → EC2 → Connect → Session Manager
```

No SSH keys required 🔐

---

# 📦 Terraform Modules

| Module          | Purpose         |
| --------------- | --------------- |
| vpc             | Networking      |
| ec2             | App server      |
| rds             | Database        |
| ecr             | Docker registry |
| s3              | Storage         |
| security_groups | Firewall        |

---

# 🌍 Environment Variables (SSM)

Stored in AWS SSM:

```
/laravel/app_key
/laravel/db_host
/laravel/db_name
/laravel/db_user
/laravel/db_password
```

Loaded automatically during deploy.

---

# 🔄 Redeploy

Just push:

```
git push origin main
```

CI/CD handles everything.

---

# 🧹 Destroy Infrastructure

```
cd terraform
terraform destroy
```

---

# 🛠️ Useful Commands

Check containers:

```
docker ps
```

View logs:

```
docker logs laravel-app
```

Enter container:

```
docker exec -it laravel-app bash
```

---

# 🎯 Features

✅ Full CI/CD
✅ GitHub OIDC (no secrets)
✅ Dockerized Laravel
✅ Terraform modular infra
✅ RDS managed database
✅ ECR image registry
✅ SSM secure secrets
✅ No SSH required
✅ Production ready

---

# 📈 Future Improvements

* Load Balancer
* Auto Scaling
* ECS Fargate migration
* CloudFront CDN
* Redis cache
* Blue/Green deploy

---

# 👨‍💻 Author

DevOps Portfolio Project
Laravel + AWS + Terraform + CI/CD

---

# 📜 License

MIT License
