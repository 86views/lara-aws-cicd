resource "random_password" "db_password" {
  length  = 20
  special = false
}

resource "aws_db_subnet_group" "main" {
  name       = "laravel-rds-subnet-group"
  subnet_ids = var.private_subnet_ids

  tags = {
    Name = "laravel-rds-subnet-group"
  }
}

resource "aws_db_instance" "mysql" {
  identifier = "laravel-db"

  engine               = "mysql"
  engine_version       = "8.0"
  instance_class       = var.db_instance_class
  allocated_storage    = 20
  storage_type         = "gp2"

  db_name              = "laravel"
  username             = "laravel_user"
  password             = random_password.db_password.result

  db_subnet_group_name   = aws_db_subnet_group.main.name
  vpc_security_group_ids = [var.ec2_security_group_id]

  skip_final_snapshot    = true
  publicly_accessible    = false
  backup_retention_period = 0

  tags = {
    Name = "laravel-mysql"
  }
}

# Store credentials securely in SSM Parameter Store (ONLY here)
resource "aws_ssm_parameter" "db_host" {
  name  = "/laravel/db/host"
  type  = "String"
  value = aws_db_instance.mysql.endpoint
}

resource "aws_ssm_parameter" "db_name" {
  name  = "/laravel/db/name"
  type  = "String"
  value = aws_db_instance.mysql.db_name
}

resource "aws_ssm_parameter" "db_username" {
  name  = "/laravel/db/username"
  type  = "String"
  value = aws_db_instance.mysql.username
}

resource "aws_ssm_parameter" "db_password" {
  name  = "/laravel/db/password"
  type  = "SecureString"
  value = random_password.db_password.result
}