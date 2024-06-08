<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposte di Scambio</title>
    <link rel="stylesheet" type="text/css" href="css/tradepropositionscardstyles.css">
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
                    <input type="text" id="search-input" placeholder="<?php if($_GET["is_it_a_sent_request"] === "true"): echo "Le mie proposte inviate"; else: echo "Le mie proposte ricevute"; endif;?>" onkeyup="enablesearch()">
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
        <?php include 'get_trade_propositions.php';
            if($_GET["is_it_a_sent_request"] === "true") $value = 0;
            else $value = 1;
        ?>
            <?php if(isset($performedquery) && !empty($annunci)): ?>
                <?php foreach ($annunci as $coppia_annunci) : ?> 
                    <div class="double-card-container">
                <?php if($_GET["is_it_a_sent_request"] === "true"){ ?>
                        <div class="double-card" style="height: 530px;">
                <?php }else{ ?>
                        <div class="double-card">
                <?php } ?>
                            <h2 class="double-card-title">PROPOSTA SCAMBIO CON <?php if($value === 0) echo $coppia_annunci[1 - $value][0]; else echo $coppia_annunci[$value][0]; ?>, IN DATA: <?php echo $coppia_annunci[2]; ?></h2>
                            <div class="card-wrapper">
                            <div class="card">
                                <img src="../<?php echo $coppia_annunci[$value][1]; ?>">
                                <div class="card-content">
                                    <h3><?php echo $coppia_annunci[$value][0]; ?></h3>
                                    <p>In <?php echo $coppia_annunci[$value][3]; ?></p>
                                    <p>Di <a href="../Profile/view_reviews.php?username=<?=$coppia_annunci[$value][4];?>" style="color: #FF9F00"><?php echo $coppia_annunci[$value][4]; ?></a></p>
                                <a href="../LoggedIn/view_insertion.php?ID=<?= $coppia_annunci[$value][2] ?>" class="btn">Visualizza</a>
                                </div>
                            </div>
                            <img src="img/arrows.png" clas="rounded-circle" width="150" height="150" style="margin-top: 150px">
                            <div class="card" style="margin-left: 30px;">
                                <img src="../<?php echo $coppia_annunci[1 - $value][1]; ?>">
                                <div class="card-content">
                                    <h3><?php echo $coppia_annunci[1 - $value][0]; ?></h3>
                                    <p>In <?php echo $coppia_annunci[1 - $value][3]; ?></p>
                                    <p>Di <a href="../Profile/view_reviews.php?username=<?=$coppia_annunci[1 - $value][4];?>" style="color: #FF9F00"><?php echo $coppia_annunci[1 - $value][4]; ?></a></p>
                                <a href="../LoggedIn/view_insertion.php?ID=<?= $coppia_annunci[1 - $value][2] ?>" class="btn">Visualizza</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <?php if($_GET["is_it_a_sent_request"] === "false"){?>
                            <div class="button-container">
                                <a href="reject_trade.php?annuncio_proposto=<?=$coppia_annunci[$value][2] ?>&annuncio_richiesto=<?= $coppia_annunci[1 - $value][2] ?>" class="btn" style="margin-left: 400px">Rifiuta Scambio</a>
                                <a href="accept_trade.php?annuncio_proposto=<?=$coppia_annunci[$value][2] ?>&annuncio_richiesto=<?= $coppia_annunci[1 - $value][2] ?>" class="btn">Accetta Scambio</a>
                            </div>
                        <?php
                            } 
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php elseif(isset($performedquery) && empty($annunci)): ?>
                <p class="no-results">Oops! Nessun risultato</p>
            <?php
            endif;
            ?>


    </div>

</body>

</html>

