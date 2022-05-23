<?php
//////////////////////////////
//Pagina che contiene tutte le parti php ripetute più volte
//////////////////////////////
$numElementi = 0;
$StelleArticoli;
//index.php
function StampArticoli($filtro)
{
    include("SetUp/connection.php");
    GetStelleArticoli();
    global $StelleArticoli;

    $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Categorie like Concat('%','$filtro','%') group by IDarticolo");
    $sql->execute();
    $result = $sql->get_result();

    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="product">';
                echo '<div class="product-img">';
                echo "<img src='./img/$row->source' alt=''>";
                echo '<div class="product-label">
													  <span class="new">' . $filtro . '</span>
												  	  </div>';
                echo '</div>';
                echo '<div class="product-body">';
                echo '<p class="product-category">Category</p>';
                echo "<h3 class='product-name'><a href='product.php?ID=$row->IDarticolo'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '<div class="product-rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $StelleArticoli[$row->IDarticolo]) echo '<i class="fa fa-star"></i>';
                    else echo '<i class="fa fa-star-o"></i>';
                }
                echo '</div>';
                echo '<div class="product-btns">
												  <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
											      </div>
											      </div>';
                echo '<div class="add-to-cart">';

                if ($row->QuantitaDisp > 0) {
                    echo "<a href='AddProduct.php?IDarticolo=$row->IDarticolo&quantita=1&Pagina=index.php'>";
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
//index.php
function StampArticoliWidget($filtro)
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Categorie like Concat('%','$filtro','%') group by IDarticolo");
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
                echo "		<h3 class='product-name'><a href='product.php?ID=$row->IDarticolo'>$row->Nome</a></h3>";
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
//Store.php
function StampArticoliStore($OrderBy, $SearchBar, $page, $Categoria)
{
    //dichiarazioni
    include("SetUp/connection.php");
    GetStelleArticoli();
    global $numElementi;
    global $StelleArticoli;
    //SQL
    if ($SearchBar != "" && $Categoria != "") {
        $sql = $conn->prepare("SELECT Nome,source,sconto,Prezzo,QuantitaDisp,IDarticolo FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Nome like Concat('%',?,'%') &&  Categorie like Concat('%',?,'%') group by IDarticolo" . $OrderBy);
        $sql->bind_param("ss", $SearchBar, $Categoria);
    } else if ($SearchBar != "" && $Categoria == "") {
        $sql = $conn->prepare("SELECT Nome,source,sconto,Prezzo,QuantitaDisp,IDarticolo FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Nome like Concat('%',?,'%') group by IDarticolo" . $OrderBy);
        $sql->bind_param("s", $SearchBar);
    } else if ($SearchBar == "" && $Categoria != "") {
        $sql = $conn->prepare("SELECT Nome source,sconto,Prezzo,QuantitaDisp,IDarticolo  FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Categorie like Concat('%',?,'%') group by IDarticolo" . $OrderBy);
        $sql->bind_param("s", $Categoria);
    } else {
        $sql = $conn->prepare("SELECT Nome,source,sconto,Prezzo,QuantitaDisp,IDarticolo FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo group by IDarticolo" . $OrderBy);
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
                echo '</div>';
                echo '<div class="product-body">';
                echo '<p class="product-category">Category</p>';
                echo "<h3 class='product-name'><a href='product.php?ID=$row->IDarticolo'>$row->Nome</a></h3>";
                if ($row->sconto != 0) {
                    $Sconto = ($row->Prezzo / 100) * $row->sconto;
                    $prezzo = $row->Prezzo - $Sconto;
                    echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                } else {
                    echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                }
                echo '<div class="product-rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $StelleArticoli["$row->IDarticolo"]) echo '<i class="fa fa-star"></i>';
                    else echo '<i class="fa fa-star-o"></i>';
                }
                echo '</div>';
                echo '<div class="product-btns">
                              <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                              </div>
                              </div>';
                echo '<div class="add-to-cart">';

                if ($row->QuantitaDisp > 0) {
                    echo "<a href='AddProduct.php?IDarticolo=$row->IDarticolo&quantita=1&Pagina=index.php'>";
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
//store.php
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
//carello.php
function VisualizzaCarrello()
{
    include("SetUp/connection.php");
    GetStelleArticoli();
    global $StelleArticoli;
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
                    if ($i < $StelleArticoli["$row->IDarticolo"]) echo '<i class="fa fa-star"></i>';
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
//carello numero elemnti
function VisualizzaCarrelloNum()
{
    include("SetUp/connection.php");
    if ($_SESSION["IDcarrello"]) {
        $sql = $conn->prepare("SELECT COUNT(*) as c FROM contiene WHERE IdCarrello = " . $_SESSION["IDcarrello"]);
        $sql->execute();
        $result = $sql->get_result();
        if ($result !== false && $result->num_rows > 0) {
            if ($row = $result->fetch_object()) {
                if ($row->c > 0) {
                    echo "<div class='qty'>";
                    echo $row->c;
                    echo "</div>";
                }
            }
        }
    } else {
        echo "<div class='qty'>";
        echo 1;
        echo "</div>";
    }
}
//carrello tendina
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
//carrello prezzo
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
//stamp nome elemento product.php
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
//product.php
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
//product.php
function StampProduct()
{
    include("SetUp/connection.php");
    GetStelleArticoli();
    global $StelleArticoli;
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

        $sql = $conn->prepare("SELECT * FROM articoli join imgsrc on articoli.ID = imgsrc.IDarticolo WHERE Categorie like Concat('%','$arr[$i]','%') ");
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
                    echo "<h3 class='product-name'><a href='product.php?ID=$row->IDarticolo'>$row->Nome</a></h3>";
                    if ($row->sconto != 0) {
                        $Sconto = ($row->Prezzo / 100) * $row->sconto;
                        $prezzo = $row->Prezzo - $Sconto;
                        echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
                    } else {
                        echo "<h4 class='product-price'>$row->Prezzo €</h4>";
                    }
                    echo '<div class="product-rating">';
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $StelleArticoli[$row->IDarticolo]) echo '<i class="fa fa-star"></i>';
                        else echo '<i class="fa fa-star-o"></i>';
                    }
                    echo '</div>';
                    echo '<div class="product-btns">
									  <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
									  </div>
									  </div>';
                    echo '<div class="add-to-cart">';

                    if ($row->QuantitaDisp > 0) {
                        echo "<a href='AddProduct.php?IDarticolo=$row->IDarticolo&quantita=1&Pagina=index.php'>";
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
//funzione che carica in un vettore tutte le stelle per ogni singolo elemento
function GetStelleArticoli()
{
    include("SetUp/connection.php");
    global $StelleArticoli;
    $count;
    $sql = $conn->prepare("SELECT articoli.ID as ID , stelleCommento as STELLE FROM articoli left join commento on articoli.ID = commento.IdArticolo");
    $sql->execute();
    $result = $sql->get_result();

    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                $valueStelle = 0;
                //controllo che le stelle non siano null
                if (!is_null($row->STELLE)) $valueStelle = $row->STELLE;
                //controllo che count non sia null e che esista
                if (!isset($count["$row->ID"])) $count["$row->ID"] = 0;
                //assegno i valori
                if (isset($StelleArticoli["$row->ID"])) {
                    $StelleArticoli["$row->ID"] +=  $valueStelle;
                    $count["$row->ID"] = $count["$row->ID"] + 1;
                } else {
                    $count["$row->ID"] = 1;
                    $StelleArticoli["$row->ID"] = $valueStelle;
                }
            }
        }
    }

    foreach ($StelleArticoli as $key => $value) {
        $StelleArticoli["$key"] = $value / $count["$key"];
    }
}
//pagina product.php
function StampProdotto($IDArticolo)
{
    include("SetUp/connection.php");
    GetStelleArticoli();
    global $StelleArticoli;
    $sql = $conn->prepare("SELECT * FROM articoli WHERE ID = ?");
    $sql->bind_param('i', $IDArticolo);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            echo "<form action='AddProduct.php' method='GET'>";
            echo "<input type='hidden' name='IDarticolo' value='$IDArticolo'>";
            echo "<input type='hidden' name='Pagina' value='product.php?ID=$IDArticolo'>";
            echo "<h2 class='product-name'>$row->Nome</h2>";
            echo '<div>
										<div class="product-rating">';
            for ($i = 0; $i < 5; $i++)
                if ($i < $StelleArticoli[$IDArticolo])    echo '<i class="fa fa-star"></i>';
                else echo '<i class="fa fa-star-o"></i>';
            echo '	</div>';
            echo '<a class="review-link" href="#review-form">10 Review(s) | Add your review</a>';
            echo '</div>';
            echo '<div>';
            if ($row->sconto != 0) {
                $Sconto = ($row->Prezzo / 100) * $row->sconto;
                $prezzo = $row->Prezzo - $Sconto;
                echo "<h4 class='product-price'>$prezzo €<del class='product-old-price'>$row->Prezzo €</del></h4>";
            } else {
                echo "<h4 class='product-price'> $row->Prezzo €</h4>";
            }

            if ($row->QuantitaDisp > 0) {
                echo '<span class="product-available">In Stock</span>';
                echo '</div>';
                echo "<p>$row->DescShort</p>";
                echo '<div class="add-to-cart"><div class="qty-label">Qty<div class="input-number">';
                echo '<select class="input-select" name="quantita">';
                $i = 1;
                while ($i < $row->QuantitaDisp + 1 && $i < 21) {
                    echo "<option>$i</option>";
                    $i++;
                }
                echo "</Select>";
                echo '</div></div><button class="add-to-cart-btn" type="submit"><i class="fa fa-shopping-cart"></i> add to cart</button></div>';
            } else {
                echo '<span class="product-available">Out of Stock</span>';
                echo '</div>';
            }
            echo '<ul class="product-links">';
            echo '<li>Category:</li>';
            $categorie = $row->Categorie;
            $arr = explode(",", $categorie);
            for ($i = 0; $i < count($arr); $i++)
                echo "<li><a href='store.php?categorie=$arr[$i]'>$arr[$i]</a></li>";
            echo '</ul>';
            echo "</form>";
        }
    }
}
//controlla se un prodotto è stato acquistato da un utente
function IsVerificato($IDarticolo, $IDutente)
{
    include("SetUp/connection.php");
    $verifica = 0;

    $sql = $conn->prepare("SELECT count(*) as c FROM ordine join carrello on carrello.ID =  ordine.IdCarrello join contiene on carrello.ID = contiene.IdCarrello WHERE contiene.IDarticolo = ? ");
    $sql->bind_param("i", $_POST["IDarticolo"]);

    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        $verifica = 1;
    }
    return $verifica;
}
//header admin per il prodotto
function HeaderadminProduct($IDprodotto)
{
    if (isset($_SESSION["IsAdmin"]) && $_SESSION["IsAdmin"] == 1) {
        echo '<div id="top-header">';
        echo '<div class="container">';
        echo '<ul class="header-links pull-right">';
        echo "<li><a onclick='DElProdotto()'><i class='fa fa-user-o'></i>Elimina Prodotto</a></li>";
        echo "<li><a onclick='ModificaQuantitia()'><i class='fa fa-user-o'></i>Aggiungi Quantita</a></li>";
        echo "<li><a href='AggiungiProdotto.php'><i class='fa fa-user-o'></i>Aggiungi Prodotto</a></li>";
        echo '</ul></div> </div>';
    }
}
//header admin per le altre pagine
function HeaderAdmin()
{
    if (isset($_SESSION["IsAdmin"]) && $_SESSION["IsAdmin"] == 1) {
        echo '<div id="top-header">';
        echo '<div class="container">';
        echo '<ul class="header-links pull-right">';
        echo "<li><a href='AggiungiProdotto.php'><i class='fa fa-user-o'></i>Aggiungi Prodotto</a></li>";
        echo '</ul></div> </div>';
    }
}
function isAdmin()
{
    if (isset($_SESSION["IsAdmin"]) && $_SESSION["IsAdmin"] == 1) return 1;
    else return 0;
}
function StampProductCheckOut()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM  contiene  join  articoli on contiene.IdArticolo = articoli.ID where IdCarrello = " . $_SESSION['IDcarrello']);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        echo '<div class="order-products">';
        for ($j = 0; $j < 4; $j++) {
            if ($row = $result->fetch_object()) {
                echo '<div class="order-col">';
                echo "<div>$row->quantita x $row->Nome</div>";
                echo "<div>$row->Prezzo €</div>";
                echo '</div>';
            }
        }
        echo '</div>';
    }
}

function CalcolaPrezzo()
{
    include("SetUp/connection.php");
    $sql = $conn->prepare("SELECT * FROM contiene  join  articoli on contiene.IdArticolo = articoli.ID WHERE IdCarrello = " . $_SESSION['IDcarrello']);
    $sql->execute();
    $result = $sql->get_result();
    $total = 0;

    if ($result !== false && $result->num_rows > 0) {
        for ($j = 0; $j < $result->num_rows; $j++) {
            if ($row = $result->fetch_object()) {
                $total += ($row->quantita * $row->Prezzo);
            }
        }
    }
    return $total;
}
