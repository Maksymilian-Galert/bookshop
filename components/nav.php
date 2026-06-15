<div class="nav">
    <div id="wycofaj"></div>
    <nav aria-label="Main menu">
        <a href="/bookshop">
            <img src="/bookshop/files/logo.webp" alt="logo">
        </a>
        <form action="/bookshop/search">
            <input type="text" id="search" value="Wyszukaj" placeholder="Pokaż wszystkie" name="search">
            <button type="submit" id="search_button">&#128269;</button>
        </form>
        <div>
            <a href="/bookshop/profile">&#128113;</a>
            <?php
                if (isset($_SESSION['log'])) {
                    $log = $_SESSION['log'];
                    $email_name = mysqli_fetch_array(mysqli_query($connection,"SELECT email FROM users WHERE id = $log;"));
                    echo ("<a href='/bookshop/profile'>$email_name[0]</a>");
                    echo ("<a href='/bookshop/components/logout.php' id='log_out'>Wyloguj się</a>");
                } else {
                    echo ("<a href='/bookshop/login/?logging_site=logowanie'>Zaloguj</a>");
                    echo ("<a href='/bookshop/login/?logging_site=rejestracja'>Zarejestruj</a>");
                }
            ?>
        </div>
        <?php
            if (isset($_SESSION['log'])) {
                $log = $_SESSION['log'];
                $role= mysqli_fetch_array(mysqli_query($connection,"SELECT role FROM users WHERE id = $log;"))[0];
                if ($role == 'admin') {
                    echo ("<a href='/bookshop/admin'>&#9763;</a>");
                } else {
                    echo ("<a href='/bookshop/cart'>&#128722;</a>");
                }
            } else {
                echo ("<a href='/bookshop/cart'>&#128722;</a>");
            }
        ?>
    </nav>
    <script>
        document.getElementById("search").addEventListener("focusin", function (e) {
            if (e.target.value == 'Wyszukaj') {
                e.target.value = '';
            }
        });
        document.getElementById("search").addEventListener("focusout", function (e) {
            if (e.target.value == '') {
                e.target.value = 'Wyszukaj';
            }
        });
    </script>
</div>