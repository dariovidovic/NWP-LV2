<?php
session_start(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWP-LV2</title>
</head>
<body>

<!--Forme za uploadanje i dohvat dokumenata-->
<form action="submit.php" method="post" enctype="multipart/form-data">
  Select file to upload:
  <input type="file" name="file" id="file">
  <input type="submit" value="Submit" name="submit">
</form>

<form action="list.php" method="get">
  List all the encrypted files:
  <input type="submit" value="List encrypted files" name="submit">
</form>

</body>
</html>



