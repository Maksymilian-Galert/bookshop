# Po Polsku (in Polish)

# Wykorzystanie na domenie

Strona została wykonana na lokalnym serwerze XAMPP, który został dostosowany, aby działał w lokalnej sieci na zarezerwowanym adresie IP. Aby poprawnie z niego korzystać na własnej domenie należy rozpakować wszystkie pliki i katalogi z katalogu 'bookshop', a następnie dostosować wszystkie ścieżki w plikach PHP oraz CSS, aby działały w domenie. Sugerowane jest przekształcenie wszystkich ścieżek zaczynających się od frazy '/bookshop', przygotowanie linijek kodu, w których pojawiają się komentarze o treści: '//Ścieżka identyfikująca potrzebne komponenty' oraz przygotowanie bazy danych oraz przekształcenie połączenia z nią w kodzie, aby była kompatybilna (w tym celu należy edytować linijki kodu, w których znajdują się komentarze o treści: '//Informacje identyfikujące bazę danych').

Podczas przekształcania wszystkich ścieżek dostępu należy pamiętać o: linkach w znaczniku a, obrazach w znaczniku img, komendy header kodu PHP, linku dołączającego style (pliki CSS), background-image w plikach CSS oraz ścieżki dostępu do okładki oraz książki do pobrania zarówno w bazie danych jak i w plikach PHP.



# In English

# Using page on own domain

The website was made on local XAMPP server, which was adapted for my local network on reserved IP address. To work functionally on your own domain, you should unzip all files and folders from folder 'bookshop' and then change all paths in PHP and CSS files with informations from your domain. It is suggested to edit all paths starting with '/bookshop', and prepare code lines where are comments: '//Ścieżka identyfikująca potrzebne komponenty' and also prepare data base (change DB connection in code) to be compatible (edit lines where are comments: '//Informacje identyfikujące bazę danych').

During editing all paths you have to remember about: hyperlinks in markeup a, images in markeup img, header command in PHP, style hyperlinks (in CSS files), background-image in CSS files and paths for covers and downloadable books in data base and in PHP files.