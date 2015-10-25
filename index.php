<?php session_start(); ?>
<html>
<head>
    <title></title>
</head>
<body>

<form enctype="multipart/form-data" action="submit.php" method="POST">

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
</form>

</body>
</html>