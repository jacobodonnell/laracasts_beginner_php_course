<?php

namespace Core;

class Authenticator
{
    public function logout()
    {
        Session::destroy();
    }

    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email,
        ])->find();

        if ($user && password_verify($password, $user['password'])) {
            $this->login([
                'email' => $email
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email']
        ];

//    session_regenerate_id(true);
    }
}