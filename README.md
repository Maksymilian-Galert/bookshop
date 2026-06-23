# Projekt księgarni
Oto mój projekt prymitywnej księgarni, który umożliwia użytkownikom zakup e-booków oraz pobranie ich z witryny księgarni.

Witryna ta posiada funkcję wyszukania konkretnych książek na stronie, potwierdzenie dokonanej płatności (umożliwienie pobrania książki) przez admina jednym kliknięciem, dodanie produktów do koszyka oraz ich zakup. Strona została wykonana responsywnie, dzięki czemu dostosowuje się zarówno do urządzeń mobilnych, jak i do wersji desktopowej (PC i laptopy).

# Dane techniczne

Strona została wykonana na lokalnym serwerze XAMPP, który został dostosowany, aby działał w lokalnej sieci na zarezerwowanym adresie IP. Aby poprawnie z niego korzystać na własnej domenie należy rozpakować wszystkie pliki i katalogi z katalogu 'bookshop', a następnie dostosować wszystkie ścieżki w plikach PHP oraz CSS, aby działały w domenie. Sugerowane jest przekształcenie wszystkich ścieżek zaczynających się od frazy '/bookshop', przygotowanie linijek kodu, w których pojawiają się komentarze o treści: '//Ścieżka identyfikująca potrzebne komponenty' oraz przygotowanie bazy danych oraz przekształcenie połączenia z nią w kodzie, aby była kompatybilna (w tym celu należy edytować linijki kodu, w których znajdują się komentarze o treści: '//Informacje identyfikujące bazę danych').

Podczas przekształcania wszystkich ścieżek dostępu należy pamiętać o: linkach w znaczniku a, obrazach w znaczniku img, komendy header kodu PHP, linku dołączającego style (pliki CSS), background-image w plikach CSS oraz ścieżki dostępu do okładki oraz książki do pobrania zarówno w bazie danych jak i w plikach PHP.





# bookshop
It's my project of primitive bookshop, where users can buy e-books and download them there.


