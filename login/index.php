<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");

    if (isset($_SESSION['log'])) {
        header("Refresh: 0, url=/bookshop/profile/");
    }


    if (isset($_GET['zarejestrowano'])) {
        if ($_GET['zarejestrowano'] == 'zarejestrowano') {
            $email = $_GET['email'];
            $check_name = "SELECT email FROM users WHERE email = '$email'";
            if (mysqli_query($connection,$check_name)) {
                used_user("Ta nazwa użytkownika jest już zajęta");
            } else {
                $password = $_GET['password'];
                $add_user = "INSERT INTO users (email, password, role) VALUES ('$email','$password','user');";
                mysqli_query($connection,$add_user);
            }
        } else if ($_GET['zarejestrowano'] == 'zalogowano') {
            $email = $_GET['email'];
            $password = $_GET['password'];
            $log_in = "SELECT id FROM users WHERE email = '$email' AND password = '$password';";
            $log_in = mysqli_query($connection, $log_in);
            $log_in = mysqli_fetch_array($log_in);
            if (!!$log_in) {
                $log_in = $log_in[0];
                $_SESSION['log'] = $log_in;
                header("Refresh:0; url=/bookshop");
            } else {
                used_user("Błędny email lub hasło");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/logging_style.css">
    <link rel="stylesheet" href="/bookshop/style/style.css">
</head>
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>

   <?php
    if (isset($_GET['logging_site'])) {
        if ($_GET['logging_site'] == "rejestracja") {
            rejestracja();
        } else {
            logowanie();
        }
    } else if (isset($_GET['sec_password'])) {
        rejestracja();
    } else {
        logowanie();
    }
    function used_user($e) {
        echo ("<input type='text' value='$e' class='invisible' id='error_message'>");
    }
    function rejestracja() {
        echo ("<div class='register_site'>");
            echo ("<form class='change_log'>");
                echo ("<button type='submit' name='logging_site' value='logowanie'>Zaloguj się</button>");
                echo ("<button type='submit' name='logging_site' value='rejestracja' class='active'>Zarejestruj się</button>");
            echo ("</form>");
            echo ("<div>");
                echo ('<form class="logging_form">');
                    echo ('<strong>Zarejestruj się:</strong>');
                    echo ('<label for="email" class="area-email1">E-mail</label>');
                    echo ('<input type="text" id="email" name="email" class="area-email2">');
                    echo ('<label for="password" class="area-haslo1">Hasło</label>');
                    echo ('<input type="password" id="password" name="password" class="area-haslo2">');
                    echo ('<button type="button" id="eye_password" class="area-eye1">&#128065;</button>');
                    echo ('<label for="sec_password" class="area-haslo3">Powtórz hasło</label>');
                    echo ('<input type="password" id="sec_password" name="sec_password" class="area-haslo4">');
                    echo ('<button type="button" id="eye_sec_password" class="area-eye2">&#128065;</button>');
                    echo ('<button type="submit" name="zarejestrowano" class="area-guzik" value="zarejestrowano">Załóż konto</button>');
                    echo ("<span id='pass_error'></span>");
                echo ('</form>');
            echo ("</div>");
        echo ("</div>");
    }

    function logowanie() {
        echo ("<div class='register_site'>");
            echo ("<form class='change_log'>");
                echo ("<button type='submit' name='logging_site' value='logowanie' class='active'>Zaloguj się</button>");
                echo ("<button type='submit' name='logging_site' value='rejestracja'>Zarejestruj się</button>");
            echo ("</form>");
            echo ("<div>");
                echo ('<form class="logging_form">');
                    echo ('<strong>Zaloguj się:</strong>');
                    echo ('<label for="email" class="area-email1">E-mail</label>');
                    echo ('<input type="text" id="email" name="email" class="area-email2">');
                    echo ('<label for="password" class="area-haslo1">Hasło</label>');
                    echo ('<input type="password" id="password" name="password" class="area-haslo2">');
                    echo ('<button type="button" id="eye_password" class="area-eye1">&#128065;</button>');
                    echo ('<button type="submit" name="zarejestrowano" class="area-guzik" value="zalogowano">Zaloguj</button>');
                    echo ("<span id='pass_error'></span>");
                echo ('</form>');
            echo ("</div>");
        echo ("</div>");
    }
?>
<script>
    let error_message = document.getElementById("error_message").value;
    if (!!error_message) {
        document.getElementById('pass_error').innerHTML = error_message;
    }
</script>
<script>
    document.getElementById("email").addEventListener("input", function(e) {
        e.target.value = e.target.value.replace(/\W/g,"");
    });
</script>
<script>
    document.getElementById('eye_password').addEventListener("click", function() {
        document.getElementById('password').type = 'text';
    });
    document.getElementById('eye_password').addEventListener("blur", function() {
        document.getElementById('password').type = 'password';
    });
    document.getElementById('eye_sec_password').addEventListener("click", function() {
        document.getElementById('sec_password').type = 'text';
    });
    document.getElementById('eye_sec_password').addEventListener("blur", function() {
        document.getElementById('sec_password').type = 'password';
    });
</script>
<script>
    let logging_form = document.getElementsByClassName('logging_form');
    for (let i = 0; i < logging_form.length; i++) {
        logging_form[i].addEventListener("submit", function(e) {
            var correct = 0;
            document.getElementById("pass_error").innerHTML = "";
            if (document.getElementById("email").value.trim() === '') {
                document.getElementsByClassName("area-email1")[0].textContent = "E-mail*";
                document.getElementsByClassName("area-email1")[0].style.color = "red";
            } else {
                document.getElementsByClassName("area-email1")[0].textContent = "E-mail";
                document.getElementsByClassName("area-email1")[0].style.color = "black";
                correct++;
            }
            if (document.getElementById("password").value.trim() === '') {
                document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło*";
                document.getElementsByClassName("area-haslo1")[0].style.color = "red";
            } else {
                document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło";
                document.getElementsByClassName("area-haslo1")[0].style.color = "black";
                correct++;
            }
            if (document.getElementById("sec_password")) {
                if (document.getElementById("password").value.length < 8) {
                    correct --;
                    document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło*";
                    document.getElementsByClassName("area-haslo1")[0].style.color = "red";
                    document.getElementById("pass_error").innerHTML += "Hasło musi zawierać minimum 8 znaków <br>";
                }
                if (!document.getElementById("password").value.match(/[A-Z]/)) {
                    correct --;
                    document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło*";
                    document.getElementsByClassName("area-haslo1")[0].style.color = "red";
                    document.getElementById("pass_error").innerHTML += "Hasło musi zawierać wielką literę <br>";
                }
                if (!document.getElementById("password").value.match(/[0-9]/)) {
                    correct --;
                    document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło*";
                    document.getElementsByClassName("area-haslo1")[0].style.color = "red";
                    document.getElementById("pass_error").innerHTML += "Hasło musi zawierać liczbę <br>";
                }
                if (!document.getElementById("password").value.match(/[^a-zA-Z0-9]/)) {
                    correct --;
                    document.getElementsByClassName("area-haslo1")[0].textContent = "Hasło*";
                    document.getElementsByClassName("area-haslo1")[0].style.color = "red";
                    document.getElementById("pass_error").innerHTML += "Hasło musi zawierać znak specjalny <br>";
                }
                if (document.getElementById("sec_password").value != document.getElementById("password").value) {
                    document.getElementsByClassName("area-haslo3")[0].textContent = "Powtórz hasło*";
                    document.getElementsByClassName("area-haslo3")[0].style.color = "red";
                } else {
                    document.getElementsByClassName("area-haslo3")[0].textContent = "Powtórz hasło";
                    document.getElementsByClassName("area-haslo3")[0].style.color = "black";
                    correct++;
                }

                if (correct !== 3) {
                    e.preventDefault();
                }
            } else {
                if (correct !== 2) {
                    e.preventDefault();
                }
            }
        });
    }
</script>
<?php
    require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
?>
<?php
    mysqli_close($connection);
?>
</body>
</html>