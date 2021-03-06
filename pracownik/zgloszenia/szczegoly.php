<?php
//Konfig aplikacji
if (file_exists("../conf.ig.php"))
{
    include_once ("../conf.ig.php");
}

echo "<h2 class=\"mt-5\">Szczegóły zgłoszenia nr " . $_GET['id_zgloszenia'] . "</h2>\n";
echo "<div class=\"container\">\n";
echo "<div class=\"row\">\n";

/* Wysyłanie zapytania SQL */
$query = "SELECT Z.`klient`,P.`imie`,P.`nazwisko`, Z.`miasto`,Z.`rodzaj`,Z.`status`,Z.`opis`, `data`, `data_zakonczenia` FROM `pro_zgloszenia` as Z left join `pro_pracownicy` as P on P.login=Z.pracownik where Z.id_zgloszenia= ".$_GET['id_zgloszenia']."";

$result = mysqli_query($conn, $query) or die("Zapytanie zakończone niepowodzeniem");
while ($wynik = mysqli_fetch_array($result))
{
    echo "<div class=\"col-md-6\">\n";
    echo "<div class=\"card bg-light\">\n";
    echo "<div class=\"card-body\">\n";
    echo "<h5 class=\"card-title\">Zgłaszający: <i>" . $wynik['klient'] . "</i></h5>";
    if (empty($wynik['imie']))
    {
      echo "<h5 class=\"card-title\">Przyjęte przez: <i>Zgłoszenie nieprzyjęte</i></h5>";
    }
    else
    {
      echo "<h5 class=\"card-title\">Przyjęte przez: <i>" . $wynik['imie'] . " " . $wynik['nazwisko'] . "</i></h5>";
    }
    echo "<p class=\"card-text\">Miasto: " . $wynik['miasto'] . "</p>";
    echo "<p class=\"card-text\">Rodzaj: " . $wynik['rodzaj'] . "</p>";
    echo "<p class=\"card-text\">Status: <b>" . $wynik['status'] . "</b></p>";
    //echo "<p class=\"card-text\">Data zgłoszenia: ".$wynik['Z.data']."</p>";
    echo "<p class=\"card-text\">Opis: " . $wynik['opis'] . "</p>";
    echo "<p class=\"card-text\">Data przyjęcia zgłoszenia: <b>" . date("d-m-Y H:i:s", $wynik['data']) . "</b></p>";
    if (empty($wynik['data_zakonczenia']))
    {
        $data_zakon = "Zgłoszenie oczekuje na przyjęcie";
        echo "<p class=\"card-text\">Przybliżona data zamknięcia zgłoszenia: <br><b>" . $data_zakon . "</b></p>";
    }
    else
    {
        echo "<p class=\"card-text\">Przybliżona data zamknięcia zgłoszenia: <b>" . date("d-m-Y", $wynik['data_zakonczenia']) . "</b></p>";
    }

    echo "</div>\n"; //koniec card-body
    echo "</div>\n"; // koniec card
    echo "</div>\n"; // koniec col-md-6
    

    echo "<div class=\"col-md-6\">\n";

    //echo "<h5>Zmień status zgłoszenia:</h5>";
    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"index.php?wybor=status&id_zgloszenia=" . $_GET['id_zgloszenia'] . "\">";
    //echo "<input type=\"hidden\" name=\"wybor\" value=\"zamowienie\">";
    echo "<fieldset>";

    //<!-- Form Name -->
    //<!-- <legend>Konfigurator wycieczki</legend> -->
    

    echo "<div class=\"form-group\">";
    echo "<h4><label class=\"col-md-6 control-label\" for=\"status\">Status zgłoszenia</label></h4>";
    echo "<div class=\"col-md-6\">";
    echo "<select id=\"status\" name=\"status\" class=\"form-control\" required>";
    //<!--<option></option> -->
    echo "<option value=\"\">Wybierz status</option>";

    $query = "SELECT * FROM `" . $prefix . "_status` ";
    $result = mysqli_query($conn, $query) or die("Zapytanie zakończone niepowodzeniem");

    while ($wynik = mysqli_fetch_assoc($result))
    {

        $name = $wynik['nazwa'];
        $id = $wynik['nazwa'];

        echo "<option value=" . $name . ">" . $name . "</option>";

    }

    echo "</select>";
    echo "</div>";
    echo "</div>";

    //<!-- Button -->
    echo "<div class=\"form-group\">";
    echo "<label class=\"col-md-6 control-label\" for=\"\"></label>";
    echo "<div class=\"col-md-6\">";
    echo "<button id=\"\" name=\"\" class=\"btn btn-success\">Zmień status</button>";
    echo "</div>";
    echo "</div>";

    echo "</fieldset>";
    echo "</form>";

    echo "</div>\n"; //koniec card-body
    echo "</div>\n"; // koniec card
    echo "<p class=\"mt-5\"><a class=\"btn btn-primary\" href=\"?wybor=zgloszenia\">Powrót do zgłoszeń</a></p>\n";
    echo "</div>\n"; // koniec col-md-6
    
}
echo "</div>\n";
echo "</div>\n";

?>
