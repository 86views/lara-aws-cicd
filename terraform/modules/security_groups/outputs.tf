# EC2 Security Group ID
output "ec2_sg_id" {
  description = "Security group ID for EC2 instances"
  value       = aws_security_group.ec2.id
}

# RDS Security Group ID
output "rds_sg_id" {
  description = "Security group ID for RDS instance"
  value       = aws_security_group.rds.id
}