<?php
session_start();

include_once('./connect_bdd.php');

if(!$_SESSION['mdp']){
    header('Location:connexion.php');
}
$id_user = $_SESSION['id_user'];

if(isset($_POST['publier'])){
    if(!empty($_POST['titre']) && !empty($_POST['contenu'])){

        
        $type = $_FILES['img']['type'];
        $arrayType = ["jpeg" => 'image/jpg', "jpg" => 'image/jpg', "png" => 'image/png', "webp" => 'image/webp'];

        if(in_array($type, $arrayType)){
    
        $img = file_get_contents($_FILES['img']['tmp_name']);
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = nl2br(htmlspecialchars($_POST['contenu']));
        $insertPost = $bdd->prepare('INSERT INTO posts(titre, contenu, id_user, img, date_publication) VALUES (:titre, :contenu, :id_user, :img, CURRENT_DATE)');
        $insertPost->execute(array(':titre' => $titre, ':contenu' => $contenu, ':id_user' => $id_user, ':img' => $img));
        header('Location:index.php');
        }else{
            echo "Le format n'est pas le bon !";
        }
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
    <title>Publier</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header class="container-fluid">
        <nav class="row align-items-center justify-content-between" id="hightNav">
            <div class="col-6 col-md-3">
                <a href="index.php"><h1 class="logo">Mon Blog Perso</h1></a>
            </div>
            <div class="col-6 col-md-9 text-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <?php if(empty($_SESSION['mdp'])): ?>
                            <a href="./inscription.php" class="btn btn-primary">Inscription</a>
                            <a href="./connexion.php" class="btn btn-secondary">Connexion</a>
                        <?php else: ?>
                            <a href="./deconnexion.php" class="btn btn-danger">Déconnexion</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
        <nav class="row align-items-center justify-content-end text-end" id="lowNav">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <?php if(isset($_SESSION['mdp'])): ?>
                        <div class="container text-start">
                        <p>Bonjour <?= $_SESSION['nom'] ?> !</p>
                        </div>
                        <a href="index.php" class="btn btn-link">Accueil</a>
                        <a href="publier_articles.php" class="btn btn-link">Publier</a>
                        <a href="articles.php" class="btn btn-link">Mes articles</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>
    <main class="container main">
        <div class="container text-center cont">
            <h1>publier</h1>
            <form  method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre :</label><br>
                    <input type="text" name="titre" class="form-control" id="titre" autocomplete="off" required><br><br>
                </div>
                <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" class="form-control-file" name="img" id="img">
                </div>
                <br>
                <div class="form-group">
                    <label for="contenu">Contenu :</label>
                    <textarea name="contenu" class="form-control" id="contenu" required></textarea>
                    </div>
                <br>
                <div class="text-center">
                    <input type="submit" name="publier" value="publier" class="btn btn-primary push">
                </div>
            </form>
        </div>
    </main>  
    <footer class="container-fluid text-center py-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <p>@NeferCompany</p>
            </div>
            <div class="col-12 col-md-6">
                <p>contact@nefercompany.com</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>