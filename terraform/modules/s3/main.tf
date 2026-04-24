resource "aws_s3_bucket" "laravel_storage" {
  bucket = "laravel-storage-${random_string.suffix.result}"

  tags = {
    Name        = "laravel-storage"
    Environment = "production"
  }
}

resource "aws_s3_bucket_versioning" "laravel" {
  bucket = aws_s3_bucket.laravel_storage.id
  versioning_configuration {
    status = "Enabled"
  }
}

resource "aws_s3_bucket_public_access_block" "laravel" {
  bucket = aws_s3_bucket.laravel_storage.id
  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false
}


resource "aws_s3_bucket_policy" "laravel" {
  bucket = aws_s3_bucket.laravel_storage.id
  depends_on = [aws_s3_bucket_public_access_block.laravel]

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [{
      Effect    = "Allow"
      Principal = "*"
      Action    = "s3:GetObject"
      Resource  = "${aws_s3_bucket.laravel_storage.arn}/*"
    }]
  })
}

resource "random_string" "suffix" {
  length  = 8
  special = false
  upper   = false
}