<?php
session_start();
include_once('./connect_bdd.php');

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8mb4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="container-fluid">
        <nav class="row align-items-center justify-content-between" id="hightNav">
            <div class="col-6 col-md-3">
                <h1 class="logo">Mon Blog Perso</h1>
                <!--<img src="./assets/img/logo.webp" alt="logo mon blog" class="rounded img-fluid">-->
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
                        <a href="index.php" class="btn btn-link">Accueil</a>
                        <a href="publier_articles.php" class="btn btn-link">Publier</a>
                        <a href="articles.php" class="btn btn-link">Mes articles</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>
    <main class="container main">
        
        <div class="container text-center" id="article">
        <h1  >bienvenue sur mon blog !</h1>
        <br>
        <br>
            <?php 
            $req = $bdd->query("SELECT posts.titre, posts.contenu, posts.date_publication, posts.img, posts.id_article, users.nom AS auteur FROM posts INNER JOIN users ON posts.id_user = users.id_user ORDER BY posts.date_publication DESC");
            while($posts = $req->fetch(PDO::FETCH_ASSOC)){
                $contenu =str_replace('<br />', '',($posts['contenu']));
                 ?>
                <div class="container text-start photoArticle">
                    <?php echo '<img src="data:img/Jpeg;base64,' . base64_encode($posts['img']) . '" alt="' . htmlspecialchars($posts['titre']) . '"width ="600" height="200" class="rounded img-fluid">' ?>
                </div>
                <div class="container text-start textArticle">
                    <h2 ><?php echo htmlspecialchars($posts['titre']); ?></h2><br>
                    <p><?php echo $contenu ?></p><br>
                    <div class="d-flex justify-content-start gap-3">
                        <p>Auteur : <?php echo htmlspecialchars($posts['auteur']) ?></p>
                        <p>Publié le : <?php echo $posts['date_publication'] ?></p>
                    </div>
                    <hr>
                </div>
             <?php   
            }
            ?>
        </div>
        <div></div>
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