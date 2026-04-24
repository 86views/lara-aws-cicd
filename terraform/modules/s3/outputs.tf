output "bucket_name" {
  value = aws_s3_bucket.laravel_storage.id
}

output "s3_bucket_url" {
  value = "https://${aws_s3_bucket.laravel_storage.bucket_regional_domain_name}"
}