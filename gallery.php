<?php
require 'vendor/autoload.php';
use Aws\Rds\RdsClient;

?>
<html>
<head><title>Gallery</title>
</head>
<body>

<?php
$email = $_GET["email"];
echo $email."<br>";

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
$sql = "SELECT * FROM imageGallery WHERE email='$email'";
$result = $link->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<img src =\" " . $row['raw_s3_url'] . "\" /><br/>";

}

$link->close();
?>
</body>
</html>
