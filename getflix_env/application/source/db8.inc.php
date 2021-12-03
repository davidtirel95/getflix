<?php
$conn = mysqli_connect('database', 'root', 'root', 'getflix'); 
if(!$conn) {
    die("Connection failed : ".mysqli_connect_error()); 

}