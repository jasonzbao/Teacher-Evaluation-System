<?php
$uploaddir = './rubrics/';
$uploadfile = $uploaddir . $_POST['rubricImageId'].".".substr($_FILES['rubricImage']['type'],6);
if (move_uploaded_file($_FILES['rubricImage']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
?>