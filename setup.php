<?php
include 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
    	'version' => 'latest',
    	'region'  => 'us-east-1',
	'credentials' => array(
        	'key'    => 'AKIAIJLWLFBQ6GZTR24Q',
        	'secret' => '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',
    	)
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
$create_db_sql = "CREATE SCHEMA `am-gallery`;";
$link->query($create_db_sql);

mysqli_select_db($link, "am-gallery");
$sql = "CREATE TABLE imageGallery
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
uname VARCHAR(20),
email VARCHAR(20),
sms VARCHAR(20),
raw_s3_url VARCHAR(256),
fin_s3_url VARCHAR(256),
jpg_filename VARCHAR(256),
state TINYINT(3),
uploaded_time DATETIME)";

$link->query($sql);

$link->close();
