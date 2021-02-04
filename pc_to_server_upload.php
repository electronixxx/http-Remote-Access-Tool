<?php


move_uploaded_file($_FILES["file"]["tmp_name"], "downloads/" . $_FILES["file"]["name"]);
echo realpath("downloads/" . $_FILES["file"]["name"]);


?>