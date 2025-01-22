<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mon_blog;charset=utf8', 'root', '');
}catch(PDOexception $e) {
    echo('Error : ' . $e->getMessage());
}