output "endpoint" {
  value = aws_db_instance.mysql.endpoint
}

output "db_name" {
  value = aws_db_instance.mysql.db_name
}

output "username" {
  value = aws_db_instance.mysql.username
}