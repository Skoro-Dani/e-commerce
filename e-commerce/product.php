<?php
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
		<!-- TOP HEADER -->
		<?php
		HeaderadminProduct($_GET["ID"]);
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
										VisualizzaCarrelloTendina();
										?>
									</div>
									<?php
									VisualizzaCarrelloRisultato();
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
					<li><a href="index.php">Home</a></li>
					<?php
					if (isset($_GET["categoria"])) {
						$categoria = $_GET["categoria"];
						if ($categoria == "New") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=New'>New</a></li>";

						if ($categoria == "Hot Deals") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=Hot Deals'>Hot Deals</a></li>";

						if ($categoria == "Electronics") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=Electronics'>Electronics</a></li>";

						if ($categoria == "House") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=House'>House</a></li>";

						if ($categoria == "Motors") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=Motors'>Motors</a></li>";

						if ($categoria == "Top Selling") echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='store.php?categoria=Top Selling'>Top Selling</a></li>";
					}
					?>
				</ul>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->

	<!-- BREADCRUMB -->
	<div id="breadcrumb" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb-tree">
						<li><a href="index.php">Home</a></li>
						<li><a href="store.php">All Categories</a></li>
						<li class="active">
							<?php
							StampBreadCumb();
							?>
						</li>
					</ul>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /BREADCRUMB -->

	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- Product main img -->
				<div class="col-md-5 col-md-push-2">
					<div id="product-main-img">
						<?php
						stampIMG();
						?>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product thumb imgs -->
				<div class="col-md-2  col-md-pull-5">
					<div id="product-imgs">
						<?php
						stampIMG();
						?>
					</div>
				</div>
				<!-- /Product thumb imgs -->

				<!-- Product details -->
				<div class="col-md-5">
					<div class="product-details">
						<?php
						StampProdotto($_GET["ID"]);
						?>

					</div>
				</div>
				<!-- /Product details -->

				<!-- Product tab -->
				<div class="col-md-12">
					<div id="product-tab">
						<!-- product tab nav -->
						<ul class="tab-nav">
							<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
							<li><a data-toggle="tab" href="#tab2">Details</a></li>
							<li><a data-toggle="tab" href="#tab3">Reviews</a></li>
						</ul>
						<!-- /product tab nav -->

						<!-- product tab content -->
						<div class="tab-content">
							<!-- tab1  -->
							<div id="tab1" class="tab-pane fade in active">
								<div class="row">
									<div class="col-md-12">
										<?php
										$sql = $conn->prepare("SELECT * FROM articoli WHERE ID = ?");
										$sql->bind_param('i', $_GET["ID"]);
										$sql->execute();
										$result = $sql->get_result();
										if ($result !== false && $result->num_rows > 0) {
											if ($row = $result->fetch_object()) {
												echo "<p>$row->DescShort</p>";
											}
										}
										?>
									</div>
								</div>
							</div>
							<!-- /tab1  -->

							<!-- tab2  -->
							<div id="tab2" class="tab-pane fade in">
								<div class="row">
									<div class="col-md-12">
										<?php
										$sql = $conn->prepare("SELECT * FROM articoli WHERE ID = ?");
										$sql->bind_param('i', $_GET["ID"]);
										$sql->execute();
										$result = $sql->get_result();
										if ($result !== false && $result->num_rows > 0) {
											if ($row = $result->fetch_object()) {
												echo "<p>$row->DescLong</p>";
											}
										}
										?>
									</div>
								</div>
							</div>
							<!-- /tab2  -->

							<!-- tab3  -->
							<div id="tab3" class="tab-pane fade in">
								<div class="row">
									<!-- Rating -->
									<div class="col-md-3">
										<div id="rating">
											<?php
											$sql = $conn->prepare("SELECT * FROM articoli join commento on articoli.ID=commento.IdArticolo join utente on commento.IdUtente = utente.ID WHERE articoli.ID = ?");
											$sql->bind_param('i', $_GET["ID"]);
											$sql->execute();
											$result = $sql->get_result();
											$AVGstelle = 0;
											$stelle[1] = 0;
											$stelle[2] = 0;
											$stelle[3] = 0;
											$stelle[4] = 0;
											$stelle[5] = 0;
											$maxStelle = 0;
											if ($result !== false && $result->num_rows > 0) {
												for ($j = 0; $j < $result->num_rows; $j++) {
													if ($row = $result->fetch_object()) {
														$AVGstelle += $row->stelleCommento;
														switch ($row->stelleCommento) {
															case 1:
																$stelle[1]++;
																break;
															case 2:
																$stelle[2]++;
																break;
															case 3:
																$stelle[3]++;
																break;
															case 4:
																$stelle[4]++;
																break;
															case 5:
																$stelle[5]++;
																break;
																echo $row->stelleCommento;
														}
														$maxStelle++;
													}
												}
												$AVGstelle = $AVGstelle / $maxStelle;
											}
											echo '<div class="rating-avg">';
											echo "<span>$AVGstelle</span>";
											echo '<div class="rating-stars">';
											for ($i = 0; $i < 5; $i++) {
												if ($i < $AVGstelle) echo '<i class="fa fa-star"></i>';
												else echo '<i class="fa fa-star-o"></i>';
											}
											echo '</div>';
											echo '</div>';

											echo '<ul class="rating">';
											for ($j = 5; $j > 0; $j--) {
												if ($stelle[$j] > 0) $progress = ($stelle[$j] / $maxStelle) * 100;
												else $progress = 0;
												echo '<li>';
												echo '<div class="rating-stars">';
												for ($i = 0; $i < 5; $i++) {
													if ($i < $j) echo '<i class="fa fa-star"></i>';
													else echo '<i class="fa fa-star-o"></i>';
												}
												echo '</div>';
												echo '<div class="rating-progress">';

												echo "<div style='width: $progress%;'></div>";
												echo '</div>';
												echo "<span class='sum'>$j</span>";
												echo '</li>';
											}
											echo '</ul>';
											?>
										</div>
									</div>
									<!-- /Rating -->
									<!-- Reviews -->
									<div class="col-md-6">
										<div id="reviews">
											<ul class="reviews">
												<?php
												$sql = $conn->prepare("SELECT * FROM articoli join commento on articoli.ID=commento.IdArticolo join utente on commento.IdUtente = utente.ID WHERE articoli.ID = ?");
												$sql->bind_param('i', $_GET["ID"]);
												$sql->execute();
												$result = $sql->get_result();
												if ($result !== false && $result->num_rows > 0) {
													for ($j = 0; $j < $result->num_rows; $j++) {
														if ($row = $result->fetch_object()) {
															echo '<li>';
															echo '<div class="review-heading">';
															echo "<h5 class='name'>$row->username";
															if ($row->AcquistoVerificato == 1) echo "<img src='img/verificato.png'>";
															echo '</h5>';
															echo '<div class="review-rating">';

															for ($i = 0; $i < 5; $i++) {
																if ($i < $row->stelleCommento) echo '<i class="fa fa-star"></i>';
																else echo '<i class="fa fa-star-o"></i>';
															}
															echo '</div>';
															echo '</div>';
															echo '<div class="review-body">';
															echo "<p>$row->testo</p>";
															echo '</div>';
															echo '</li>';
														}
													}
												}
												?>
											</ul>
										</div>
									</div>
									<!-- /Reviews -->
									<!-- Review Form -->
									<div class="col-md-3">
										<div id="review-form">
											<?php
											if (isset($_SESSION["IDutente"])) echo '<form class="review-form" action="AggiungiRecensione.php" method="POST">';
											else echo '<form class="review-form" action="Login.php">';
											?>
											<textarea class="input" placeholder="Your Review" name="testo"></textarea>
											<input type='hidden' name='IDarticolo' value="<?php echo $_GET["ID"]; ?>">
											<div class="input-rating">
												<span>Your Rating: </span>
												<div class="stars">
													<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
													<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
													<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
													<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
													<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
												</div>
											</div>
											<button class="primary-btn" type="submit">Submit</button>
											</form>
										</div>
									</div>
									<!-- /Review Form -->
								</div>
								<!-- /tab3  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="products-tabs">

						<div class="col-md-12">
							<div class="section-title text-center">
								<h3 class="title">Related Products</h3>
							</div>
						</div>
						<div class="col-md-12">
							<div class="products-slick" data-nav="#slick-nav-1">
								<?php
								StampProduct();
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->
	</div>
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
							<p>Skamazon è una piccola azienda ideata da un ragazzo molto pigro</p>
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
	<script>
		function ModificaQuantitia() {
			let InseririsciQuantitia = prompt("Sicuro di voler Eliminare il Prodotto");
			let text;
			if (InseririsciQuantitia == null || InseririsciQuantitia == "") {
				text = "";
			} else {
				$.ajax({
					// definisco il tipo della chiamata
					type: "GET",
					// specifico la URL della risorsa da contattare
					url: "ADDQuantita.php",
					// passo dei dati alla risorsa remota
					data: "Quantita=" + InseririsciQuantitia,
					// definisco il formato della risposta
					dataType: "html",
					// imposto un'azione per il caso di successo
					success: function(risposta) {
						$("div#risposta").html(risposta);
					},
					// ed una per il caso di fallimento
					error: function() {
						alert("Chiamata fallita!!!");
					}
				});
			}
		}

		function DElProdotto() {
			if (confirm("Vuoi Eliminare questo prodotto?")) {
				$.get("Elimina.php",{ID: <?php echo $_GET["ID"];?>},(data,stato)=>{},true);
			}
		}
	</script>

</body>

</html>