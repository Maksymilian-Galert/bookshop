-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 25, 2026 at 08:20 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kup_book`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(5,2) NOT NULL,
  `file_path` text NOT NULL,
  `cover` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`, `price`, `file_path`, `cover`) VALUES
(1, 'Hiena Cmentarna', 'Korneliusz De Cadaver', 'Jest to pierwsze opowiadanie z cyklu \"Dzienniki Korneliusza\", które ma na celu przybliżyć wam moją historię, a także różne wydarzenia, które mnie spotkały, podczas mojego... mojej egzystencji. A jak na \"gustującego we krwi\" dżentelmena, trwała ona znacznie dłużej, niżeli życie zwykłego śmiertelnika.', 19.99, 'hiena_cmentarna.pdf', '/bookshop/books/hiena_cmentarna.png'),
(2, 'Krwawa dama', 'Korneliusz De Cadaver', 'Przed wami kolejną część z cyklu \"Dzienniki Korneliusza\". Historia ta rozgrywa się kilka wieków po poprzednim opowiadaniu. Przedstawię wam moment, w którym zostałem zatytułowany hrabią, poszerzę wasze pojmowanie na temat wampirzych stowarzyszeń oraz ich działania, a także przedstawię wam fascynujących bohaterów.', 24.99, 'krwawa_dama.pdf', '/bookshop/books/krwawa_dama.png'),
(3, 'Pakt z trupem', 'Korneliusz De Cadaver', 'Przed wami kolejną część z cyklu \"Dzienniki Korneliusza\". Historia ta rozgrywa się trochę po poprzednim opowiadaniu. Opowiadanie to przedstawia moje spotkanie ze starym znajomym, Michałem Sędziwojem, oraz pokazuje, jak rozwiązałem swoje stare zatargi z jednym z najpotężniejszych diabłów, z Mefistofelesem. ', 14.99, 'pakt_z_trupem.pdf', '/bookshop/books/pakt_z_trupem.png'),
(4, 'Po nitce do kłębka', 'Korneliusz De Cadaver', 'Przed wami kolejną część z cyklu \"Dzienniki Korneliusza\". Historia ta jest bezpośrednią kontynuacją \"Hieny cmentarnej\" i rozgrywa się jeszcze przed opowiadaniami: \"Pakt z trupem\" oraz \"Krwawa dama\"\r\nMożecie dowiedzieć się w tym opowiadaniu nowych informacji o wampirach oraz łowcach, a także być świadkiem nieczęstej sytuacji, podczas której przybieram nową postać. Nie spoilerując więcej zapraszam do czytania i mam nadzieję, że ta historia zmrozi wam krew w żyłach.', 25.00, 'po_nitce_do_klebka.pdf', '/bookshop/books/po_nitce_do_klebka.png'),
(28, 'Labirynt', 'Korneliusz De Cadaver', 'Historia opowiada o grupie nastolatków, którzy wpadli na pomysł, aby bawić się w labiryncie. Z początki nie wiedzieli, czym to wszystko się skończy, ale skutki na pewno im się nie spodobają.\r\nPrzed wami krótkie opowiadanie o lekkim klimacie horrorowym. Mam nadzieję, że będzie to dobra odskocznie przed większymi utworami, a jednocześnie miłym spędzeniem czasu.', 12.99, 'labirynt.pdf', '/bookshop/books/labirynt.png'),
(29, 'Żywe śmierci początki', 'Korneliusz De Cadaver', 'Zapraszam was serdecznie do opowiadania, od którego wszystko się zaczęło. Zaznacie odrobiny historii z czasów, kiedy jeszcze żyłem jako zwykły człowiek. Dowiecie się także, z jakimi mankamentami wiąże się zostanie wampirem.\r\nJest to pierwsze w kolejności opowiadanie, przed innymi: „Hiena cmentarna\", „Krwawa dama\", „Pakt z trupem\" oraz „Po nitce do kłębka\", do zapoznania się, z którymi serdecznie zapraszam.', 34.99, 'zywe_smierci_poczatki.pdf', '/bookshop/books/zywe_smierci_poczatki.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `book_id`, `user_id`) VALUES
(47, 1, 4),
(48, 2, 4),
(49, 28, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `total_price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(4, 'user', 'user', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
