<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "coach_appointment");

if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'           =>  $_GET["id"],
                'item_name'         =>  $_POST["hidden_name"],
                'item_price'        =>  $_POST["hidden_price"],
                'item_quantity'     =>  $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Produit deja ajouté")</script>';
            echo '<script>window.location="boutique_client.php"</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id'           =>  $_GET["id"],
            'item_name'         =>  $_POST["hidden_name"],
            'item_price'        =>  $_POST["hidden_price"],
            'item_quantity'     =>  $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Produit retiré")</script>';
                echo '<script>window.location="boutique_client.php"</script>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Boutique</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="boutique_client.css">
        <link rel="stylesheet" type="text/css" href="VENDORS/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="VENDORS/css/grid.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="VENDORS/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="VENDORS/css/animate.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="icon" href="img/coahcme.png">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
    </header>
        <br />
        <div class="container">
            <br />
            <br />
            <br />
            <h3 align="center">Boutique </h3><br />
            <h4 align="center">Pour modifier la quantitée d'un produit veuillez le retirer d'abbord du panier. </h4><br />
            <br /><br />
              <div style="clear:both"></div>
            <br />
            <h3>Votre panier</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nom du produit</th>
                        <th width="10%">Quantitées</th>
                        <th width="20%">Prix</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    <?php
                    if(!empty($_SESSION["shopping_cart"]))
                    {
                        $total = 0;
                        foreach($_SESSION["shopping_cart"] as $keys => $values)
                        {
                    ?>
                    <tr>
                        <td><?php echo $values["item_name"]; ?></td>
                        <td><?php echo $values["item_quantity"]; ?></td>
                        <td> <?php echo $values["item_price"]; ?> DA</td>
                        <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?> DA</td>
                        <td><a href="boutique_client.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Supprimer</span></a></td>
                    </tr>
                    <?php
                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                        }
                    ?>
                    <tr>
                        <td colspan="3" align="right">Total</td>
                        <td align="right"> <?php echo number_format($total, 2); ?> DA</td>
                        <td></td>
                    </tr>
                    <?php
                    }
                    ?>
                        
                </table>
            </div>
            <?php
                $query = "SELECT * FROM products ORDER BY id ASC";
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
            <div class="col-md-4">
                <form method="post" action="boutique_client.php?action=add&id=<?php echo $row["id"]; ?>">
                    <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
                        <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

                        <h4 class="text-info"><?php echo $row["name"]; ?></h4>

                        <h4 class="text-danger"><?php echo $row["price"]; ?> DA</h4>

                        <input type="text" name="quantity" value="1" class="form-control" />

                        <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

                        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Ajouter au panier" />

                    </div>
                </form>
            </div>
            <?php
                    }
                }
            ?>

        </div>
    </div>
    <br />
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

