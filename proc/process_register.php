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

$username = $fields['username']['value'];
$name = $fields['name']['value'];
$pwd = $fields['pwd1']['value'];
$encrypted_pwd = password_hash($pwd, PASSWORD_BCRYPT);

try {
    // Check if username already exists
    $stmt_get_users = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt_get_users->execute([$username]);
    $users_result = $stmt_get_users->fetchAll(PDO::FETCH_ASSOC);

    if (count($users_result) > 0) {
        header('Location: ../view/register.php?error_username=exists');
        exit();
    }

    // Create user
    $conn->beginTransaction();

    $stmt_create_user = $conn->prepare('INSERT INTO user (username, name, pwd) VALUES (:username, :name, :password)');
    $stmt_create_user->bindParam(":username", $username);
    $stmt_create_user->bindParam(":name", $name);
    $stmt_create_user->bindParam(":password", $encrypted_pwd);
    $stmt_create_user->execute();
    $userID = $conn->lastInsertId();
    
    $stmt_get_user = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt_get_user->bindParam(":username", $username);
    $stmt_get_user->execute();
    $user_result = $stmt_get_users->fetchAll(PDO::FETCH_ASSOC);
    $user = $user_result[0];

    $conn->commit();

    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_logged'] = true;
    header('Location: '.'../index.php');

} catch (PDOException  $e) {
    $conn->rollBack();
    echo "Error al hacer registro: ".$e->getMessage();
    //header("location: ../index.php");
}