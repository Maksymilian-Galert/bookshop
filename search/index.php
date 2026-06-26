<?php
    //Uruchomienie sesji
    session_start();
    //Podłączenie bazy danych
    $connection = mysqli_connect("127.0.0.1","root",""); //Informacje identyfikujące bazę danych
    mysqli_select_db($connection,"kup_book");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
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
    <main id="main_search">
        <?php
            if (!isset($_GET['search'])) {
                //Wyświetlenie wszystkich produktów, gdy nic nie wyszukano, a użytkownika jest na stronie
                header("Refresh: 0, url=/bookshop/search/?search=Wyszukaj");
            } else {
                //Wyświetlenie wszystkich produktów, gdy pole wyszukiwania było puste
                $search = $_GET['search'];
                if ($search == '') {
                    header("Refresh: 0, url=/bookshop/search/?search=Wyszukaj");
                }
                if ($search == "Wyszukaj") {
                    //Domyślne wyświetlenie wszystkich produktów
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books;");
                    $wynik = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    echo ("<header><h2>Wszystkie książki w katalogu</h2></header>");
                } else {
                    //Wyszukanie konkretnej frazy kolejno w tytule, nazwie autora oraz opisie
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR description LIKE '%$search%';");
                    $wynik = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    $wynik = array_values(array_unique($wynik, SORT_REGULAR));
                    //Informacja, po jakiej frazie wyszukiwano
                    echo ("<header><h2>Wyniki wyszukania po frazie: $search</h2></header>");
                }
                $max = 0;
                for ($i = 0; $i < count($wynik); $i++) {
                    $price = $wynik[$i]['price'];
                    if ($price > $max) {
                        $max = $price;
                    }
                }
            }
        ?>

        <button id='filters'>Filtry oraz sortowanie</button>
        <aside id='filters_window'>
            <button id='close_window'>X</button>
            <form id='filter_form'>
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">

                <h5>Filtry</h5>
                <label for='minimal_price'>Cena:</label><br>
                <input type='number' step='0.01' name='minimal_price' min='0' max='<?php echo ('$max');?>'>
                <input type='number' step='0.01' name='maximal_price' min='0' max='<?php echo ('$max');?>'>
                <br><br><label for='choose_author'>Autorzy:</label><br>

                <?php
                    if ($search == 'Wyszukaj') {
                        $wynik_group = mysqli_query($connection,"SELECT author FROM books GROUP BY author;");
                    } else {
                        $wynik_group = mysqli_query($connection,"SELECT author FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR description LIKE '%$search%' GROUP BY author;");
                    }
                    $wynik_group = mysqli_fetch_all($wynik_group, MYSQLI_ASSOC);
                    foreach ($wynik_group as $row) {
                        echo ("<input type='checkbox' name='choose_author[]' value='$row[author]'>");
                        echo ("<label for='choose_author'>$row[author]</label><br>");
                    }
                ?>

                <select name='choose_sorting'>
                    <option value='sel'>Najtrafniejsze</option>
                    <option value='new'>Najnowsze</option>
                    <option value='old'>Najstarsze</option>
                    <option value='price_low'>Najniższa cena</option>
                    <option value='price_high'>Najwyższa cena</option>
                </select>
            </form>
        </aside>

        <div id='books_container'>
            <?php 
                require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/search_books.php");
            ?>
        </div>
    </main>
    <script>
        document.getElementById("filters").addEventListener("click", function() {
            document.getElementById("filters_window").style.display = "grid";
        });;
        document.getElementById("close_window").addEventListener("click", function() {
            document.getElementById("filters_window").style.display = "none";
        });;
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterForm = document.getElementById("filter_form");
            const booksContainer = document.getElementById("books_container");

           
            // Nasłuchiwanie zmian w formularzu
            filterForm.addEventListener("input", sendAjaxRequest);
            filterForm.addEventListener("change", sendAjaxRequest);
            

            function sendAjaxRequest() {
                // Automatyczne pobranie wszystkich danych z formularza
                const formData = new FormData(filterForm);
                const searchParams = new URLSearchParams(formData).toString();

                // Wysyłanie żądania do pliku PHP, który generuje same wyniki
                fetch("/bookshop/components/search_books.php?" + searchParams)
                    .then(response => response.text())
                    .then(data => {
                        booksContainer.innerHTML = data; // Podmiana zawartości kontenera
                    })
                    .catch(error => console.error("Błąd AJAX:", error));
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