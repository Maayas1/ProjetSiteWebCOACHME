<?php 

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['client_id'])) {
    header("Location: contact_client.php");
}
    ?>

<html>

<head>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/grid.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/animate.css">
    <title> Contactez-Nous </title>
    <link rel="icon" href="img/coahcme.png">
</head>

<body>
    <header>


        <nav>
            <div class="row">
                <div>
                    <a href="index.php"><img src="img/coahcme.png" alt="logo" class="logo"></a>
                    <ul class="main-nav">
                        <li><a href="rdv/index.php">Rendez-vous</a></li>
                        <li><a href="boutique.php">Boutique</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div>

                    <ul class="connexion">
                        
                        <li><a href="rdv/register.php">S'inscrire</a></li>
                        <li><a href="rdv/login.php">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php 

include 'config.php';

error_reporting(0);

session_start();



if (isset($_POST['submit'])) {
	$nom_contact = $_POST['nom_contact'];
	$prenom_contact = $_POST['prenom_contact'];
	$email_contact = $_POST['email_contact'];
	$sujet_contact = $_POST['sujet_contact'];
	$message_contact = $_POST['message_contact'];



			$sql = "INSERT INTO contact (nom_contact, prenom_contact, email_contact , sujet_contact, message_contact)
					VALUES ('$nom_contact', '$prenom_contact', '$email_contact','$sujet_contact','$message_contact')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				 header("Location: contact.php?success=Votre message a été envoyé avec succèes");
	         exit();
				$nom_contact = "";
				$prenom_contact = "";
				$email_contact = "";
				$sujet_contact = "";
				$message_contact = "";
			} 
		} 
		
	


?>
    <div class="acceuil">
        <h1>Pour nous contacter </h1>
    </div>
    <div class="formulaire">
       <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Contactez-nous</p>
            
     	  <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

			<div class="inputs" >
				<input type="Nom" placeholder="Nom" name="nom_contact" value="<?php echo $nom_contact; ?>" required>
			</div>
			<div class="input-group">
				<input type="Prenom" placeholder="Prenom" name="prenom_contact" value="<?php echo $prenom_contact; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email_contact" value="<?php echo $email_contact; ?>" required>
			</div>
			<div class="input-group">
				<input type="Sujet" placeholder="Sujet" name="sujet_contact" value="<?php echo $sujet_contact; ?>" required>
			</div>
			<div class="input-group">
				<textarea name="message_contact" class="form-control mb-2" placeholder="Ecrire le message"></textarea>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Envoyer</button>
			</div>
		</form>
    </div>
    <footer>
        <div class="foot">
            <div class="col span-1-of-2">
                <ul class="footer-nav">
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="/rdv/admin/index.php">Admin/Coach</a></li>
                    <li><a href="#">iOS App</a></li>
                    <li><a href="#">Android App</a></li>
                </ul>
            </div>
            <div class="col span-1-of-2">
                <ul class="social-links">
                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                    <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>

                </ul>
            </div>
        </div>
        <div class="foot">
         
                
            <p>
                
                Copyright &copy; 2021 by COACHME. Tizi-Ouzou.
            </p>
        </div>


    </footer>


         
</body>    
</html> 