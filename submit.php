<?php
require 'vendor/autoload.php';
use Aws\S3\S3Client;
$useremail = $_POST["useremail"];
$userphone = $_POST["phone"];
$thefile = $_FILES["userfile"];
$max_file_size = $_POST["MAX_FILE_SIZE"];
$username = $_POST["username"];

move_uploaded_file($thefile["tmp_name"],"/var/www/html/uploads/".$thefile["name"]);

$client = S3Client::factory(array(
        'version' => 'latest',
        'region'  => 'us-east-1'
));

$bucket = uniqid("itmo444am-image-", true);
$result = $client->createBucket(array(
    'Bucket' => $bucket
));

$result = $client->putObject(array(
    'ACL' => "public-read",
    'Bucket' => $bucket,
    'Key'    => $thefile["name"],
    'SourceFile'   => "/var/www/html/uploads/".$thefile["name"]
));

$s3_url = $result["ObjectURL"];
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
    'version' => 'latest',
    'region'  => 'us-east-1'
));

$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'itmo444am-mysql',
));

$endpoint = "";

foreach ($result["DBInstances"] as $dbinstance) {
    $dbinstanceidentifier = $dbinstance["DBInstanceIdentifier"];
    if ($dbinstanceidentifier == "itmo444am-mysql"){
        $endpoint = $dbinstance["Endpoint"]["Address"];
    }
}

//conection: Connect to mysql database
$link = mysqli_connect($endpoint,"itmo444am","itmo444am-pass") or die("Error " . mysqli_error($link));
mysqli_select_db($link, "am-gallery");
$sql = "INSERT INTO imageGallery(uname, email, sms, raw_s3_url, jpg_filename, state, uploaded_time) VALUES('".$username."','".$useremail."','".$userphone."','".$s3_url."','".$thefile["name"]."','2','NOW()')";
$link->query($sql);
$link->close();

header("Location:gallery.php?email=".$useremail);
exit;