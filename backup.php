<?php

$db_name = 'radovi';
$dir = "backup/$db_name";


/*-----Provjera postoji li direktorij, ukoliko ne postoji, napravi ga-----*/
if (!is_dir($dir)) {
    if (!mkdir($dir)) {
        die("<p>Ne možemo stvoriti direktorij $dir.</p></body></html>");
    }
}

$time = time();


/*-----Spajanje na bazu podataka-----*/
$dbc = @mysqli_connect('localhost', 'root','', $db_name) OR die("<p>Ne možemo se spojiti na bazu $db_name.</p></body></html>");

/*-----Prikaz svih tablica u bazi podataka 'radovi'-----*/
$response = mysqli_query($dbc, 'SHOW TABLES');


/*-----Ako response od baze podataka nije prazan, kreće postupak spremanja podataka-----*/
if (mysqli_num_rows($response) > 0) {
    echo "<p>Backup za bazu podataka '$db_name'.</p>";

    while (list($table) = mysqli_fetch_array($response,MYSQLI_NUM)) {

    $query = "SELECT * FROM $table";
    $r2 = mysqli_query($dbc, $query);
    

    if (mysqli_num_rows($r2) > 0) {
        if ($fp = fopen ("$dir/{$table}_{$time}.txt", 'w9')) {
            $values = [];
            while ($row = mysqli_fetch_array($r2,MYSQLI_NUM)) {
                foreach ($row as $value) {
                /*-----Dohvaceni odaci se odvajaju zarezom-----*/
                $value = addslashes($value);
                $values[] = $value;
               }
               /*-----Izrada stringa u obliku 'value1','value2'... kako bi se mogli ubaciti u insert statement-----*/
               fwrite($fp,"INSERT INTO `diplomski_radovi`(`id`,`naziv_rada`, `tekst_rada`, `link_rada`, `oib_tvrtke`) VALUES ('" . implode("', '", $values) . "')");
               fwrite($fp,";"); 
               fwrite($fp,"\n"); 
               /*-----Na kraju svakog sql insert statementa stavlja se ; te se odlazi u novi red za sljedeći red podataka tablice-----*/
            } 
            fclose ($fp);
            echo "<p>Tablica '$table' je pohranjena.</p>";
        } else { 
            echo "<p>Datoteka $dir/{$table}_{$time}.txt se ne može otvoriti.</p>";
            break; 
        }
    } 
    } 
  } else {
    echo "<p>Baza $db_name ne sadrži tablice.</p>";
  }
?>