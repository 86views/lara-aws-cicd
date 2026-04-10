output "ec2_public_ip" {
  value = module.ec2.public_ip
}

output "rds_endpoint" {
  value = module.rds.endpoint
}

output "ecr_repository_url" {
  value = module.ecr.repository_url
}

output "s3_bucket" {
  value = module.s3.bucket_name
}

output "github_role_arn" {
  value = aws_iam_role.github_actions.arn
}

output "instructions" {
  value = "1. terraform apply\n2. Add github_role_arn to GitHub Secrets as AWS_ROLE_ARN\n3. Push code → auto deploy!"
}