<?php
//////////////////////////////
//visualliza i dati sulll'account
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Skamazon</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->

</head>

<body>
    <!-- HEADER -->
    <header>
        <?php
        HeaderAdmin();
        ?>
        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-2">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="./img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-7">
                        <div class="header-search">
                            <form action="store.php" method="get">
                                <select class="input-select" name="categorie">
                                    <option>All Categories</option>
                                    <option>New</option>
                                    <option>Hot Deals</option>
                                    <option>Electronics</option>
                                    <option>House</option>
                                    <option>Motors</option>
                                    <option>Top Selling</option>
                                </select>
                                <input class="input" placeholder="Search here" name="SearchBar">
                                <button class="search-btn">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- My account -->
                            <div>
                                <a href="Account.php">
                                    <i class="fa fa-user-o"></i>
                                    <span>My Account</span>
                                </a>
                            </div>
                            <!-- /My account -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>My Cart</span>
                                    <?php
                                    VisualizzaCarrelloNum();
                                    ?>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list">
                                        <?php
                                        $sql = $conn->prepare("SELECT * FROM  contiene  join  articoli on contiene.IdArticolo = articoli.ID join imgsrc on articoli.ID = imgsrc.ID  where IdCarrello = " . $_SESSION['IDcarrello']);
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        if ($result !== false && $result->num_rows > 0) {
                                            for ($j = 0; $j < $result->num_rows; $j++) {
                                                if ($row = $result->fetch_object()) {
                                                    echo '<div class="product-widget">';
                                                    echo '	<div class="product-img">';
                                                    echo "		<img src='./img/$row->source' alt=''>";
                                                    echo '	</div>';
                                                    echo '	<div class="product-body">';
                                                    echo "		<h3 class='product-name'><a href='product.php?ID=$row->ID'>$row->Nome</a></h3>";
                                                    echo "		<h4 class='product-price'><span class='qty'>$row->quantita x</span>$row->Prezzo ???</h4>";
                                                    echo '	</div>';
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $sql = $conn->prepare("SELECT * FROM contiene  join  articoli on contiene.IdArticolo = articoli.ID WHERE IdCarrello = " . $_SESSION['IDcarrello']);
                                    $sql->execute();
                                    $result = $sql->get_result();
                                    $total = 0;
                                    echo '<div class="cart-summary">';
                                    if ($result !== false && $result->num_rows > 0) {
                                        for ($j = 0; $j < $result->num_rows; $j++) {
                                            if ($row = $result->fetch_object()) {
                                                $total += ($row->quantita * $row->Prezzo);
                                            }
                                        }
                                        echo "	<small>$result->num_rows Item(s) selected</small>";
                                    }
                                    echo "<h5>SUBTOTAL: $total ???</h5>";
                                    echo "</div>"
                                    ?>
                                    <div class="cart-btns">
                                        <a href="Carello.php">View Cart</a>
                                        <a href="Checkout.php">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href='store.php?categoria=New'>New</a></li>
                    <li><a href='store.php?categoria=Hot Deals'>Hot Deals</a></li>
                    <li><a href='store.php?categoria=Electronics'>Electronics</a></li>
                    <li><a href='store.php?categoria=House'>House</a></li>
                    <li><a href='store.php?categoria=Motors'>Motors</a></li>
                    <li><a href='store.php?categoria=Top Selling'>Top Selling</a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->


    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <?php
                $sql = $conn->prepare("SELECT imgsrc,username,nome,cognome,stato,regione,provincia,citta,civico,cap, indirizzo.ID as ID,via FROM utente left join indirizzo on utente.ID = indirizzo.IdUtente WHERE utente.ID = ? ");
                $sql->bind_param('i', $_SESSION["IDutente"]);
                $sql->execute();
                $result = $sql->get_result();

                if ($result !== false && $result->num_rows > 0) {
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        if ($row = $result->fetch_object()) {
                            if ($i == 0) {
                                echo '<div class="product-img">';
                                echo "<img src='./imgUtenti/$row->imgsrc' alt='immagine profilo' height='50' witdh='50'>";
                                echo '</div>';
                                echo '<div class="product-label">';
                                echo "<span class='new'>Username: $row->username</span>";
                                echo '</div>';
                                echo '<div class="product-label">';
                                echo "<span class='new'>Nome: $row->nome</span>";
                                echo '</div>';
                                echo '<div class="product-label">';
                                echo "<span class='new'>Cognome: $row->cognome</span>";
                                echo '</div>';
                            }
                            if($row->stato != null){
                            echo '<div class="product-label">';
                            echo "<span class='new'>Indirizzo: $row->stato - $row->regione - $row->provincia - $row->citta - $row->via - $row->civico - $row->cap </span>";
                            echo "<button type='submit' class='btn btn-link'><a href='DelIndirizzo.php?ID=$row->ID' class='primary-btn order-submit'>-</a></button>";
                            echo '</div>';
                            }
                        }
                    }
                }
                ?>
                <button type="submit" class="btn btn-link"><a href="Logout.php" class="primary-btn order-submit">Logout</a></button>
                <button type="submit" class="btn btn-link"><a href="AddIndirizzo.php" class="primary-btn order-submit">Aggiungi Indirizzo</a></button>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- FOOTER -->
    <footer id="footer">
        <!-- top footer -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-4 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Skamazon ?? una piccola azienda ideata da un ragazzo molto pigro</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>Via inventata</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>Numero Bello</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>emailBella@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="index.php">Home</a></li>
                                <li><a href='store.php?categoria=New'>New</a></li>
                                <li><a href='store.php?categoria=Hot Deals'>Hot Deals</a></li>
                                <li><a href='store.php?categoria=Electronics'>Electronics</a></li>
                                <li><a href='store.php?categoria=House'>House</a></li>
                                <li><a href='store.php?categoria=Motors'>Motors</a></li>
                                <li><a href='store.php?categoria=Top Selling'>Top Selling</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-4 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="account.php">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="img/troll.jpg">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->

        <!-- bottom footer -->
        <div id="bottom-footer" class="section">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>