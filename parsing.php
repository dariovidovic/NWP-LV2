<?php
/*-----Funkcija rukovanja oznakom za pocetak-----*/
function handle_open_element($p, $element) {
    switch ($element) {
    case 'DATASET':
    case 'RECORD':
    echo '<div>';
    break;
    case 'ID': 
    echo "<p>ID:";
    break;
    case 'IME': 
    echo "<p>Ime:";
    break;
    case 'PREZIME': 
    echo "<p>Prezime:";
    break;
    case 'EMAIL': 
    echo "<p>E-mail:";
    break;
    case 'SPOL': 
    echo "<p>Spol:";
    break;
    case 'SLIKA': 
    echo "<img src=\"";
    break;
    case 'ZIVOTOPIS':
    echo "<p>Zivotopis:";
    break;
    } 
 }
/*-----------------------------------------------*/



 /*-----Funkcija rukovanja oznakom za kraj-----*/
 function handle_close_element($p, $element) {
    switch ($element) {
        case 'DATASET':
        case 'RECORD':
        echo '</div>';
        break;
        case 'ID':
        case 'IME':
        case 'PREZIME':
        case 'EMAIL':
        case 'SPOL':
        case 'ZIVOTOPIS':
        echo '</p>';
        break;
        case 'SLIKA':
        echo '\">'; 
        break;
    } 
}
/*----------------------------------------------*/

/*----------Funkcija za rukovanje podacima u XML-u----------*/
function handle_character_data($p, $cdata) {
    echo $cdata;
}
        
$p = xml_parser_create();
xml_set_element_handler($p,'handle_open_element','handle_close_element');
xml_set_character_data_handler($p,'handle_character_data');

$file = 'lv2.xml';
$fp = @fopen($file, 'r') or die("<p>Ne možemo otvoriti datoteku '$file'.</p></body></html>");

/*-----Čitanje podataka iz LV2.xml i parsiranje s XML parserom-----*/
while ($data = fread($fp, 4096)) {
xml_parse($p, $data, feof($fp));
}

xml_parser_free($p);

?>