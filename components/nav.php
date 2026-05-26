<div class="nav">
    <nav>
        <a href="/bookshop">
            <img src="/bookshop/files/logo.webp" alt="logo"></a>
        <input type="text" id="search">
            <input type="button" value="&#128269" id="search_button">
        <div>
            <a href="/bookshop/profile">&#128113;</a>
            <?php
                if (isset($_SESSION['log'])) {
                    $log = $_SESSION['log'];
                    $email_name = mysqli_fetch_array(mysqli_query($connection,"SELECT email FROM users WHERE id = $log;"));
                    echo ("<a href='/bookshop/profile'>$email_name[0]</a>");
                    echo ("<a href='/bookshop/components/logout.php' id='log_out'>Wyloguj się</a>");
                } else {
                    echo ("<a href='/bookshop/login'>Zaloguj</a>");
                    echo ("<a href='/bookshop/login'>Zarejestruj</a>");
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
</div>