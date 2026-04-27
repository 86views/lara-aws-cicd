variable "vpc_id" {
  description = "VPC ID"
  type        = string
}

variable "public_subnet_id" {
  description = "Public subnet ID for EC2"
  type        = string
}

variable "security_group_id" {
  description = "Security group ID for EC2"
  type        = string
}

variable "instance_type" {
  description = "EC2 instance type"
  type        = string
  default     = "t3.micro"
}

variable "github_repository" {
  description = "GitHub owner/repo"
  type        = string
}

# === These two variables fix the "Unexpected attribute" error ===
variable "ecr_repository_url" {
  description = "ECR repository URL"
  type        = string
}

variable "s3_bucket_name" {
  description = "S3 bucket name for Laravel storage"
  type        = string
}