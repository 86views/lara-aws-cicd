resource "aws_security_group" "ec2" {
  name        = "laravel-ec2-sg"
  vpc_id      = var.vpc_id
  description = "EC2 + SSM + HTTP/HTTPS"

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = { Name = "laravel-ec2-sg" }
}

resource "aws_security_group" "rds" {
  name        = "laravel-rds-sg"
  vpc_id      = var.vpc_id
  description = "RDS only from EC2"

  ingress {
    from_port       = 3306
    to_port         = 3306
    protocol        = "tcp"
    security_groups = [aws_security_group.ec2.id]  # only EC2
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = { Name = "laravel-rds-sg" }
}