# VPC ID
output "vpc_id" {
  description = "The ID of the VPC"
  value       = aws_vpc.main.id
}

# Public subnet ID
output "public_subnet_id" {
  description = "The ID of the public subnet"
  value       = aws_subnet.public.id
}

# Private subnet ID
output "private_subnet_ids" {
  description = "Private subnet IDs for RDS subnet group"
  value = [
    aws_subnet.private_a.id,
    aws_subnet.private_b.id
  ]
}

# Internet Gateway ID
output "igw_id" {
  description = "ID of the Internet Gateway"
  value       = aws_internet_gateway.igw.id
}

# Public Route Table ID
output "public_route_table_id" {
  description = "ID of the public route table"
  value       = aws_route_table.public.id
}

# Private Route Table ID
output "private_route_table_id" {
  description = "ID of the private route table"
  value       = aws_route_table.private.id
}