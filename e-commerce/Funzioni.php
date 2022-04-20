<?php
$numElementi = 0;
function StampArticoli($filtro)
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Categorie like Concat('%','$filtro','%') ");
    $sql->execute();
    $result = $sql->get_result();

    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="product">';
                echo '<div class="product-img">';
                echo "<img src='./img/$row->source' alt=''>";
                echo '<div class="product-label">
													  <span class="new">NEW</span>
												  	  </div>';
                echo '</div>';
                echo '<div class="product-body">';
                echo '<p class="product-category">Category</p>';
                echo "<h3 class='product-name'><a href='product.php?ID=$row->ID'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '<div class="product-rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $row->stelle) echo '<i class="fa fa-star"></i>';
                    else echo '<i class="fa fa-star-o"></i>';
                }
                echo '</div>';
                echo '<div class="product-btns">
												  <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
											      </div>
											      </div>';
                echo '<div class="add-to-cart">';

                if ($row->QuantitaDisp > 0) {
                    echo "<a href='AddProduct.php?IDarticolo=$row->ID&quantita=1&Pagina=index.php'>";
                    echo '<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>';
                    echo '</a>';
                } else
                    echo '<div class="footer"><h6 class="footer-title">Scorte Finite</h6></div>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}
function StampArticoliWidget($filtro)
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Categorie like Concat('%','$filtro','%') ");
    $sql->execute();
    $result = $sql->get_result();

    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="product-widget">';
                echo '	<div class="product-img">';
                echo "		<img src='img/$row->source' alt=''>";
                echo '	</div>';
                echo '	<div class="product-body">';
                echo '		<p class="product-category">Category</p>';
                echo "		<h3 class='product-name'><a href='product.php?ID=$row->ID'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '	</div>';
                echo '</div>';
            }
        }
    }
}
function StampArticoliStore($OrderBy, $SearchBar, $page, $Categoria)
{
    //dichiarazioni
    include("SetUp/connection.php");
    global $numElementi;
    //SQL
    if ($SearchBar != "" && $Categoria != "") {
        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Nome like Concat('%',?,'%') &&  Categorie like Concat('%',?,'%') " . $OrderBy);
        $sql->bind_param("ss", $SearchBar, $Categoria);
    } else if ($SearchBar != "" && $Categoria == "") {
        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Nome like Concat('%',?,'%')" . $OrderBy);
        $sql->bind_param("s", $SearchBar);
    } else if ($SearchBar == "" && $Categoria != "") {
        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Categorie like Concat('%',?,'%') " . $OrderBy);
        $sql->bind_param("s", $Categoria);
    } else {
        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID " . $OrderBy);
    }

    $sql->execute();
    $result = $sql->get_result();
    //SETUP PAgine
    $Fine = 20;
    $start = 0;
    //AGGIORNO I NUMERI DI ELEMENTI PER LE PAGNE
    $numElementi = $result->num_rows;
    if ($result !== false && $result->num_rows > 0) {
        if ($page != "") {
            $Fine = $Fine * $_GET["page"];
            $start = ($_GET["page"] * 20) - 20;
        }
        for ($j = $start; $j < $result->num_rows && $j < $Fine; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="col-md-4 col-xs-6">';
                echo '<div class="product">';
                echo '<div class="product-img">';
                echo "<img src='./img/$row->source' alt=''>";
                echo '<div class="product-label">
                                  <span class="new">NEW</span>
                                    </div>';
                echo '</div>';
                echo '<div class="product-body">';
                echo '<p class="product-category">Category</p>';
                echo "<h3 class='product-name'><a href='product.php?ID=$row->ID'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '<div class="product-rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $row->stelle) echo '<i class="fa fa-star"></i>';
                    else echo '<i class="fa fa-star-o"></i>';
                }
                echo '</div>';
                echo '<div class="product-btns">
                              <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                              </div>
                              </div>';
                echo '<div class="add-to-cart">';

                if ($row->QuantitaDisp > 0) {
                    echo "<a href='AddProduct.php?IDarticolo=$row->ID&quantita=1&Pagina=index.php'>";
                    echo '<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>';
                    echo '</a>';
                } else
                    echo '<div class="footer"><h6 class="footer-title">Scorte Finite</h6></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}
function StampPaginazionePage()
{
    include("SetUp/connection.php");
    global $numElementi;
    $NPag = ceil($numElementi / 20);
    if (isset($_GET["page"]) && $_GET["page"] != null) $Pag = $_GET["page"];
    else $Pag = 1;

    for ($i = $Pag; $i < $NPag && $i < $Pag + 5; $i++) {
        if ($i == $Pag) echo "<li class='active'>$i</li>";
        else {
            echo "<li>";
            echo "<a href='store.php?";
            if (isset($_GET["categorie"])) echo "categorie=" . $_GET['categorie'] . "&";
            if (isset($_GET["SearchBar"])) echo "SearchBar=" . $_GET['SearchBar'] . "&";
            if (isset($_GET["OrderBy"])) echo "OrderBy=" . $_GET['OrderBy'] . "&";
            echo "page=$i";
            echo "'>$i</a></li>";
        }
    }

    echo "<li>";
    echo "<a href='store.php?";
    if (isset($_GET["categorie"])) echo "categorie=" . $_GET['categorie'] . "&";
    if (isset($_GET["SearchBar"])) echo "SearchBar=" . $_GET['SearchBar'] . "&";
    if (isset($_GET["OrderBy"])) echo "OrderBy=" . $_GET['OrderBy'] . "&";
    echo "page=$NPag";
    echo "'>$NPag</a></li>";
}
function VisualizzaCarrello()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM  contiene  join  articoli on contiene.IdArticolo = articoli.ID join imgsrc on articoli.ID = imgsrc.IDarticolo  where IdCarrello = " . $_SESSION['IDcarrello'] . " Group By articoli.ID ");
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="col-md-4 col-xs-6">';
                echo '<div class="product">';
                echo '<div class="product-img">';
                echo "<img src='./img/$row->source' alt=''>";
                echo '<div class="product-label">
													  <span class="new">NEW</span>
												  	  </div>';
                echo '</div>';
                echo '<div class="product-body">';
                echo '<p class="product-category">Category</p>';
                echo "<h3 class='product-name'><a href='product.php?ID=$row->IdArticolo'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '<div class="product-rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $row->stelle) echo '<i class="fa fa-star"></i>';
                    else echo '<i class="fa fa-star-o"></i>';
                }
                echo '</div>';
                echo '<div class="product-btns">
												  <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
											      </div>
											      </div>';
                echo '<div class="add-to-cart">';
                echo "<a href='DelFCart.php?IDarticolo=$row->IdArticolo&Pagina=Carello.php'>";
                echo '<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Remove From Cart</button>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}
function VisualizzaCarrelloNum()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT COUNT(*) as c FROM contiene WHERE IdCarrello = " . $_SESSION['IDcarrello']);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            if ($row->c > 0) {
                echo "<div class='qty'>";
                //echo $_SESSION["IDcarelloo"];
                echo $row->c;
                echo "</div>";
            }
        }
    }
}
function VisualizzaCarrelloTendina()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM  contiene  join  articoli on contiene.IdArticolo = articoli.ID join imgsrc on articoli.ID = imgsrc.IDarticolo  where IdCarrello = " . $_SESSION['IDcarrello'] . " Group By articoli.ID ");
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
                echo "		<h3 class='product-name'><a href='product.php?ID=$row->IDarticolo'>$row->Nome</a></h3>";
                echo "		<h4 class='product-price'><span class='qty'>$row->quantita x</span>$row->Prezzo €</h4>";
                echo '	</div>';
                echo '</div>';
            }
        }
    }
}
function VisualizzaCarrelloRisultato()
{
    include("SetUp/connection.php");
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
    echo "<h5>SUBTOTAL: $total €</h5>";
    echo "</div>";
}
function StampBreadCumb()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM articoli WHERE ID = ?");
    $sql->bind_param('i', $_GET["ID"]);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            echo $row->Nome;
        }
    }
}
function stampIMG()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM imgsrc	WHERE IDarticolo = ? ");
    $sql->bind_param('i', $_GET["ID"]);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="product-preview">';
                echo "		<img src='./img/$row->source' alt=''>";
                echo '	</div>';
            }
        }
    }
}
function StampProduct()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM articoli WHERE ID = ?");
    $sql->bind_param('i', $_GET["ID"]);
    $sql->execute();
    $result = $sql->get_result();
    $categoria = "";
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            $categoria = $row->Categorie;
        }
    }
    $categorie = $row->Categorie;
    $arr = explode(",", $categorie);
    for ($i = 0; $i < count($arr); $i++) {

        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.ID WHERE Categorie like Concat('%','$arr[$i]','%') ");
        $sql->execute();
        $result = $sql->get_result();

        if ($result !== false && $result->num_rows > 0) {
            for ($j = 0; $j < 4; $j++) {
                if ($row = $result->fetch_object()) {
                    echo '<div class="product">';
                    echo '<div class="product-img">';
                    echo "<img src='./img/$row->source' alt=''>";
                    echo '<div class="product-label"></div>';
                    echo '</div>';
                    echo '<div class="product-body">';
                    echo '<p class="product-category">Category</p>';
                    echo "<h3 class='product-name'><a href='product.php?ID=$row->ID'>$row->Nome</a></h3>";
                    if ($row->sconto != 0) {
                        $Sconto = ($row->Prezzo / 100) * $row->sconto;
                        $prezzo = $row->Prezzo - $Sconto;
                        echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                    } else {
                        echo "<h4 class='product-price'>$prezzo €</h4>";
                    }
                    echo '<div class="product-rating">';
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $row->stelle) echo '<i class="fa fa-star"></i>';
                        else echo '<i class="fa fa-star-o"></i>';
                    }
                    echo '</div>';
                    echo '<div class="product-btns">
									  <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
									  </div>
									  </div>';
                    echo '<div class="add-to-cart">';

                    if ($row->QuantitaDisp > 0) {
                        echo "<a href='AddProduct.php?IDarticolo=$row->ID&quantita=1&Pagina=index.php'>";
                        echo '<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>';
                        echo '</a>';
                    } else
                        echo '<div class="footer"><h6 class="footer-title">Scorte Finite</h6></div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    }
}
