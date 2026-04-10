terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.75"
    }
    random = {
      source  = "hashicorp/random"
      version = "~> 3.6"
    }
  }
}

provider "aws" {
  region = var.region
}

data "aws_caller_identity" "current" {}

# Modules
module "vpc" {
  source = "./modules/vpc"
}

module "security_groups" {
  source = "./modules/security_groups"
  vpc_id = module.vpc.vpc_id
}

module "ecr" {
  source = "./modules/ecr"
}

module "s3" {
  source = "./modules/s3"
}

module "rds" {
  source              = "./modules/rds"
  private_subnet_ids   = module.vpc.private_subnet_ids
  ec2_security_group_id = module.security_groups.ec2_sg_id
}

module "ec2" {
  source = "./modules/ec2"

  # Required by the module
  vpc_id                = module.vpc.vpc_id
  public_subnet_id      = module.vpc.public_subnet_id
  security_group_id     = module.security_groups.ec2_sg_id
  instance_type         = var.instance_type
  github_repository     = var.github_repository

  # These two were causing the error — they must be declared in variables.tf
  ecr_repository_url    = module.ecr.repository_url
  s3_bucket_name        = module.s3.bucket_name
}



# OIDC Role for GitHub Actions (no secrets needed)
resource "aws_iam_role" "github_actions" {
  name = "github-actions-laravel-cicd"

  assume_role_policy = jsonencode({
    Version = "2012-10-17"
    Statement = [{
      Effect = "Allow"
      Principal = {
        Federated = "arn:aws:iam::${data.aws_caller_identity.current.account_id}:oidc-provider/token.actions.githubusercontent.com"
      }
      Action = "sts:AssumeRoleWithWebIdentity"
      Condition = {
        StringEquals = {
          "token.actions.githubusercontent.com:aud" = "sts.amazonaws.com"
        }
        StringLike = {
          "token.actions.githubusercontent.com:sub" = "repo:${var.github_repository}:*"
        }
      }
    }]
  })
}

resource "aws_iam_role_policy_attachment" "github_ecr" {
  role       = aws_iam_role.github_actions.name
  policy_arn = "arn:aws:iam::aws:policy/AmazonEC2ContainerRegistryFullAccess"
}

resource "aws_iam_role_policy" "github_ssm_ec2" {
  role = aws_iam_role.github_actions.name
  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Effect = "Allow"
        Action = ["ssm:SendCommand", "ec2:DescribeInstances"]
        Resource = "*"
      }
    ]
  })
}

