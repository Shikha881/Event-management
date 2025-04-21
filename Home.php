<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php if (!empty($user['profile_picture'])): ?>
        <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="profile-img">
    <?php endif; ?>
    <h2>Welcome, <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>!</h2>
    <p>Contact: <?php echo $user['contact']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Event: <?php echo $user['event']; ?></p>
    <form method="POST" action="home.php" enctype="multipart/form-data">
        <input type="file" name="profile_picture" required>
        <button type="submit" name="upload">Upload Profile Picture</button>
    </form>
    <?php
    if (isset($_POST['upload'])) {
        $file = $_FILES['profile_picture'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileDestination = 'uploads/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination);
        $updateQuery = "UPDATE users SET profile_picture='$fileDestination' WHERE email='{$user['email']}'";
        $conn->query($updateQuery);
        $_SESSION['user']['profile_picture'] = $fileDestination;
        header("Location: home.php"); // Refresh page to show uploaded image
    }
    ?>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
