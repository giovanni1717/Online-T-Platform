<!DOCTYPE html>
<html lang="it">
    <head>
        <?php include 'get_profile_info.php' ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profilo Utente</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/profile.css">
    </head>
    <body>
        <div class="container">
            <div class="main">
                <div class="topbar">
                    <a href="../LoggedIn/LogOut.php">Logout</a>
                    <a href="../LoggedIn/HomePage.php">Home</a>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-1">
                        <div class="card text-center sidebar">
                            <div class="card-body">
                                <img src="img/user.png" clas="rounded-circle" width="150">
                                <div class="column-elements mt-3">
                                        <h3><?php echo $info["nome"]; ?></h3>
                                        <a class="profile-element" href="../LoggedIn/searchresults.php?personal_insertions=true">I miei annunci</a>
                                        <a class="profile-element" href="view_trade_requests.php?is_it_a_sent_request=true">Le mie richieste inviate</a>
                                        <a class="profile-element" href="view_trade_requests.php?is_it_a_sent_request=false">Le mie richieste ricevute</a>
                                        <a class="profile-element" href="view_trade_propositions.php?is_it_a_sent_request=true">Le mie proposte inviate</a>
                                        <a class="profile-element" href="view_trade_propositions.php?is_it_a_sent_request=false">Le mie proposte ricevute</a>
                                        <a class="profile-element" href="view_completed_trades.php">I miei scambi</a>
                                        <a class="profile-element" href="view_reviews.php?username=<?= $_SESSION["username"] ?>">Le mie recensioni</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mt-1">
                        <div class="card mb-3 content">
                            <h1 class="m-3 pt-3">About</h1>
                            <div class="card-body">
                                <div class="row">
                                    <div class="info col-md-3">
                                        <h5><strong>Nome:</strong></h5>
                                    </div>
                                    <div class="info col-md-9 text-secondary">
                                        <?php echo $info["nome"] . " " . $info["cognome"]; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="info col-md-3">
                                        <h5><strong>Username:</strong></h5>
                                    </div>
                                    <div class="info col-md-9 text-secondary">
                                        <?php echo $info["username"]; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="info col-md-3">
                                        <h5><strong>Email:</strong></h5>
                                    </div>
                                    <div class="info col-md-9 text-secondary">
                                        <?php echo $info["email"]; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="info col-md-3">
                                        <h5><strong>Valutazione:</strong></h5>
                                    </div>
                                    <div class="info col-md-9 text-secondary">
                                        <?php 
                                            if ($info["ValutazioneMedia"] === NULL) {
                                                echo 'Nessuna recensione'; ?>
                                        <?php
                                            } else {
                                                echo $info["ValutazioneMedia"] . "/5";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>