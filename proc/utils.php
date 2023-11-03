<?php

function check_required_field_value($fieldname, $post) {
    $field_error = '';
    $value = null;
    if (isset($post[$fieldname]) && !empty($post[$fieldname])) {
        $value = $post[$fieldname];
    } else {
        $field_error = "error_".$fieldname;
    }

    return [$value, $field_error];
}


function get_post_fields_values($fields, $post) {
    $errors = [];

    foreach ($fields as $field => $field_data) {
        if ($field_data['required']) {
            // Get the required field value and error
            [$value, $field_error] = check_required_field_value($field, $post);
        } else {
            // Get the field value from request
            $value = $_POST[$field] ? $_POST[$field] : '';
        }
    
        if ($value) {
            // Set the field value
            $fields[$field]['value'] = $value;
        }
    
        if ($field_error) {
            // Set the field error if it has
            $errors[$field_error] = 'required';
        }
    }

    return [$fields, $errors];
}


function check_user_login($redirect_url) {
    /*  Cheking if isset is_logged session variable */
    if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] != true) {
        header("Location: $redirect_url");
        exit();
    }
}


function get_user_logedin() {
    $logged_user = [
        "id" => $_SESSION['user_id'],
        "username" => $_SESSION['user_username'],
        "name" => $_SESSION['user_name']
    ];
    return $logged_user;
}

?>