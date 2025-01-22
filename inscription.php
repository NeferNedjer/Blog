<?php
session_start();

include_once('./connect_bdd.php');

if(isset($_POST['envoyer'])){ // Vérifie si le formulaire a été envoyé

    if(!empty($_POST['nom']) && !empty($_POST['mdp']) && !empty($_POST['email'])){ // Vérifie si les champs 'nom' et 'mdp' et 'email' ne sont pas vides

        $nom = htmlspecialchars($_POST['nom']);
        $mdp = sha1($_POST['mdp']);
        $mail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if($mail) {
            $insertUser = $bdd->prepare('INSERT INTO users(nom, mdp, email, date_inscription) VALUE(?, ?, ?, CURRENT_DATE)');
            if($insertUser->execute(array($nom, $mdp, $mail))){
                echo "Inscription réussie !";
                header('Location:connexion.php');
            }else{
                echo "erreur lors de l'inscription !";
            }
        }else{
            echo "Adresse email invalide !";
        }

    }else{
        echo "Veuillez remplir tous les champs !";
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
    <div class="container cont text-center">
        <h1>inscription</h1>    
        <form action="" method="post" >
            <div class="form-group">
                <label for="nom">Nom :</label><br>
                <input type="text" name="nom" autocomplete="off" class="form-control-lg">
            </div>
            <br>
            <div class="form-group">
                <label for="mdp">Mot de passe : </label><br>
                <input type="password" name="mdp" id="mdp" class="form-control-lg">
            </div>
            <br>
            <div class="form-group">
                <label for="email">adresse mail :</label><br>
                <input type="email" name="email" id="email" autocomplete="off" class="form-control-lg">
            </div>
            <br>
            <div class="text-center">
            <input type="submit" name="envoyer" value="Envoyer" class="btn-submit">
            </div>
        </form>

    </div>
    
    <footer class="container-fluid">
            <p>@NeferCompany</p>
    </footer>
    
</body>
</html>