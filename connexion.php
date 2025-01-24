<?php
session_start();

include_once('./connect_bdd.php');


if(isset($_POST['envoyer'])){
    if(!empty($_POST['nom']) && !empty($_POST['mdp'])){
        $nom = htmlspecialchars($_POST['nom']);
        $mdp = sha1($_POST['mdp']);

        $recupUser = $bdd->prepare('SELECT * FROM users WHERE nom = ? AND mdp = ?');
        $recupUser->execute(array($nom, $mdp));

        if($recupUser->rowCount() > 0){
            $_SESSION['nom'] = $nom;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id_user'] = $recupUser->fetch()['id_user'];

            header('Location:index.php');
            
        }else{
            echo "Votre mot de passe ou votre identifiant sont incorrects !";
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
    <meta name="description" content="Page de connexion des utilisateurs">
    <title>Connexion</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header class="container-fluid">
        <nav class="row align-items-center justify-content-between" id="hightNav">
            <div class="col-6 col-md-3">
                <a href="index.php"><h1 class="logo">Mon Blog Perso</h1></a>
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
        <div class="container cont text-center">
            <h1 >connexion</h1>
            <form action="" method="post">
                <div class="form-group">
                <label for="nom">Nom : </label><br>
                <input type="text" name="nom" autocomplete="off" class="form-control-lg">
                </div>
                <br>
                <div class="form-group">
                <label for="mdp">Mot de passe : </label><br>
                <input type="password" name="mdp" id="mdp" class="form-control-lg">
                </div>
                <br>
                <div class="text-center">
                <input type="submit" name="envoyer" value="Envoyer" class="btn btn-primary">
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