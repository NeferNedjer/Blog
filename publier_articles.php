<?php
session_start();

include_once('./connect_bdd.php');

if(!$_SESSION['mdp']){
    header('Location:connexion.php');
}
$id_user = $_SESSION['id_user'];

if(isset($_POST['publier'])){
    if(!empty($_POST['titre']) && !empty($_POST['contenu'])){
        $img = file_get_contents($_FILES['img']['tmp_name']);
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = nl2br(htmlspecialchars($_POST['contenu']));
        $insertPost = $bdd->prepare('INSERT INTO posts(titre, contenu, id_user, img, date_publication) VALUES (:titre, :contenu, :id_user, :img, CURRENT_DATE)');
        $insertPost->execute(array(':titre' => $titre, ':contenu' => $contenu, ':id_user' => $id_user, ':img' => $img));
        header('Location:index.php');
    }else{
        echo "Veuillez compléter tous les champs !";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="container-fluid ">
        <nav class="row align-items-center justify-content-end" id="hightNav">
            <div class="col-3">
                <img src="./assets/img/mon_blog-rb.png" alt="logo mon blog" class="rounded img-fluid">
            </div>
            <div class="col-9 text-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <?php if(empty($_SESSION['mdp'])): ?>
                            <a href="./inscription.php">Inscription</a>
                            <a href="./connexion.php">Connexion</a>
                        <?php else: ?>
                            <a href="./deconnexion.php">Déconnexion</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
        <nav class="row align-items-center justify-content-end text-end" id="lowNav">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <?php if(isset($_SESSION['mdp'])): ?>
                        <a href="index.php">Accueil</a>
                        <a href="publier_articles.php">Publier</a>
                        <a href="articles.php">Modifier</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>publier</h2>
        <form  method="POST" action="" enctype="multipart/form-data">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" autocomplete="off" required><br><br>
            <label for="image">Photo</label>
            <input type="file" name="img" id="img"><br><br>
            <label for="contenu">contenu</label>
            <textarea name="contenu" id="contenu" required></textarea><br>
            <br>
            <input type="submit" name="publier" value="publier" class="btn_publier">
        </form>
    </div>
      
    <footer class="container-fluid">
            <p>@NeferCompany</p>
    </footer>
    
</body>
</html>