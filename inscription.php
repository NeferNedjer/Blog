<?php
session_start();

include_once('./connect_bdd.php');

if(isset($_POST['envoyer'])){ // Vérifie si le formulaire a été envoyé

    if(!empty($_POST['nom']) && !empty($_POST['mdp']) && !empty($_POST['email'])){ // Vérifie si les champs 'nom' et 'mdp' et 'email' ne sont pas vides

        $nom = htmlspecialchars($_POST['nom']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); // 
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
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
            <h1 >inscription</h1>    
            <form action="" method="post" >
                <div class="form-group">
                    <label for="nom">Nom :</label><br>
                    <input type="text" name="nom" id="nom" autocomplete="off" class="form-control-lg">
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