<?php
session_start();
require 'vendor/autoload.php';
use Aws\S3\S3Client;
$useremail = $_POST["useremail"];
$userphone = $_POST["phone"];
$thefile = $_FILES["userfile"];
$max_file_size = $_POST["MAX_FILE_SIZE"];
$username = $_POST["username"];
$image_path = "/var/www/html/uploads/".$thefile["name"];
$thumb_path = "/var/www/html/uploads/thumb_".$thefile["name"];
move_uploaded_file($thefile["tmp_name"],$image_path);

var_dump($thefile);
//Create a thumbnail of the image
$imagick = new \Imagick(realpath($image_path));
$imagick->thumbnailImage(100, 100, true, true);
$imagick->writeImage($thumb_path);

$client = S3Client::factory(array(
        'version' => 'latest',
        'region'  => 'us-east-1',
	
));

$bucket = uniqid("itmo444am-image-", true);
$result = $client->createBucket(array(
    'Bucket' => $bucket
));

$curtime = time();
$nextweek = $curtime + (60*60*24*7);

//Upload original pic to S3. 
$result = $client->putObject(array(
    'ACL' => "public-read",
    'Bucket' => $bucket,
    'Key'    => $thefile["name"],
    'SourceFile'   => $image_path,
    'Expires' => $nextweek
));

$s3_url = $result["ObjectURL"];


//Upload thumbnail pic to S3. 
$result = $client->putObject(array(
    'ACL' => "public-read",
    'Bucket' => $bucket,
    'Key'    => "thumb_".$thefile["name"],
    'SourceFile'   => $thumb_path,
    'Expires' => $nextweek
));

$s3_thumb_url = $result["ObjectURL"];

use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
    	'version' => 'latest',
	'region'  => 'us-east-1',
	
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
$sql = "INSERT INTO imageGallery(uname, email, sms, fin_s3_url, raw_s3_url, jpg_filename, state, uploaded_time) VALUES('".$username."','".$useremail."','".$userphone."','".$s3_thumb_url."','".$s3_url."','".$thefile["name"]."','2','NOW()')";
$link->query($sql);
$link->close();

use Aws\Sns\SnsClient;
$Snsclient = SnsClient::factory(array(
    	'version' => 'latest',
    	'region'  => 'us-east-1',
	
));

$result = $Snsclient->createTopic([
    'Name' => 'minipro2-maron', 
]);

$snsarn =  $result['TopicArn'];


$result = $Snsclient->subscribe([
    'Endpoint' => $useremail,
    'Protocol' => 'email', 
    'TopicArn' => $snsarn, 
]);
 
$result = $Snsclient->publish([
    'Message' => 'Hello '.$username.', Your image was uploaded!',
    'Subject' => 'New Upload!',
    'TopicArn' => $snsarn
]);

$_SESSION["uploader"] = true;

header("Location:gallery.php?email=".$useremail);
exit;