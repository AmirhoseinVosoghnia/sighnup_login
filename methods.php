<?php
include_once 'config.php';

function validate($data) {
    return htmlspecialchars(trim(stripslashes($data)), ENT_QUOTES, 'UTF-8');
}

function signup($data) {
    $conn = dbConnect();
    $username = validate($data['username']);
    $email = validate($data['email']);
    $password = $data['password'];
    $passwordConfirm = $data['passwordConfirm'];

    if ($password !== $passwordConfirm) {
        die('پسوردها مشابه نیستند');
    }
    if (checkUsername($username)) {
        die('نام کاربری از قبل وجود دارد');
    }
    if (checkEmail($email)) {
        die('ایمیل از قبل وجود دارد');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users_tbl (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    if ($stmt->execute()) {
        echo "ثبت نام شما با موفقیت انجام شد";
    }
    $stmt->close();
    $conn->close();
}

function login($data) {
    
    $conn = dbConnect();
    $email = validate($data['email']);
    $password = $data['password'];

   
    $stmt = $conn->prepare("SELECT username, email, password FROM users_tbl WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if (!$user) {
        $_SESSION['error'] = 'Email not found';
        header('Location: ../index.php');
        exit();
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Incorrect password';
        header('Location: ../index.php');
        exit();
    }

    session_regenerate_id(true);
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email']; 
    $_SESSION['token'] = bin2hex(random_bytes(32));


    header('Location: dashboard/index.php');
    exit();
}


function logout() {
    session_start();
    $_SESSION = [];
    setcookie(session_name(), '', time() - 3600, '/');
    session_destroy();
    header('Location: ../index.php');
    exit();
}

function checkUsername($username) {
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT id FROM users_tbl WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

function checkEmail($email) {
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT id FROM users_tbl WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}
?>
