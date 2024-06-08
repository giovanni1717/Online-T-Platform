<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/reviewcard.css" rel="stylesheet">
    <link rel="stylesheet" href="../LoggedIn/css/Searchbar.css">
    <link rel="stylesheet" href="../LoggedIn/css/dropdown.css">
	<title>Lascia recensione</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
                    <input type="text" id="search-input" placeholder="Cerca..." onkeyup="enablesearch()">
                        <a id="searchBtn" style="color: #57b846"><i id="mag-glass" class="fa-solid fa-magnifying-glass"></i></a>
                </div> 
            </div>
        </div>
        <a id="indietro" style="color: #fff"><i class="fa-solid fa-arrow-left" style="position: absolute; top: 40px; right: 1140px; font-size: 25px;"></i></a>
        <a href="..\LoggedIn\HomePage.php" style="color: #fff"><i class="fa-solid fa-house" style="position: absolute; top: 40px; right: 380px; font-size: 20px;"></i></a>
        <a href="Profile.php" style="color: #fff"><i class="fa-solid fa-user" style="position: absolute; top: 40px; right: 340px; font-size: 20px;"></i></a>
        <a href="..\LoggedIn\add_insertion.php" style="color: #fff"><i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; top: 40px; right: 300px; font-size: 20px;"></i></a>
    </div>

    <?php include 'get_reviews.php'; ?>

    <div class="card-container" style="position: absolute; top: 30px;">
    <?php if(isset($performedquery) && !empty($reviews)): ?>
        <?php foreach ($reviews as $review) : ?> 
            <?php if($review["Rating"] > 2){ ?>
                <div class="good-review-card">
            <?php
            }else{ ?>
                <div class="bad-review-card">
            <?php
            }
            ?> 
            <div class="image_review">
                <div class="customer_image">
                    <img src="img/user.png">
                </div>

                <div class="customer_name_review_status">
                    <div class="reviewer"><?php echo $review["utente_scrivente"];?> il <?php echo $review["Data"];?></div>
                    <div class="customer_review">
                    <?php for($i = 0; $i < $review["Rating"]; $i++){ ?>
                        <i class="fa-solid fa-star"></i>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
            <div class="customer_comment"><?php if($review["Testo"] !== "") echo $review["Testo"]; else echo "Recensione senza testo"?></div>
        </div>
        <?php endforeach; ?>
        <?php elseif(isset($performedquery) && empty($annunci)): ?>
                <p class="no-results">Oops! Nessuna recensione qui!</p>
            <?php
            endif;
            ?>
    </div>
        
</body>
</html>