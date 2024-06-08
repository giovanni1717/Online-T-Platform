<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'prepare_view_insertion.php'; ?>
    <title><?php echo $row["Titolo"]; ?></title>
    <link rel = "stylesheet" href = "css/product_style.css">
    <link rel="stylesheet" href="css/Searchbar.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"> 
    

    <script src="js/backPage.js" defer></script>
    <script src = "js/product_script.js" defer></script>
    <script src="js/Searchbar.js" defer></script>
</head>
<body style="background-color: #f9f9f9">
    
    <div class="container" style="position: fixed; top: 0px; z-index: 1">
        <div class="white-rectangle" style="position: fixed; top: 20px; z-index: 1;">

            <div class="search-bar">
                <div class="dropdown">
                    <div id="drop-text" class="dropdown-text">
                        <span id="span">Categoria</span>
                        <i id="icon" class="fa-solid fa-chevron-down"></i>
                    </div>

                    <ul id="list" class="dropdown-list">
                        <li class="dropdown-list-item" default>Categoria</li>
                        <li class="dropdown-list-item">Elettronica</li>
                        <li class="dropdown-list-item">Abbigliamento</li>
                        <li class="dropdown-list-item">Libri</li>
                        <li class="dropdown-list-item">Intrattenimento</li>
                        <li class="dropdown-list-item">Collezionismo</li>
                        <li class="dropdown-list-item">Varie</li>
                    </ul>

                </div>



                <div class="search-box">
                    <input type="text" id="search-input" placeholder="<?php echo $row["Titolo"]; ?>" onkeyup="enablesearch()">
                        <a id="searchBtn" style="color: #57b846"><i id="mag-glass" class="fa-solid fa-magnifying-glass"></i></a>
                </div> 
            </div>
        </div>
        <a id="indietro" style="color: #fff"><i class="fa-solid fa-arrow-left" style="position: absolute; top: 40px; right: 1140px; font-size: 25px;"></i></a>
        <a href="..\LoggedIn\HomePage.php" style="color: #fff"><i class="fa-solid fa-house" style="position: absolute; top: 40px; right: 380px; font-size: 20px;"></i></a>
        <a href="..\Profile\Profile.php" style="color: #fff"><i class="fa-solid fa-user" style="position: absolute; top: 40px; right: 340px; font-size: 20px;"></i></a>
        <a href="..\LoggedIn\add_insertion.php" style="color: #fff"><i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; top: 40px; right: 300px; font-size: 20px;"></i></a>
    </div>

    <div class = "main-wrapper">
        <div class = "product-container">
            <div class = "product-div">
                <div class = "product-div-left">
                    <div class = "img-container">
                        <img src = "<?php echo $imagesResults[0]; ?>">
                    </div>
                    <div class = "hover-container">
                        <?php foreach ($imagesResults as $image): ?>
                            <div><img src = "<?php echo $image; ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class = "product-div-right">
                    <span class = "product-name"><?php echo $row["Titolo"]; ?></span>
                    <span class = "product-category">IN <?php echo strtoupper($row["Categoria"]); ?></span>
                    <p class = "product-description"><strong>Descrizione: </strong><?php if($row["Descrizione"] !== "") echo $row["Descrizione"]; else echo " nessuna descrizione" ?></p>
                    <span class = "product-conditions"><strong>Condizioni:</strong> <?php echo $row["Condizioni"]; ?></span>
                    <span class = "product-extra-info"><strong>Pubblicato a </strong> <?php echo $row["Luogo"]; ?> <strong> il </strong> <?php echo $row["Data"]; ?> <strong>da </strong><a href="../Profile/view_reviews.php?username=<?=$row["Utente"];?>" style="color: #FF9F00"><?php echo $row["Utente"]; ?></a></span>
                    <?php
                        if($_SESSION["username"] !== $row["Utente"] && $row["Visibile"] === 1){
                    ?>
                            <div class = "btn-groups">
                            <?php 
                                if($isTradeRequestActive && !isset($_SESSION["annuncio_richiesto"])){?>
                                    <button type = "submit" class = "add-cart-btn" disabled style="background-color: #fff; color: #FF9F00;"><i class = "fas fa-paper-plane"></i>Richiesta trattativa inviata</button>  
                            <?php 
                                }else if(isset($_SESSION["annuncio_richiesto"])){?>
                                    <form id="postForm" action="trade_proposition.php" method="get">
                                    <input type="hidden" id="annuncio_proposto" name="annuncio_proposto" value="<?= $row["ID"] ?>">
                                    <input type="hidden" id="annuncio_richiesto" name="annuncio_richiesto" value="<?= $_SESSION["annuncio_richiesto"] ?>">
                                    <button type = "submit" class = "add-cart-btn"><i class = "fas fa-paper-plane"></i>Invia Proposta di Scambio</button>
                            <?php
                                    unset($_SESSION["annuncio_proposto"]); unset($_SESSION["annuncio_richiesto"]);
                                    $_SESSION["proposition_sent"] = "true";
                                }
                                else{?>
                                    <form id="postForm" action="trade_request.php" method="post">
                                    <button type = "submit" class = "add-cart-btn"><i class = "fas fa-paper-plane"></i>Invia Richiesta Trattativa</button>
                                    </form>
                            <?php
                                }
                        }
                    ?>    
                </div>
            </div>
        </div>
    </div>


</body>
</html>


