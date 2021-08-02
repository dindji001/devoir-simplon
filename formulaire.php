<?php

session_start();
include 'dbconfig.php';

error_reporting(0);

if (isset($_POST["inscrire"])) {


    $username_connect = htmlspecialchars($_POST['username_connect']);
    $useremail_connect = htmlspecialchars($_POST['useremail_connect']);
    $userpassword_connect = htmlspecialchars(hash('sha256', $_POST['userpassword_connect']));
    $userpassword_Cconnect = htmlspecialchars(hash('sha256', $_POST['userpassword_Cconnect']));

    $check_mail = $bdd->prepare('SELECT email FROM user_info WHERE email = ?');
    $check_mail->execute(array($useremail_connect));
    $data = $check_mail->fetch();
    $row = $check_mail->rowCount();

    if ($userpassword_connect !== $userpassword_Cconnect) {

        echo "<script> alert('le mot de pass ne correspond pas');</script>";

    }elseif ($row > 0 ) {

        echo "<script> alert('Email rentrer existe deja dans la base de donnée');</script>";
    }else {

      $my_Insert_Statement = $bdd->prepare("INSERT INTO User_info (username, email, password) VALUES (:username, :email, :password)");

      $my_Insert_Statement->bindParam('username', $username_connect);
      $my_Insert_Statement->bindParam('email', $useremail_connect);
      $my_Insert_Statement->bindParam('password', $userpassword_connect);

      if ($my_Insert_Statement->execute()) {

        $_POST["username_connect"] = ""; 
        $_POST["useremail_connect"] = ""; 
        $_POST["userpassword_connect"] = ""; 
        $_POST["userpassword_Cconnect"] = ""; 

        echo "<script> alert('Utilisateur enregistrer avec success');</script>";
      } else {
        echo "<script> alert('L'utilisateur n'as pas puis s'enregistrer');</script>";
      }
    }
}


if (isset($_POST["connexion"])) {


    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars(hash('sha256', $_POST['password']));


    $check_mail = $bdd->prepare("SELECT id FROM user_info WHERE email = '$email' AND password = '$password'");
    $check_mail->execute(array($useremail_connect));
    $data = $check_mail->fetch();
    $row = $check_mail->rowCount();
   
    if ( $row > 0 ) {
    
      $_SESSION["user_id"] = $row['id'];
      header("location: index.php");
      
    }else {
      echo "<script> alert('les informations de connexion sont incorrectes. Veuillez réessayer');</script>";
    }


    
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="styleformulaire.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>

    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form  method="post" action="" class="sign-in-form">
            <h2 class="title">S'identifier</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" value="<?php echo $_POST['email']; ?>" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" value="<?php echo $_POST['password']; ?>" placeholder="mot de passe" />
            </div>
            <input type="submit" name="connexion" value="Connexion" class="btn solid" />
            <p class="social-text">Ou Connectez-vous avec les plateformes sociales</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form method="post" action="" class="sign-up-form">
            <h2 class="title">S'inscrire </h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username_connect" placeholder="Nom d'utilisateur" value="<?php echo $_POST['username_connect']; ?>"required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="useremail_connect" placeholder="Email" value="<?php echo $_POST['useremail_connect']; ?>" required  />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="userpassword_connect" placeholder="mot de passe" value="<?php echo $_POST['userpassword_connect']; ?>" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="userpassword_Cconnect" placeholder="Confirmer mot de passe" value="<?php echo $_POST['userpassword_Cconnect']; ?>" required />
            </div>
            <input type="submit" class="btn" name="inscrire" value="S'inscrire " />
            <p class="social-text">Ou inscrivez-vous sur les plateformes sociales</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Nouveau ici ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              S'INSCRIRE
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Deja un Compte</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              S'IDENTIFIER
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <script src="appformulaire.js"></script>
  </body>
</html>
