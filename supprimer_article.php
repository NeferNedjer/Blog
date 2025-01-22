<?php
session_start();

include_once('./connect_bdd.php');

if(!$_SESSION['mdp']){
    header('Location:connexion.php');
}
echo $_SESSION['nom'];

if(isset($_GET['id']) && !empty($_GET['id'])){
    $getId = htmlspecialchars($_GET['id']);
    $recupPost = $bdd->prepare('SELECT * FROM posts WHERE id_article = ?');
    $recupPost->execute(array($getId));
    if($recupPost->rowcount() > 0){
        $suprPost = $bdd->prepare('DELETE FROM posts WHERE id_article = ?');
        $suprPost->execute(array($getId));
    }
    
}header('Location:articles.php');
?>