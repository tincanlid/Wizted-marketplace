<?php
$dbc = mysqli_connect('localhost', 'root', '', 'portal_vijesti') 
    or die('Greška pri spajanju na MySQL server: ' . mysqli_connect_error());

mysqli_set_charset($dbc, "utf8");
?>