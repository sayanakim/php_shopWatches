<?php


namespace app\controllers;

use app\models\User;

class UserController extends AppController
{
    public function signupAction () {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
            } else {
                // шифрует пароль в БД
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if ($user->save('user')){
                    $_SESSION['success'] = 'Пользователь успешно зарегистрирован';
                } else {
                    $_SESSION['error'] = 'Ошибка';
                }
            }
            redirect();
        }
        $this->setMeta('Регистрация');
    }

    public function loginAction () {

    }

    public function logoutAction () {

    }
}