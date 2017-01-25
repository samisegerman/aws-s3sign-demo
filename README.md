AWS S3 Signed URL demo
======================

Preparation
-----------

1. Spin up *Amazon Linux EC2* instance
   * Assign Public IP or Elasitc IP address, e.g. *IP.AD.DR.ES*
   * Assign EC2 IAM Role, e.g. `s3sign-role`

2. Create S3 Bucket, e.g. `s3sign-bucket`

3. Assign this IAM Policy to the `s3sign-role`
   ```json
   {
       "Version": "2012-10-17",
       "Statement": [
           {
               "Action": [
                   "s3:List*",
                   "s3:Get*",
                   "s3:Put*"
               ],
               "Resource": [
                   "arn:aws:s3:::s3sign-bucket",
                   "arn:aws:s3:::s3sign-bucket/*"
               ],
               "Effect": "Allow"
           }
       ]
   }
   ```
   Don't forget to update the bucket name in *Resource* block if it's different from `s3sign-bucket`!

Installation
------------

Run these commands:

```
yum install http24 php56
cd /var/www/html
git clone https://github.com/mludvig/aws-s3sign-demo.git .
wget https://github.com/aws/aws-sdk-php/releases/download/3.21.3/aws.phar
service httpd start
```

Copy `config-template.php` to `config.php` and populate the values:

```php
<?php
$region = "ap-southeast-2";
$bucket = "s3sign-bucket";
?>
```

CloudFormation
--------------

Instead of following the manual steps above you can use the
included CloudFormation template `s3-sign-demo.json` that
sets us the environment the same way.

Testing
-------

1. Upload some files and images to `s3sign-bucket` with Private ACL

2. Browse to **http://{IP.AD.DR.ES}/index.php**

Results
-------

Accessing the *Direct URL* of the *Object* will result in an error like this:

```xml
<Error>
  <Code>AccessDenied</Code>
  <Message>Access Denied</Message>
  <RequestId>D8AA...1F94A</RequestId>
  <HostId>Y3Y+...7pwvqiWs=</HostId>
</Error>
```

Accessing an _expired_ *Signed URL* will return an error like this:

```xml
<Error>
  <Code>AccessDenied</Code>
  <Message>Request has expired</Message>
  <X-Amz-Expires>60</X-Amz-Expires>
  <Expires>2017-01-24T03:51:30Z</Expires>
  <ServerTime>2017-01-24T03:53:20Z</ServerTime>
  <RequestId>B176...42679</RequestId>
  <HostId>L3Q+...5RGrv52k=</HostId>
</Error>
```

Author
------

By [Michael Ludvig](https://aws.nz)
