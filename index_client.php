<?php 

include 'config.php';

session_start();

error_reporting(0);

if (!isset($_SESSION['client_id'])) {
    header("Location: index.php");
}
    ?>
<html>

<head>
    <link rel="stylesheet" href="index_client.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/grid.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="VENDORS/css/animate.css">
    <title> Coach-me.dz </title>
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
                        
                     <?php echo $_SESSION['client_name'] .' | '; ?>
                        
                        <li><a href="rdv/logout.php">  Deconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="acceuil">
            <h1>Sois plus fort<br>Que tes excuses</h1>
            <a href="boutique.php" class="btn btn-full ">consulter nos produits</a>
        </div>
        
    </header>
    <div class="design ">
        <div class="">
            <h2>Comment ça marche &mdash; En 3 étapes seulement.</h2>
        </div>
        <div class="etapes">
            <div class="col span-1-of-4 box">
                <i class="ion-ios-infinite-outline icon-big"></i>
               <h3>1ere Etape </h3>
                <p>
                    Consultez les produits disponibles sur notre boutique et les programmes conçus  soigneusement par nos experts pour satisfaire vos besoins.
                   
                </p>
            </div>

            <div class="col span-1-of-4 box">
                <i class="ion-ios-stopwatch-outline icon-big"></i>
                <h3>2eme Etape </h3>
                <p>
                    Remplissez la fiche de reseignements et inscrivez-vous à notre site afin d'avoir accés a toutes les fonctionnalités du site.
                  
                </p>
            </div>

            <div class="col span-1-of-4 box">
                <i class="ion-ios-cart-outline icon-big"></i>
                <h3>3eme Etape </h3>
                <p>
                    Plus de temps a perdre ! Foncez et commencez dés maintenant a changer votre mode de vie, c'est a vous d'en decider ,avec des prix imbattable .
                  </br>  
                   
                </p>
            </div>
        </div>
    </div>
    <div class="section-meals">
        <h2> TRANSFORMATIONS</h2>
        <ul class="meals-showcase clearfix">
            <li>
                <figure class="meal-photo">
                    <img src="img/p3.jpg" alt="Korean bibimbap with egg and vegetables">
                </figure>
            </li>
            <li>
                <figure class="meal-photo">
                    <img src="img/p1.jpg" alt="Simple italian pizza with cherry tomatoes">
                </figure>
            </li>
            <li>
                <figure class="meal-photo">
                    <img src="img/p8.jpg" alt="Chicken breast steak with vegetables">
                </figure>
            </li>
        </ul>
       
    </div>
    


</div>
<section>
    <div>
        .
    </div>
</section>
   
<div class="temoignages">

    <div class="texte">
        <h2>TEMOIGNAGES </h2>
    </div>
    <div class="texte">
        <div class="mayas">
            <blockquote>
                COACH-ME me suit 2 fois par semaine depuis 3 mois . Je recommande vivement cette entreprise pour sa proximité et son sérieux, les séances suivent mon évolution et mes objectifs. Les coachs font en sorte de trouver des exercices différents. Aujourd'hui, je participe à des 10 km de façon régulière, ce qui n'était pas possible avant de les connaitre. De temps en temps, une amie se joint à moi pour un cours à 2, le coach propose toujours des exercices adaptés à nos niveaux afin que nous puissions travailler efficacement.
                <cite><img src="img/femme.jpg">Massi Hamri </cite>
            </blockquote>
        </div>
        <div class="mayas">
            <blockquote>
                J'ai fait appel à COACH-ME pour perdre du poids. Mauvaise alimentation, beaucoup de travail, il était facile de se laisser aller et de ne rien faire. Le premier rendez vous a été déterminant : OUALID a compris qui j'étais et m'a proposé un plan complet sport + alimentation mêlant pédagogie psychologie et humour ! J'alterne les séances 3 fois par semaine avec Jean-Michel et Pierre depuis plus de 2 mois et même si je ne suis pas encore inscrite aux prochains JO les premiers résultats sont là: -16kg, une reprise de confiance en moi et un tonus incroyable !
                <cite><img src="img/téléchargement.jpg">Lionel Messi</cite>
            </blockquote>
        </div>
        <div class="mayas">
            <blockquote>
                Mon coaching extrême s'est révélé très efficace pour moi, 10kg de perdu et 2 crans de ceinture! Une silhouette re-dessinée et une tonicité musculaire qui change la vie. C'est dur, mais tout à fait faisable sous les encouragements bienveillants des coachs de COACH-ME : des efforts mais pour un vrai résultat. Une équipe toujours agréable, sérieuse et surtout très complémentaire.
                <cite><img src="img/images.jpg">Rabah Madjer </cite>
            </blockquote>
        </div>
        
        
    </div>
    
</div>
</div>
    <div class="section-plans>
      

            <div class="">
                <h2>NOS COACHS</h2>
            </div>
        <div class="coachss">
                <div class="col span">
                    <div class="plan-box ">
                        <div>
                            <h3>COACH NAZIM</h3>
                            
                            
                        </div>
                        <div>
                            <ul>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Coach Fitness/Crossfit</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Disponible 7/7</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Possede plusieurs Salles de sport</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Meilleur dans son domaine</li>
                            </ul>
                        </div>
                        <div>
                        <img src="img/img1.jpg" alt="">
                        </div>
                    </div>
                </div>
            <div class="col span">
                <div class="plan-box">
                    <div>
                        <h3>COACH RAYANE</h3>
                        
                        
                    </div>
                    <div>
                        <ul>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Powerlifting</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Double champions d'afrique</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Briseur de records dans les squats</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Fondateur gymshark</li>
                        </ul>
                    </div>
                    <div>
                        <img src="img/img1.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col span">
                <div class="plan-box">
                    <div>
                        <h3>COACH AMINE</h3>
                        
                        
                    </div>
                    <div>
                        <ul>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Nutristionniste</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Diplome international</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Travaille avec plusieurs athletes Pro</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>programme d'une semaine offert</li>
                        </ul>
                    </div>
                    <div>
                        <img src="img/img1.jpg" alt="">
                    </div>
                </div>
            </div>
            
            <div class="col span">
                <div class="plan-box">
                    <div>
                        <h3>COACH OUALID</h3>
                    </div>
                    <div>
                        <ul>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Bodybuilder</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Vice Champion mister olympia</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Adores le poulet</li>
                            <li><i class="ion-ios-checkmark-empty icon-small"></i>Proprietaire golden gym</li>
                        </ul>
                    </div>
                    <div >
                        <img src="img/img1.jpg" alt="">
                    </div>
                </div>
            </div>
            
        </div>
    <div>
     <p>.</p>   
    </div>    
        
    <section>
        <div class="encouragement" >
            <p> Entre possible et impossible  <br> deux lettres et un état d'esprit. </p>
        </div>
    </section>
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