function generateShortUrl() {
    let originalUrl = document.getElementById("originalUrl").value;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "genShortUrl.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById("shortUrl").innerHTML = "<a href='" + xhr.responseText + "' id = 'shortUrlLink' class='myLink'>" + xhr.responseText + "</a>";
            }
        }
    };
    xhr.send("originalUrl=" + encodeURIComponent(originalUrl));
}

function redirectionURL(shortUrl) {
    console.log('Redirecting to:', shortUrl);
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "redirect.php?shortUrl=" + encodeURIComponent(shortUrl), true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        console.log('Redirecting response code:', xhr.status);
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.url) {
                    // Use window.open to open the URL in a new window or tab
                    window.open(response.url, '_blank');
                } 
            }
        }
    };

    xhr.send(null);
}