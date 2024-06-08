<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aggiungi Inserzione</title>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/insertionstyle.css"/>
    <script src="js/insertion.js" defer></script>
    </head>
  <body>
    <section class="container">
      <header>Inserisci Annuncio</header>
      <form class="form" action="..\insertion_manager.php" method="POST" enctype="multipart/form-data">
        <div class="input-box">
          <label><strong>Titolo *</strong></label>
          <input type="text" class="title" name="titolo" placeholder="Titolo" maxlength="50" required onkeyup="countChar(this, 50,1);">
          <span class="charleft" id="charleft1" style="left: 705px">50/50</span>
        </div>

        <div class="input-box">
          <label><strong>Descrizione</strong></label>
          <textarea id="descrizione" name="descrizione" class="description" placeholder="Inserisci una descrizione..." maxlength="300" onkeyup="countChar(this, 300,2);"></textarea>
          <span class="charleft" id="charleft2">300/300</span>
        </div>

        <div class="column">
          <div class="input-box">
            <label><strong>Posizione *</strong></label>
                <select id="posizione" class="selection" name="posizione" required>
                    <option value="">Seleziona Posizione</option>
                    <option value="Avellino">Avellino</option>
                    <option value="Benevento">Benevento</option>
                    <option value="Caserta">Caserta</option>
                    <option value="Napoli">Napoli</option>
                    <option value="Salerno">Salerno</option>
                </select>
          </div>
          <div class="input-box">
            <label><strong>Categoria *</strong></label>
                <select id="categoria" class="selection" name="categoria" required>
                    <option value="">Seleziona Categoria</option>
                    <option value="Elettronica">Elettronica</option>
                    <option value="Abbigliamento">Abbigliamento</option>
                    <option value="Libri">Libri</option>
                    <option value="Intrattenimento">Intrattenimento</option>
                    <option value="Collezionismo">Collezionismo</option>
                    <option value="Varie">Varie</option>
                </select>
          </div>
          <div class="input-box">
            <label><strong>Condizioni *</strong></label>
                <select id="condizioni" class="selection" name="condizioni" required>
                    <option value="">Seleziona Condizioni</option>
                    <option value="Nuovo">Nuovo</option>
                    <option value="Come Nuovo">Come Nuovo</option>
                    <option value="Buone Condizioni">Buone Condizioni</option>
                    <option value="Discrete Condizioni">Discrete Condizioni</option>
                </select>
          </div>
        </div>
        <div class="upload-container">
            <label class="custum-file-upload" for="immagini">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
            </div>
            <div class="text">
                <span>Carica Immagini (max. 5)</span>
            </div>
            <input type="file" id="immagini" name="immagini[]" accept="image/*" multiple>
            </label>
            <label class="file-label" id="fileLabel" readonly></label>
            <div class="alert alert-danger mt-2" id="errorMessage" style="display: none; width: 300px;">Attenzione: limite caricamento immagini superato</div>
        </div>
        

        <button>Inserisci Annuncio</button>
      </form>
    </section>
  </body>
</html>
