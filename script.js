function registerUser() {
    var name = encodeURIComponent(document.getElementById("registerName").value);
    var email = encodeURIComponent(document.getElementById("registerEmail").value);
    var password = encodeURIComponent(document.getElementById("registerPassword").value);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    alert("Регистрация успешна! Теперь вы можете войти.");
                    closeModal(); // Закрыть модальное окно регистрации
                } else {
                    alert("Ошибка при регистрации: " + response.message);
                }
            } else {
                alert("Ошибка при регистрации: " + xhr.responseText);
            }
        }
    };

    xhr.open("POST", "register.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("name=" + name + "&email=" + email + "&password=" + password);
}

function loginUser() {
    var email = encodeURIComponent(document.getElementById("loginEmail").value);
    var password = encodeURIComponent(document.getElementById("loginPassword").value);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    alert("Авторизация успешна! Добро пожаловать!");
                    closeModal2(); // Закрыть модальное окно авторизации
                } else {
                    alert("Неправильные email или пароль.");
                }
            } else {
                alert("Ошибка при авторизации: " + xhr.responseText);
            }
        }
    };

    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("email=" + email + "&password=" + password);
}
