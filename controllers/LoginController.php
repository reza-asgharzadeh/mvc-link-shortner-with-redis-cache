<?php
namespace app\controllers;
use app\Router;

class LoginController{

    public function create(Router $router)
    {
        $router->renderView('users/login/auth');
    }

    public function check(Router $router)
    {
        //login user with OOP and PDO
        $sql = "SELECT * FROM users where email=? LIMIT 1";
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $record = $router->database->getUserEmail($sql,$email);

        $errors = [];

        if (!$email) {
            $errors[] = 'ایمیل را وارد کنید';
        }

        if (!$_POST['password']) {
            $errors[] = 'رمز عبور را وارد کنید';
        }

        //Check Email and Password Doesn't exist in Database
        if(!$record || $record['password'] != $password){
            $errors[] = "ایمیل یا رمز عبور شما اشتباه است";
        }

        $router->renderView('users/login/auth',[
            'errors' => $errors
        ]);

        //if the email exist and password correct redirect to /links
        if (empty($errors)) {
            $_SESSION['user_id'] = $record['id'];
            $_SESSION['email'] = $record['email'];
            header("Location: /links");
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
    }
}