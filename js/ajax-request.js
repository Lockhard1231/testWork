//Функция для генерации короткого URL при помощи ajax запроса
function generateShortUrl() {
    let originalUrl = document.getElementById("originalUrl").value;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../testWork/php/genShortUrl.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById("shortUrl").innerHTML = "<h3>Ваш сгенерированный короткий URL</h3>" + "<a href='" + xhr.responseText + "'>" + xhr.responseText + "</a>";
            }
        }
    };
    xhr.send("originalUrl=" + encodeURIComponent(originalUrl));
}

