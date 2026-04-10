variable "private_subnet_ids" {
  description = "List of private subnet IDs where RDS will be deployed"
  type        = list(string)
}

variable "ec2_security_group_id" {
  description = "Security group ID of the EC2 instance (to allow access to RDS on port 3306)"
  type        = string
}

variable "db_instance_class" {
  description = "RDS instance class (Free Tier eligible)"
  type        = string
  default     = "db.t3.micro"     # Changed to t3.micro for better compatibility
}