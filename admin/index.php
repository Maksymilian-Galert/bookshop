<?php
    session_start(); //Uruchomienie sesji
    //Strona niedostępna dla niezalogowanych
    if (!isset($_SESSION['log'])) {
        header("Refresh: 0, url=/bookshop/profile");
    }
    //Połączenie z bazą danych
    $connection = mysqli_connect("127.0.0.1","root",""); //Informacje identyfikujące bazę danych
    mysqli_select_db($connection,"kup_book");
    //Strona niedostępna dla nie-adminów
    $user_id = $_SESSION['log'];
    $role = mysqli_fetch_array(mysqli_query($connection, "SELECT role FROM users WHERE id = '$user_id';"))['role'];
    if ($role !== 'admin') {
        header("Refresh: 0, url=/bookshop/profile");
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>
    
    <main id="admin">
        <header>
            <?php
                $email = mysqli_fetch_array(mysqli_query($connection, "SELECT email FROM users WHERE id = '$user_id';"))['email'];
                echo ("<h2>Witaj, $email</h2>");
            ?>
        </header>
        <?php
            //Informacja o zatwierdzeniu zamówienia w momencie jego zatwierdzenia w panelu admina
            if (isset($_GET['set_paid'])) {
                $order_id = $_GET['set_paid'];
                if (mysqli_query($connection, "UPDATE orders SET status = 'paid' WHERE id = $order_id;")) {
                    echo ("<strong>Zamówienie #$order_id zostało zatwierdzone</strong>");
                }
            }
        ?>
        <section>
            <header>
                <h3>Oczekujące zamówienia:</h3>
            </header>
            <?php
                //Wyświetlanie zamówień, które oczekują na potwierdzenie
                $zamowienia = mysqli_query($connection, "SELECT orders.id, orders.status, orders.total_price, users.email FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.status = 'pending';");
                if (mysqli_num_rows($zamowienia) == 0) {
                    echo ("<p>Brak oczekujących zamówień</p>");
                } else {
                    echo ("<ul>");
                    echo ("<form>");
                    while ($row = mysqli_fetch_array($zamowienia)) {
                        echo ("<li>");
                            echo ("<span>#$row[id]</span>");
                            echo ("<span>-</span>");
                            echo ("<span>$row[email]</span>");
                            echo ("<span>-</span>");
                            echo ("<span>$row[total_price] zł</span>");
                            echo ("<button type='submit' name='set_paid' value='$row[id]'>Zatwierdź zamówienie</button>");
                        echo ("</li>");
                    }
                    echo ("</form>");
                    echo ("</ul>");
                }
            ?>
        </section>
        <section>
            <header>
                <h3>Opłacone zamówienia</h3>
            </header>
            <?php
                //Wyświetlanie zamówień, które zostały potwierdzone jako opłacone
                $paid = mysqli_query($connection, "SELECT orders.id, orders.status, orders.total_price, users.email FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.status = 'paid';");

                if (mysqli_num_rows($paid) == 0) {
                    echo ("<p>Brak opłaconych zamówień</p>");
                } else {
                    $all_paid = mysqli_fetch_all($paid, MYSQLI_ASSOC);
                    $all_paid = (count($all_paid) <= 3 || isset($_GET['oplacone'])) ? $all_paid : array_slice($all_paid, 0, 3);

                    echo ("<ul>");
                        foreach ($all_paid as $row) {
                            echo ("<li>");
                                echo ("<span>#$row[id]</span>");
                                echo ("<span>-</span>");
                                echo ("<span>$row[email]</span>");
                                echo ("<span>-</span>");
                                echo ("<span>$row[total_price] zł</span>");
                            echo ("</li>");
                        }
                    echo ("</ul>");
                    //Wyświetlenie rozszerzonej listy, która wyświetla wszystkie zamówienia opłacone
                    if (count($all_paid) <= 3 || !isset($_GET['oplacone'])) {
                        echo ("<form method='GET'>");
                            echo ("<button name='oplacone' id='oplacone' value='yes'>VV Zobacz wszystkie VV</button>");
                        echo ("</form>");
                    }
                }
            ?>
        </section>
        <section>
            <header>
                <h3>Dodawanie książek</h3>
            </header>
            <?php
                //Dodawanie nowych książek przez admina
                if (isset($_POST['add'])) {
                    $title = $_POST['title'];
                    $author = $_POST['author'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $file_path = $_POST['file_path'];
                    $cover = $_POST['cover'];

                    $targetBookFile = $_SERVER['DOCUMENT_ROOT']."/bookshop/books/".$file_path;
                    $targetCoverFile = $_SERVER['DOCUMENT_ROOT'].$cover;

                    if ($_FILES["book_file"]["size"] > 5000000 || $_FILES["cover_file"]["size"] > 5000000) {
                        echo ("<strong>Plik jest za duży. Maksymalny dozwolony rozmiar to 5MB.</strong>");
                    } else if (move_uploaded_file($_FILES["book_file"]["tmp_name"],$targetBookFile) && move_uploaded_file($_FILES["cover_file"]["tmp_name"],$targetCoverFile)) {
                        echo ("<strong>Plik ". htmlspecialchars(basename($_FILES["book_file"]["name"]))." został pomyślnie przesłany.</strong><br>");
                        echo ("<strong>Plik ". htmlspecialchars(basename($_FILES["cover_file"]["name"]))." został pomyślnie przesłany.</strong><br>");
                        if (mysqli_query($connection, "INSERT INTO books (title, author, description, price, file_path, cover) VALUES ('$title', '$author', '$description', '$price', '$file_path', '$cover');") ) {
                            echo ("<strong>Pomyślnie dodano nową książkę</strong><br>");
                        } else {
                            echo ("<strong>Wystąpił błąd podczas przesyłania pliku.</strong>");
                        }
                    }
                }
            ?>
            <form id="add" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <input type="text" name="title" placeholder="Tytuł książki">
                    <input type="text" name="author" placeholder="Imię i nazwisko autora">
                    <textarea placeholder="Opis książki" name="description" rows="4" cols="50"></textarea>
                    <input type="number" name="price" placeholder="Cena książki" step="0.01">
                    <input type="text" name="file_path" placeholder="Nazwa pliku pdf">
                    <span id="book_file_span"><input type='file' name='book_file' id="book_file">Plik z książką (.pdf)</span>
                    <input type="text" name="cover" placeholder="Ścieżka dostępu okładki">
                    <span id="cover_file_span"><input type='file' name='cover_file' id="cover_file">Plik z okładką (.png)</span>
                    <button type="submit" name="add">Dodaj książkę</button>
                </fieldset>
            </form>
        </section>
    </main>

    <script>
        //Zatrzymanie wysłania formularza w momencie niewypełnienia wymaganych pól
        document.getElementById("add").addEventListener("submit", function (e) {
            var accept = 0;
            if (!document.getElementsByName("title")[0].value) {
                accept--;
                document.getElementsByName("title")[0].style.border = "5px dotted red";
            } else {
                document.getElementsByName("title")[0].style.border = "";
            }

            if (!document.getElementsByName("price")[0].value) {
                accept--;
                document.getElementsByName("price")[0].style.border = "5px dotted red";
            } else {
                document.getElementsByName("price")[0].style.border = "";
            }

            if (!document.getElementsByName("file_path")[0].value) {
                accept--;
                document.getElementsByName("file_path")[0].style.border = "5px dotted red";
            } else {
                document.getElementsByName("file_path")[0].style.border = "";
            }

            if (!document.getElementsByName("cover")[0].value) {
                accept--;
                document.getElementsByName("cover")[0].style.border = "5px dotted red";
            } else {
                document.getElementsByName("cover")[0].style.border = "";
            }

            if (!document.getElementsByName("book_file")[0].value || !document.getElementsByName("book_file")[0].value.toLowerCase().endsWith('.pdf')) {
                accept--;
                document.getElementById("book_file_span").style.border = "5px dotted red";
            } else {
                document.getElementById("book_file_span").style.border = "";
            }

            if (!document.getElementsByName("cover_file")[0].value || !document.getElementsByName("cover_file")[0].value.toLowerCase().endsWith('.png')) {
                accept--;
                document.getElementById("cover_file_span").style.border = "5px dotted red";
            } else {
                document.getElementById("cover_file_span").style.border = "";
            }


            if (accept != 0) {
                e.preventDefault();
            }
        });

        //Cena jest większa lub równa 0
        document.getElementsByName("price")[0].addEventListener("input", function (e) {
            if (e.target.value < 0) {
                e.target.value = 0;
            }
        });
        //Autouzupełnianie ścieżki pliku
        document.getElementsByName("file_path")[0].addEventListener("focusin", function(e) {
            if (!e.target.value) {
                e.target.value = document.getElementsByName("title")[0].value.toLowerCase().replaceAll("ń","n").replaceAll("ł","l").replaceAll("ó","o").replaceAll("ę","e").replaceAll("ą","a").replaceAll("ć","c").replaceAll("ś","s").replaceAll("ź","z").replaceAll("ż","z").replaceAll(/[^a-z0-9]/g,"_") + ".pdf";
            }
        });
        //Autouzupełnianie odkładki książki
        document.getElementsByName("cover")[0].addEventListener("focusin", function(e) {
            if (!e.target.value) {
                e.target.value = "/bookshop/books/" + document.getElementsByName("title")[0].value.toLowerCase().replaceAll("ń","n").replaceAll("ł","l").replaceAll("ó","o").replaceAll("ę","e").replaceAll("ą","a").replaceAll("ć","c").replaceAll("ś","s").replaceAll("ź","z").replaceAll("ż","z").replaceAll(/[^a-z0-9]/g,"_") + ".png";
            }
        });
    </script>


    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>