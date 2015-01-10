function list_songs(id) {
   
    var xhr = new XMLHttpRequest();

    
    xhr.onreadystatechange = function() {
        /* readyState = 4 means that the response has been completed
         * status = 200 indicates that the request was successfully completed */
        if (xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            document.getElementById("selected_album").innerHTML = result;
        }
    };
    /* send the request using GET */
    xhr.open("GET", "list_songs.php?id="+id, true); 
    xhr.send(null); 
    document.getElementById("selected_album").innerHTML = "If you can read this text, there's something wrong...";
}

