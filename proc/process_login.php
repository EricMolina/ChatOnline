<?php

include("./utils.php");
include("./db_connection.php");

session_start();


// Login fields validation

$fields = [
    'username' => ['value' => '', 'required' => true],
    'pwd' => ['value' => '', 'required' => true],
];

$errors = [];

[$fields, $fields_errors] = get_post_fields_values($fields, $_POST);

if ($fields_errors) {
    $query_errors = http_build_query($fields_errors);
    $url = "../view/login.php?".$query_errors;
    header("Location: $url");
    die();
}


// Login process

try {
    $stmt_get_users = $conn -> prepare("SELECT * FROM user WHERE username = :username");
    $stmt_get_users -> bindParam(":username", $fields['username']['value']);
    $stmt_get_users->execute();

    $user = $stmt_get_users->fetch(PDO :: FETCH_ASSOC);

    if (!$user) {
        header('Location: ../view/login.php?error=invalid_login');
        exit();
    }
    if (!password_verify($fields['pwd']['value'], $user['pwd'])) {
        header('Location: ../view/login.php?error=invalid_login');
        exit();
    }

    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_logged'] = true;
    header('Location: '.'../index.php');

} catch (PDOException $e) {
    echo "Error al hacer login: ".$e->getMessage();
    header("location: ../index.php");
}
