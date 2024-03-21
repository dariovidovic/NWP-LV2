<?php
session_start(); ?>


<?php

$target_dir = "uploads/";
$target_file = $target_dir.basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


/*-----Provjera dozvoljenih tipova dokumenta za upload-----*/
if($imageFileType != "pdf" && $imageFileType != "jpg" && $imageFileType != "jpeg") {
  echo "Dozvoljeni tipovi dokumenta: PDF, JPG & JPEG.";
  $uploadOk = 0;
}


/*-----Provjera je li dokument za upload prevelik-----*/
if ($_FILES["file"]["size"] > 5000000) {
    echo "Dokument je prevelik.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Dokument nije pohranjen.";
  } else {

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        /*----------Proces kriptiranja podataka----------*/
        $encryption_key = md5('napredno web programiranje');
        $cipher = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher);
        $options = 0;
        $encryption_iv = random_bytes($iv_length); 
        $encryptedData = openssl_encrypt(file_get_contents($target_file) , $cipher, $encryption_key, $options , $encryption_iv );
       
        /*-----Enkriptirani file ce biti savean u uploads/ dir-u s prefiksom encrypted_(originalno ime)*/
        $encrypted_file_path = $target_dir . 'encrypted_' . basename($_FILES["file"]["name"]);
        file_put_contents($encrypted_file_path, $encryptedData);

        $_SESSION['iv'] = $encryption_iv;
        /*-----------------------------------------------*/

        /*-----Brisanje originalnog dokumenta koji nije enkriptiran-----*/
        unlink($target_file);

        echo "Dokument je uspješno pohranjen i enkriptiran.";
    
      } else {
        echo "Pogreška prilikom pohrane dokumenta.";
      }

  }

?>
