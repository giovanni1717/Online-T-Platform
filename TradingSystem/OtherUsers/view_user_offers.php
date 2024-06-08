<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Offerte Utente</title>
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
                    <input type="text" id="search-input" placeholder="Offerte <?php if(isset($_GET["username_richiedente"])) echo "di " . $_GET["username_richiedente"] ?>" onkeyup="enablesearch()">
                        <a id="searchBtn" style="color: #57b846"><i id="mag-glass" class="fa-solid fa-magnifying-glass"></i></a>
                </div> 
            </div>
        </div>
        <a id="indietro" style="color: #fff"><i class="fa-solid fa-arrow-left" style="position: absolute; top: 40px; right: 1140px; font-size: 25px;"></i></a>
        <a href="..\LoggedIn\HomePage.php" style="color: #fff"><i class="fa-solid fa-house" style="position: absolute; top: 40px; right: 380px; font-size: 20px;"></i></a>
        <a href="..\Profile\Profile.php" style="color: #fff"><i class="fa-solid fa-user" style="position: absolute; top: 40px; right: 340px; font-size: 20px;"></i></a>
        <a href="..\LoggedIn\add_insertion.php" style="color: #fff"><i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; top: 40px; right: 300px; font-size: 20px;"></i></a>
    </div>



    <div class="card-container" style="position: absolute; top: 30px;">
        <?php include 'get_available_user_offers.php'; ?>
        <?php if(isset($performedsearch) && !empty($searchResults)): ?>
            <?php foreach ($searchResults as $result) : ?>
                <div class="card">
                    <img src="<?php echo "../" . $result[1]; ?>">
                    <div class="card-content">
                        <h3><?php echo $result[0]; ?></h3>
                        <p>In <?php echo $result[3]; ?></p>
                        <a href="../LoggedIn/view_insertion.php?ID=<?= $result[2] ?>" class="btn">Visualizza</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif(isset($performedsearch) && empty($searchResults)): ?>
            <p class="no-results">Oops! Nessun risultato</p>
        <?php else: 
                header('Location: ../LoggedIn/unauthorized.php', 401);
                exit;
              endif; ?>
    </div>
</body>
</html>
