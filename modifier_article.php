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
    if($recupArticle->rowCount() >0){
        $articleInfo = $recupArticle->fetch();
        $titre = $recupArticle['titre'];
        $contenu = str_replace('<br />', '', $recupArticle['contenu']);

        if(isset($_POST['modifier'])){
            $titreModif = htmlspecialchars($_POST['titre']);
            $contenuModif = nl2br(htmlspecialchars($_POST['contenu']));

            $articleModif = $bdd->prepare('UPDATE posts SET titre = ?, contenu = ? WHERE id_article = ?');
            header('Location:articles.php');
        }
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
        <h2>Modifier</h2>
        <form  method="POST" action="" enctype="multipart/form-data" class="text-center form">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" autocomplete="off" value="<?= $titre; ?>" required><br><br>
            <label for="image">Photo</label>
            <input type="file" name="img" id="img"><br><br>
            <label for="contenu">contenu</label>
            <textarea name="contenu" id="contenu" required>
                <?= $contenu; ?>
            </textarea><br>
            <br>
            <input type="submit" name="publier" value="modifier" class="btn_publier">
        </form>
    </div>
      
    <footer class="container-fluid">
            <p>@NeferCompany</p>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>