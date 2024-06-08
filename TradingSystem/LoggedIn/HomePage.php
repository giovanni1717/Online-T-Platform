<!DOCTYPE html>
<html lang="it">
<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (!isset($_SESSION['is_logged_in'])) {
            // Redirect a pagina di non autorizzazione
            header('Location: ../Authentication/unauthorized.php', 401);
            exit;
        }
    ?>
<head>
<title>Homepage</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/dropdown.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"> 
    <link rel="stylesheet" href="css/Searchbar.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" type="text/css" href="css/cardstyles.css">
    <link rel="stylesheet" type="text/css" href="css/welcome_text.css">
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/backPage.js" defer></script>
    <script src="js/Searchbar.js" defer></script>

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
                    <input type="text" id="search-input" placeholder="Cerca..." onkeyup="enablesearch()">
                        <a id="searchBtn" style="color: #57b846"><i id="mag-glass" class="fa-solid fa-magnifying-glass"></i></a>
                </div> 
            </div>
        </div>
        <a id="indietro" style="color: #fff"><i class="fa-solid fa-arrow-left" style="position: absolute; top: 40px; right: 1140px; font-size: 25px;"></i></a>
        <a href="..\Profile\Profile.php" style="color: #fff"><i class="fa-solid fa-user" style="position: absolute; top: 40px; right: 380px; font-size: 20px;"></i></a>
        <a href=".\add_insertion.php" style="color: #fff"><i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; top: 40px; right: 340px; font-size: 20px;"></i></a>
    </div>

    <div class="welcome-text"><h1>Benvenuto, <?php echo $_SESSION["username"]; ?>! Dai un'occhiata agli ultimi annunci:</h1></div>

    <div class="card-container" style="position: absolute; top: 150px;">
        <?php include 'get_homepage_asset.php'; ?>
        <?php if(isset($performedsearch) && !empty($searchResults)): ?>
            <?php foreach ($searchResults as $result) : ?>
                <div class="card">
                    <img src="<?php echo "../" . $result[1]; ?>">
                    <div class="card-content">
                        <h3><?php echo $result[0]; ?></h3>
                        <p>In <?php echo $result[3]; ?></p>
                        <a href="view_insertion.php?ID=<?= $result[2] ?>" class="btn">Visualizza</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif(isset($performedsearch) && empty($searchResults)): ?>
            <p class="no-results">Sei il primo qui!</p>
        <?php else: 
                header('Location: unauthorized.html', 400);
                exit;
              endif; ?>

    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show floating-alert" role="alert">
            <strong>Attenzione:</strong>
            <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show floating-alert" role="alert">
            <?php echo htmlspecialchars(urldecode($_GET['success'])); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


</body>

</html>
