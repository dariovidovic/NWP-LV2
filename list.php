<?php

session_start();

$encrypted_files_dir = "uploads/";
if (isset($_SESSION['iv']) && is_dir($encrypted_files_dir)) {

    $download_links = '';
    /*-----Vraćanje svih dokumenata iz direktorija uploads/-----*/
    $files = scandir($encrypted_files_dir);

    /*-----Dekripcija podataka s OpenSSL-----*/
    $decryption_key = md5('napredno web programiranje');
    $cipher = 'AES-128-CTR';
    $options = 0;
    $decryption_iv = $_SESSION['iv'];
   
    foreach($files as $file) {

        /*-----Preskakanje direktorija-----*/
        if($file == '.' || $file == '..') {
            continue;
        }

        $decrypted_filename = basename($file);
        $decrypted_file_content = openssl_decrypt(file_get_contents($encrypted_files_dir . $file), $cipher, $decryption_key, $options, $decryption_iv);

        /*-----Spremanje dekriptiranih podataka u novi dokument-----*/
        file_put_contents($decrypted_filename, $decrypted_file_content);

        /*-----Za svaki enkriptirani dokument radi se link za preuzimanje-----*/
        $download_link = '<a href="' . $decrypted_filename . '">Download ' . $file . '</a>';

        $download_links .= $download_link . '<br>';
    }

    echo $download_links;
    }
    else {
        echo "Na serveru nema enkriptiranih dokumenata.";
    }

?>