<?php
include_once '../assets/controller/methods.php';
if(!isset($_SESSION['token'])) {
    header('Location: ../index.php');
    die;
}

if(isset($_GET['logout'])) {
    logout();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
</head>
<body>
    <h1>Welcome to your panel</h1>
    <hr>
    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?logout'); ?>">
        <button>Logout</button>
        <a href="../assets/controller/generate_pdf.php" target="_blank">
    <button>دانلود مشخصات من (PDF)</button>
    <a href="../assets/controller/generate_word.php" target="_blank">
    <button>دانلود مشخصات من (word)</button>
</a>


</body>
</html>
