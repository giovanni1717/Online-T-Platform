<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richieste di trattativa</title>
    <link rel="stylesheet" type="text/css" href="../LoggedIn/css/cardstyles.css">
    <link rel="stylesheet" href="../LoggedIn/css/dropdown.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"> 
    <link rel="stylesheet" href="../LoggedIn/css/Searchbar.css">
    <script src="../LoggedIn/js/backPage.js" defer></script>
    <script src="../LoggedIn/js/Searchbar.js" defer></script>
</head>
<body>
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
                    <input type="text" id="search-input" <?php if($_GET["is_it_a_sent_request"] === "true"): ?> placeholder="<?php echo "Le mie richieste inviate";?> " <?php else: ?> placeholder="<?php echo "Le mie richieste ricevute"; endif;?> " onkeyup="enablesearch()">
                        <a id="searchBtn" style="color: #57b846"><i id="mag-glass" class="fa-solid fa-magnifying-glass"></i></a>
                </div> 
            </div>
        </div>
        <a id="indietro" style="color: #fff"><i class="fa-solid fa-arrow-left" style="position: absolute; top: 40px; right: 1140px; font-size: 25px;"></i></a>
        <a href="..\LoggedIn\HomePage.php" style="color: #fff"><i class="fa-solid fa-house" style="position: absolute; top: 40px; right: 380px; font-size: 20px;"></i></a>
        <a href="Profile.php" style="color: #fff"><i class="fa-solid fa-user" style="position: absolute; top: 40px; right: 340px; font-size: 20px;"></i></a>
        <a href="..\LoggedIn\add_insertion.php" style="color: #fff"><i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; top: 40px; right: 300px; font-size: 20px;"></i></a>
    </div>
    

    <div class="card-container" style="position: absolute; top: 30px">
        <?php include 'get_trade_requests.php'; ?>
            <?php if(isset($performedquery) && !empty($searchResults)): ?>
                <?php foreach ($searchResults as $result) : ?>
                    <?php if($_SESSION["is_it_a_sent_request"] === "false"){ ?> 
                    <div class="card" style="width: 390px">
                    <?php
                        }else{ ?>
                        <div class="card">
                        <?php 
                        } ?>
                        <img src="<?php echo "../" . $result[1]; ?>">
                        <div class="card-content">
                            <h3><?php echo $result[0]; ?></h3>
                            <p>In <?php if($_SESSION["is_it_a_sent_request"] === "true"): echo $result[3]; else: echo $result[4]; endif;?></p>
                            <?php if($_SESSION["is_it_a_sent_request"] === "false"){ ?> 
                                <p>Da <a href="../Profile/view_reviews.php?username=<?=$result[3];?>" style="color: #FF9F00"><?php echo $result[3]; ?></a></p>  
                                <a href="../LoggedIn/view_insertion.php?ID=<?= $result[2] ?>" class="btn" style="margin-top: 10px; margin-right: 5px">Visualizza</a>
                                <a href="../OtherUsers/view_user_offers.php?username_richiedente=<?= $result[3] ?>&annuncio_richiesto=<?= $result[2] ?>" class="btn" style="margin-top: 10px; margin-right: 5px; width: 111px;">Rispondi</a>
                                <a href="../LoggedIn/reject_offer.php?username_richiedente=<?= $result[3] ?>&annuncio_richiesto=<?= $result[2] ?>" class="btn" style="margin-top: 10px; width: 111px;">Rifiuta</a>
                            <?php
                            } else{ ?>
                                <p><?php echo "Di " . $result[4]; ?></p>
                                <a href="../LoggedIn/view_insertion.php?ID=<?= $result[2] ?>" class="btn" style="margin-top: 10px;">Visualizza</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php elseif(isset($performedquery) && empty($searchResults)): ?>
                <p class="no-results">Oops! Nessun risultato</p>
            <?php
            endif;
            ?>

    </div>

</body>

</html>

