<?php
session_start();

include_once('./connect_bdd.php');

if(!$_SESSION['mdp']){
    header('Location:connexion.php');
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $getId = $_GET['id'];
    $recupArticle = $bdd->prepare('SELECT * FROM posts WHERE id_article = ?');
    $recupArticle->execute(array($getId));
    if($recupArticle->rowCount() > 0){
        $articleInfo = $recupArticle->fetch();
        $titre = $articleInfo['titre'];
        $contenu = str_replace('<br />', '', $articleInfo['contenu']);

        if(isset($_POST['modifier'])){
            $titreModif = htmlspecialchars($_POST['titre']);
            $contenuModif = nl2br(htmlspecialchars($_POST['contenu']));

            $articleModif = $bdd->prepare('UPDATE posts SET titre = ?, contenu = ? WHERE id_article = ?');
            if($articleModif->execute(array($titreModif, $contenuModif, $getId))){
                
                header('Location: articles.php'); // Redirection après mise à jour
                exit();
            } else {
                echo "Erreur lors de la mise à jour de l'article.";
            }
        }
    } else {
        echo "Article non trouvé.";
    }
    echo "ID de l'article non spécifié.";
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
                        <a href="articles.php">Mes articles</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>
    <main class="container main">
        <div class="container text-center cont">
            <h1>Modifier</h1>
            <form  method="POST" action=""  class=" row text-center form">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" class="form-control" id="titre" autocomplete="off" value="<?= $titre; ?>"><br><br>
                </div>
                <div class="form-group">
                    <label for="contenu">contenu</label>
                    <textarea name="contenu" class="form-control" id="contenu">
                        <?= $contenu; ?>
                    </textarea>
                </div>
                <br>
                <div class="text-center">
                <input type="submit" name="modifier" value="modifier" class="btn btn-primary">
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