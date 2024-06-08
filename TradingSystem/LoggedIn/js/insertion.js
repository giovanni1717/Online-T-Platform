

document.getElementById('immagini').addEventListener('change', function() {
    var fileList = document.getElementById('immagini').files;
    var fileLabel = document.getElementById('fileLabel');
    var errorMessage = document.getElementById('errorMessage');

    if (fileList.length > 5) {
        errorMessage.style.display = 'block';
        document.getElementById('immagini').value = ''; // Clear the file input
        fileLabel.textContent = ''; // Clear the label
        return;
    } else {
        errorMessage.style.display = 'none';
    }

    fileLabel.innerHTML = ''; 
    var fileNames = [];
    for (var i = 0; i < fileList.length; i++) {
        fileNames.push(fileList[i].name);
    }
    fileLabel.textContent = fileNames.join(', ');
});

function countChar(val,numchar,id){
	var len = val.value.length;
    if(id == 1) id = "charleft1";
    else id = "charleft2";
    var text = document.getElementById(id);
	
	if (len >= numchar) {
			 val.value = val.value.substring(0, numchar);
			 text.textContent = "0/" + numchar;
	} else {
			var rem = numchar - len;
			text.textContent = rem + "/" + numchar;
	}
};