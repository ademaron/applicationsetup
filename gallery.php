<?php
session_start();
require 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$email = $_GET["email"];

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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ade's image uploader</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>  
</head>
  <body>
<div class="container">
      <div class="header clearfix">
        <nav></nav>
        <h3 class="text-muted">Adestagram</h3>
      </div>

      <div class="jumbotron">
        <h1>Gallery</h1>
        <p class="lead">Viewing gallery for <?php echo $email; ?></p>
        <?php
		//conection: Connect to mysql database
		$link = mysqli_connect($endpoint,"itmo444am","itmo444am-pass") or die("Error " . mysqli_error($link));
		mysqli_select_db($link, "am-gallery");
		$sql = "SELECT * FROM imageGallery WHERE email='$email'";
		$result = $link->query($sql);
		while ($row = $result->fetch_assoc()) {
		    echo "<p><img src =\" " . $row['raw_s3_url'] . "\" /><br/></p>";

		}
		$link->close();	
	?>
      </div>
      <footer class="footer">
        <p>&copy; 2015</p>
      </footer>
    </div>

</body>
</html>
