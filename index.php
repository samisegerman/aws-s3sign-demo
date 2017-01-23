<html>
<head>
<title>Pre-signed URL demo</title>
</head>
<body>
<?php
require '/var/www/html/aws.phar';

$object = "image.jpg";
$expire = "1 minute";

include 'config.php';

$s3 = new Aws\S3\S3Client([
    'version' => '2006-03-01',
    'region'  => $region,
]);

$cmd = $s3->getCommand('GetObject', [
    'Bucket' => $bucket,
    'Key'    => $object,
]);

$request = $s3->createPresignedRequest($cmd, "+{$expire}");
$signed_url = (string) $request->getUri();

$base_url = "https://s3-{$region}.amazonaws.com/{$bucket}/{$object}";
echo "<p>Direct URL (returns error):<br/><a href=\"{$base_url}\">{$base_url}</a></p>";
echo "<p>Signed URL expires in <i>{$expire}</i>, reload page to refresh URL:<br/><a href=\"{$signed_url}\">{$signed_url}</a></p>";
?>
</body>
</html>
