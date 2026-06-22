<?php
    //Uruchomienie sesji
    session_start();
    //Połączenie z bazą danych
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    //Przekierowanie niezalogowanego użytkownika
    if (!isset($_SESSION['log'])) {
        header("Refresh:0, url=/bookshop/login");
    } else {
        //Logika usuwania produktów z koszyka
        $user_id = $_SESSION['log'];
        if (isset($_GET['delete'])) {
            $book_id = $_GET['delete'];
            mysqli_query($connection, "DELETE FROM cart WHERE user_id = $user_id AND book_id = $book_id");
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    
    <main id="cart">
        <header>
            <h2>Koszyk:</h2>
        </header>
        <?php
            $query = mysqli_query($connection, "SELECT id, book_id FROM cart WHERE user_id = $user_id;");
            if (mysqli_num_rows($query) == 0){
                echo ("Brak przedmiotów w koszyku");
            } else {
                //Rozpatrywanie sytuacji, gdy nie można ponownie kupić/dodać do koszyka produktu
                if (isset($_GET['bought'])) {
                    if ($_GET['bought'] == 'kupiony') {
                        echo ("<p style='color: indianred'>Nie można dodać produktu do koszyka, produkt został już kupiony.");
                    } else if ($_GET['bought'] == 'koszyk') {
                        echo ("<p style='color: indianred'>Nie można dodać produktu do koszyka, produkt jest już w koszyku.");
                    }
                }
                //Wyświetlanie zawartości koszyka
                while ($row = mysqli_fetch_array($query)) {
                    echo ("<div>");
                        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT title, author, price, cover FROM books WHERE id = $row[book_id];"));
                        echo ("<figure><img src='$data[cover]' alt='$data[title]'></figure>");
                        echo ("<div>");
                        echo ("<div>");
                            echo ("<strong>$data[title]</strong><br>");
                            echo ("<em>$data[author]</em>");
                        echo ("</div>");
                        echo ("</div>");
                        echo ("<div>");
                            echo ("<em>$data[price] zł</em>");
                        echo ("</div>");
                        echo ("<form>");
                        echo ("<button type='submit' name='delete' value='$row[book_id]'>&#10006;USUŃ</button>");
                        echo ("</form>");
                    echo ("</div>");
                }
            }
        ?>
        <div>
            <?php
                //Sumowanie wartości produktów w koszyku
                $query = mysqli_query($connection, "SELECT id, book_id FROM cart WHERE user_id = $user_id;");
                $suma = 0;
                if (mysqli_num_rows($query) == 0){
                    $suma = 0;
                } else {
                    while ($row = mysqli_fetch_array($query)) {
                        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT price FROM books WHERE id = $row[book_id];"));
                        $suma += (float)$data['price'];
                    }
                    echo ("<div></div>");
                    echo ("<div><strong>Suma: </strong></div>");
                    echo ("<div><em>$suma zł</em></div>");
                    echo ("<form action='/bookshop/components/buying.php'>");
                    echo ("<button id='buy_every' name='buy_every' value='$suma'>KUP WSZYSTKO</button>");
                    echo ("</form>");
                }
            ?>
        </div>
    </main>

    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>