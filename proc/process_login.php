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

$username = mysqli_escape_string($conn, $fields['username']['value']);
$pwd = mysqli_escape_string($conn, $fields['pwd']['value']);

try {
    $query_get_users = "SELECT * FROM user WHERE username = ?";
    $stmt_get_users = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_get_users, $query_get_users);
    mysqli_stmt_bind_param($stmt_get_users, "s", $username);
    mysqli_stmt_execute($stmt_get_users);

    $users_result = mysqli_stmt_get_result($stmt_get_users);

    if (mysqli_num_rows($users_result) == 0) {
        header('Location: ../view/login.php?error=invalid_login');
        exit();
    }

    $users_result = mysqli_fetch_all($users_result, MYSQLI_ASSOC); 
    $user = $users_result[0];

    if (!password_verify($pwd, $user['pwd'])) {
        header('Location: ../view/login.php?error=invalid_login');
        exit();
    }

    mysqli_stmt_close($stmt_get_users);
    mysqli_close($conn);

    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_logged'] = true;
    header('Location: '.'../index.php');

} catch (Exception $e) {
    echo "Error al hacer login: ".$e->getMessage();
    mysqli_close($conn);
    header("location: ../index.php");
}
