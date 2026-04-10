#!/bin/bash
# Update Ubuntu packages
apt-get update -y
apt-get upgrade -y

# Install Docker, Git, AWS CLI
apt-get install -y docker.io git awscli

# Enable Docker service
systemctl enable --now docker

# Add ubuntu user to docker group
usermod -aG docker ubuntu

# Clone your repo
cd /var/www
git clone https://github.com/${github_repository}.git laravel-aws-cicd
chown -R ubuntu:ubuntu /var/www/laravel-aws-cicd

echo "EC2 bootstrap complete. First deployment will happen via GitHub Actions."