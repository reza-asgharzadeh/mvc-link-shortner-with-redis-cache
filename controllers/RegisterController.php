<?php
namespace app\controllers;
use app\models\User;
use app\Router;

class RegisterController{

    public function create(Router $router)
    {
        $router->renderView('users/register/create');
    }

    public function store(Router $router)
    {
        $userData['fullName'] = $_POST['fullName'];
        $userData['email'] = $_POST['email'];
        $userData['password'] = md5($_POST['password']);

        $sql = "SELECT * FROM users where email=? LIMIT 1";
        $record = $router->database->getUserEmail($sql,$userData['email']);

        //Check Errors
        $errors = [];

        if($record){
            $errors[] = "با این ایمیل قبلا ثبت نام کرده اید";
        }

        if (!$userData['fullName']) {
            $errors[] = 'نام را وارد کنید';
        }

        if (!$userData['email']) {
            $errors[] = 'ایمیل را وارد کنید';
        }

        if (!$_POST['password']) {
            $errors[] = 'رمز عبور را وارد کنید';
        }

        $router->renderView('users/register/create',[
            'errors' => $errors
        ]);

        if (empty($errors)){
            $user = new User();
            $user->load($userData);
            $user->save();
            header("Location: /login");
        }
    }
}