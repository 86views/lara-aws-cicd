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

  block_public_acls       = true
  block_public_policy     = true
  ignore_public_acls      = true
  restrict_public_buckets = true
}

resource "random_string" "suffix" {
  length  = 8
  special = false
  upper   = false
}