resource "aws_ecr_repository" "laravel" {
  name                 = "laravel-app"
  image_tag_mutability = "MUTABLE"

  image_scanning_configuration {
    scan_on_push = true
  }

  tags = {
    Name        = "laravel-app"
    Environment = "production"
  }
}

resource "aws_ecr_lifecycle_policy" "laravel" {
  repository = aws_ecr_repository.laravel.name

  policy = jsonencode({
    rules = [{
      rulePriority = 1
      description  = "Keep last 10 images"
      selection = {
        tagStatus   = "any"
        countType   = "imageCountMoreThan"
        countNumber = 10
      }
      action = {
        type = "expire"
      }
    }]
  })
}