variable "region" {
  default = "us-east-1"
}

variable "github_repository" {
  description = "owner/repo (for OIDC)"
  type        = string
}

variable "instance_type" {
  default = "t3.micro"
}

variable "db_instance_class" {
  default = "db.t4g.micro"
}