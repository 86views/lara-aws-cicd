#!/bin/bash
set -e

# Update Ubuntu packages
apt-get update -y
apt-get upgrade -y

# Install dependencies
apt-get install -y \
  ca-certificates \
  curl \
  gnupg \
  lsb-release \
  git \
  awscli

# Install SSM Agent
snap install amazon-ssm-agent --classic
systemctl enable snap.amazon-ssm-agent.amazon-ssm-agent.service
systemctl start snap.amazon-ssm-agent.amazon-ssm-agent.service

# Add Docker's official GPG key and repo
mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg \
  | gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" \
  | tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker + Compose plugin
apt-get update -y
apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Enable Docker service
systemctl enable --now docker

# Add ubuntu user to docker group
usermod -aG docker ubuntu

# Create app directory ← THIS WAS MISSING
mkdir -p /var/www/laravel-aws-cicd
chown -R ubuntu:ubuntu /var/www

# Clone your repo
cd /var/www
git clone https://github.com/${github_repository}.git lara-aws-cicd
chown -R ubuntu:ubuntu /var/www/laravel-aws-cicd

# Make deploy script executable
chmod +x /var/www/laravel-aws-cicd/scripts/deploy.sh

echo "EC2 bootstrap complete. First deployment will happen via GitHub Actions."