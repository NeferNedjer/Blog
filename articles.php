<?php
session_start();
include_once('./connect_bdd.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page avec tous les articles des utilisateurs">
    <title>Articles</title>
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
        <div class="container cont">
            <h1>Mes Articles :</h1>
            <br>
            <?php
            $id_user = $_SESSION['id_user'];
            $req = $bdd->prepare("SELECT posts.titre, posts.date_publication, posts.id_article, users.nom AS auteur FROM posts INNER JOIN users ON posts.id_user = users.id_user WHERE posts.id_user = ? ORDER BY posts.date_publication DESC");
            $req->execute(array($id_user));
            while($posts = $req->fetch(PDO::FETCH_ASSOC)){ ?>
                <div class="row mb-3">
                    <div class="col-8">
                        <p><?php echo htmlspecialchars($posts['titre']); ?></p>
                    </div>
                    <div class="col-2">  
                        <a href="./modifier_article.php?id=<?=$posts['id_article'];?>"><img src="./assets/img/cercle.webp" alt="crayon vert" class="img-fluid"></a>
                    </div>
                    <div class="col-2">
                        <a href="supprimer_article.php?id=<?= $posts['id_article']; ?>"><img src="./assets/img/poubelle.webp" alt="poubelle rouge" class="img-fluid"></a>
                    </div>
                </div>
            <?php } ?>
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