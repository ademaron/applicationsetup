#!/bin/bash
echo "<!DOCTYPE html>"> /var/www/html/index.html
echo "<html>">> /var/www/html/index.html
echo "<head>">> /var/www/html/index.html
echo "<title>ITMO 444 Cloud Computing Technologies</title>">>/var/www/html/index.html
echo "</head>">> /var/www/html/index.html
echo "<body>">> /var/www/html/index.html

echo "<h1>Adrianna Maron</h1>">> /var/www/html/index.html
echo "<h2> ITMO 444 Cloud Computing Technologies</h2>">> /var/www/html/index.html
echo '<p><img src ="https://s3.amazonaws.com/maronadebucket123/mypicture.jpg"/></p>'>> /var/www/html/index.html
echo '<p><a href="page2.html"> Check out da hawk </a></p>'>> /var/www/html/index.html 
echo "</body>">> /var/www/html/index.html
echo "</html>">> /var/www/html/index.html


echo "<!DOCTYPE html>"> /var/www/html/page2.html
echo "<html>">> /var/www/html/page2.html
echo "<head>">> /var/www/html/page2.html
echo "<title>ITMO 444 Cloud Computing Technologies</title>">>/var/www/html/page2.html
echo "</head>">> /var/www/html/page2.html
echo "<body>">> /var/www/html/page2.html

echo "<h1>Adrianna Maron</h1>">> /var/www/html/page2.html
echo "<h2> ITMO 444 Cloud Computing Technologies</h2>">> /var/www/html/page2.html
echo '<p><img src ="images/hawk.png" /></p>'>> /var/www/html/page2.html
echo '<p><a href="index.html"> Go back home </a></p>'>> /var/www/html/page2.html
echo "</body>">> /var/www/html/page2.html
echo "</html>">> /var/www/html/page2.html

cp -R images/ /var/www/html/





