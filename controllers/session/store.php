<?php

use Core\App;
use Core\Database;
use Core\Validator;


$email = $_POST['email'];
$password = $_POST['password'];

// validate the form inputs
$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address';
}
if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a valid password';
}

if (!empty($errors)) {
    return view('session/create.view.php', [
        'errors' => $errors
    ]);
}

// log in the user if the credentials match
$db = App::resolve(Database::class);

$user = $db->query('select * from users where email = :email', [
    'email' => $email,
])->find();

if (!$user || !password_verify($password, $user['password'])) {
    $errors['password'] = 'No valid account with that email and password combination';
    return view('session/create.view.php', [
        'errors' => $errors
    ]);
}

login([
    'email' => $email
]);

header('location: /');
exit();