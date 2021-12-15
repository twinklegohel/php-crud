<?php
global $servername,$username,$password,$dbname;
$con = mysqli_connect($servername, $username, $password,$dbname) or die(mysqli_connect_error());


?>