
// Abilita / Disabilita bottone
function checkValues() {
    var submitButton = document.getElementById("submitButton");
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;

    var isPwOk = checkPassword();

    if(email === null || email === undefined || email.trim() === "") return;
    if(username === null || username === undefined || username.trim() === "") return;

    var isEmailOk = checkEmail(false);
    var isUsrnmOk = checkUsername(false);

    if (isPwOk && isUsrnmOk && isEmailOk) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

// Validazione Password
function checkPassword(isCheckLight) {
    var password = document.getElementById("password").value;
    var PasswordAlertPlaceholder = document.getElementById("PasswordAlertPlaceholder");

    PasswordAlertPlaceholder.innerHTML = '';


    if (password.length < 8 || password.length > 20) {
        if(!isCheckLight) PasswordAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        La password deve essere compresa tra gli 8 e i 20 caratteri
        </div>`;
        return false; 
    }

    if (!/[A-Z]/.test(password)) {
        if(!isCheckLight) PasswordAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        La password deve contenere almeno una lettera maiuscola
        </div>`;
        return false; 
    }

    if (!/[a-z]/.test(password)) {
        if(!isCheckLight) PasswordAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        La password deve contenere almeno una lettera minuscola
        </div>`;
        return false;
    }

    if (!/\d/.test(password)) {
        if(!isCheckLight) PasswordAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        La password deve contenere almeno un numero
        </div>`;
        return false; 
    }

    if (!/[!?%_-]/.test(password)) {
        if(!isCheckLight) PasswordAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        La password deve contenere almeno un carattere speciale tra "!?%_-"
        </div>`;
        return false; 
    }
    return true;
}

// Validazione Username
function checkUsername(isCheckLight) {
    var username = document.getElementById("username").value;
    var UsernameAlertPlaceholder = document.getElementById("UsernameAlertPlaceholder");

    
    UsernameAlertPlaceholder.innerHTML = '';

    
    if (username.length < 8 || username.length > 30) {
        if(!isCheckLight) UsernameAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        L'username deve essere compreso tra gli 8 e i 30 caratteri
        </div>`;
        return false; 
    }

    
    var format = /^[a-zA-Z0-9]+$/;
    if (!format.test(username)) {
        if(!isCheckLight) UsernameAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        L'username può contenere solo lettere e numeri
        </div>`;
        return false; 
    }

    
    return true;
}

// Validazione Email
function checkEmail(isCheckLight) {
    var email = document.getElementById("email").value;
    var EmailAlertPlaceholder = document.getElementById("EmailAlertPlaceholder");

    EmailAlertPlaceholder.innerHTML = '';

    var format = /^[a-zA-Z0-9._%+-]+@(gmail\.com|unicampania\.it|studenti\.unicampania\.it|libero\.it)$/;
    if (!format.test(email)) {
        if(!isCheckLight) EmailAlertPlaceholder.innerHTML = `<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
        Inserire un indirizzo mail valido tra i seguenti domini: @gmail.com, @unicampania.it, @studenti.unicampania.it, @libero.it
        </div>`;
        return false;

    }
    return true;

}