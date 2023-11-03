<?php

include("./utils.php");
include("./db_connection.php");

session_start();

// Register fields validation

$fields = [
    'username' => ['value' => '', 'required' => true],
    'name' => ['value' => '', 'required' => true],
    'pwd1' => ['value' => '', 'required' => true],
    'pwd2' => ['value' => '', 'required' => true],
];

$fields_errors = [];

[$fields, $fields_errors] = get_post_fields_values($fields, $_POST);

if ($fields['pwd1']['value'] != $fields['pwd2']['value']) {
    $fields_errors['error_pwd'] = 'invalid';
}

if ($fields_errors) {
    $query_errors = http_build_query($fields_errors);
    $url = "../view/register.php?".$query_errors;
    header("Location: $url");
    die();
}


// Login register

$username = mysqli_escape_string($conn, $fields['username']['value']);
$name = mysqli_escape_string($conn, $fields['name']['value']);
$pwd = mysqli_escape_string($conn, $fields['pwd1']['value']);
$encrypted_pwd = password_hash($pwd, PASSWORD_BCRYPT);

try {
    // Check if username already exists
    $query_get_users = "SELECT * FROM user WHERE username = ?";
    $stmt_get_users = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_get_users, $query_get_users);
    mysqli_stmt_bind_param($stmt_get_users, "s", $username);
    mysqli_stmt_execute($stmt_get_users);

    $users_result = mysqli_stmt_get_result($stmt_get_users);

    if (mysqli_num_rows($users_result) > 0) {
        header('Location: ../view/register.php?error_username=exists');
        exit();
    }

    // Create user
    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    $query_create_user = 'INSERT INTO user VALUES (NULL, ?, ?, ?);';
    $stmt_create_user = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_create_user, $query_create_user);
    mysqli_stmt_bind_param(
        $stmt_create_user,
        "sss",
        $username,
        $name,
        $encrypted_pwd
    );
    mysqli_stmt_execute($stmt_create_user);

    mysqli_commit($conn);

    mysqli_stmt_close($stmt_create_user);
    mysqli_close($conn);

    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_logged'] = true;
    header('Location: '.'../index.php');

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al hacer registro: ".$e->getMessage();
    die();
}