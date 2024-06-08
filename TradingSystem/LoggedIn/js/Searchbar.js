let dropdownBtn = document.getElementById("drop-text");
let list = document.getElementById("list");
let icon = document.getElementById("icon");
let span = document.getElementById("span");
let input = document.getElementById("search-input");
let mag_glass = document.getElementById("mag-glass");
let searchBtn = document.getElementById("searchBtn");
let listItems = document.querySelectorAll(".dropdown-list-item");

var category = "default";
searchBtn.style.pointerEvents="none";
searchBtn.style.cursor="default";

// Mostra lista dropdown al click
dropdownBtn.onclick = function(){
    if(list.classList.contains('show')){
        icon.style.rotate = "0deg";
    }else{
        icon.style.rotate = "-180deg";
    }
    list.classList.toggle("show");
};

// Nasconde lista quando si clicca fuori da lista
window.onclick = function(e){
    if(
        e.target.id !== "drop-text" && 
        e.target.id !== "span" &&
        e.target.id !== "icon"
    ){
        list.classList.remove("show");
        icon.style.rotate = "0deg";
    }
};


function enablesearch(){
    inputData = input.value;
    if(inputData === null || inputData === undefined || inputData.trim() === ""){
        searchBtn.style.pointerEvents="none";
        searchBtn.style.cursor="default";
    }
    else{
        searchBtn.style.pointerEvents="auto";
        searchBtn.style.cursor="pointer";
    }
    var newURL = "../LoggedIn/searchresults.php?searchInput=" + inputData + "&category=" + category;
    searchBtn.href = newURL;
    
}

for(item of listItems){
    item.onclick = function(e){
        // Cambio testo dropdown alla selezione
        span.innerText = e.target.innerText;
        category = e.target.innerText;
        enablesearch();

        //Cambio testo placeholder alla selezione
        if(e.target.innerText == "Categoria"){
            input.placeholder = "Cerca...";
        }
        else{
            input.placeholder = "Cerca in " + e.target.innerText + "...";
        }   
    };
}

