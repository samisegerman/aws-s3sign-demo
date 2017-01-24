AWS S3 Signed URL demo
======================

Installation
------------

* Spin up *Amazon Linux EC2*
  * Assign Public IP or Elasitc IP address
  * Assign EC2 IAM Role

* Run these commands:

```
yum install http24 php56
cd /var/www/html
git clone https://github.com/mludvig/aws-s3sign-demo.git .
wget https://github.com/aws/aws-sdk-php/releases/download/3.21.3/aws.phar
service httpd start
```

* Browse to http://<public-ip>/


