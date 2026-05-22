<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/logging_style.css">
</head>
<body>
   <?php
    if (isset($_GET['logging_site'])) {
    
        if ($_GET['logging_site'] == "rejestracja") {
            rejestracja();
        } else {
            logowanie();
        }
    } else {
        logowanie();
    }

    function rejestracja() {
        echo ("<div class='register_site'>");
            echo ("<form class='change_log'>");
                echo ("<button type='submit' name='logging_site' value='logowanie'>Zaloguj się</button>");
                echo ("<button type='submit' name='logging_site' value='rejestracja' class='active'>Zarejestruj się</button>");
            echo ("</form>");
            echo ("<div>");
                echo ('<form class="logging_form">');
                    echo ('<strong>Zaloguj się:</strong>');
                    echo ('<label for="email" class="area-email1">E-mail</label>');
                    echo ('<input type="text" id="email" name="email" class="area-email2">');
                    echo ('<label for="password" class="area-haslo1">Hasło</label>');
                    echo ('<input type="password" id="password" name="password" class="area-haslo2">');
                    echo ('<button type="button" id="eye_password" class="area-eye1">&#128065;</button>');
                    echo ('<button type="submit" name="zarejestrowano" class="area-guzik">Zaloguj</button>');
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
                    echo ('<strong>Zarejestruj się:</strong>');
                    echo ('<label for="email" class="area-email1">E-mail</label>');
                    echo ('<input type="text" id="email" name="email" class="area-email2">');
                    echo ('<label for="password" class="area-haslo1">Hasło</label>');
                    echo ('<input type="password" id="password" name="password" class="area-haslo2">');
                    echo ('<button type="button" id="eye_password" class="area-eye1">&#128065;</button>');
                    echo ('<label for="sec_password" class="area-haslo3">Powtórz hasło</label>');
                    echo ('<input type="password" id="sec_password" name="sec_password" class="area-haslo4">');
                    echo ('<button type="button" id="eye_sec_password" class="area-eye2">&#128065;</button>');
                    echo ('<button type="submit" name="zarejestrowano" class="area-guzik">Załóż konto</button>');
                    echo ("<span id='pass_error'></span>");
                echo ('</form>');
            echo ("</div>");
        echo ("</div>");
    }
?>
<script>
    let logging_form = document.getElementsByClassName('logging_form');
    for (let i = 0; i < logging_form.lenght; i++) {
        logging_form[i].addEventListener("submit", function() {

        });
    }
</script>
</body>
</html>