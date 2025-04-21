<?php
include 'db_connect.php';
session_start();
if (isset($_POST['upload'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        echo "Profile picture uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}
?>

// logout.php
<?php
session_start();
session_destroy();
header("Location: login.php");
?>
