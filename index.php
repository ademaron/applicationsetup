<?php 
session_start(); 
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
        <h1>Whatcha wanna upload?</h1>
        <p class="lead"></p>
        <p><form enctype="multipart/form-data" action="submit.php" method="POST">
    	<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    	Username: <input type="text" name="username" value="User"><br/>
    	Send this file: <input name="userfile" type="file" /><br/>
    	Enter Email of user: <input type="email" name="useremail" value="test@test.com"><br/>
    	Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone" value="18001111111">
    	<input type="submit" value="Send File" />
	</form>
<hr/>
<form enctype="multipart/form-data" action="gallery.php" method="GET">
    Enter email of user for gallery to browse: <input type="email" name="email" value="test@test.com">
    <input type="submit" value="Load Gallery" />
</form></p>
      </div>
      <footer class="footer">
        <p>&copy; 2015</p>
      </footer>
    </div> 
</body>
</html>