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
    <div class="container form text-center">
        <h2>connexion</h2>
        <form action="" method="post">
            <label for="nom">Nom : </label>
            <input type="text" name="nom" autocomplete="off"><br>
            <label for="mdp">Mot de passe : </label>
            <input type="password" name="mdp" id="mdp"><br>
            <input type="submit" name="envoyer" value="Envoyer" class="envoyer">
        </form>
    </div>
    
    <footer class="container-fluid">
            <p>@NeferCompany</p>
    </footer>
    
</body>
</html>