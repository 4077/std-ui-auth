<?php namespace std\ui\auth\controllers;

// todo

use std\access\models\User as UserModel;

class Register extends \Controller
{
    public function register()
    {
        $errors = array();

        if ( empty($this->data['email']) || empty($this->data['pass1']) || empty($this->data['pass2']) )
        {
            $errors[] = 'Заполните все поля';
        }
        else
        {
            $email = $this->data['email'];
            $pass1 = $this->data['pass1'];
            $pass2 = $this->data['pass2'];
        }

        //

        if ( !$errors )
        {
            if ( UserModel::whereLogin($email)->orWhere('email', $email)->first() )
                $errors[] = 'На адрес <b>' . $email . '</b> уже зарегистрирован аккаунт';

            if ( $pass1 != $pass2 )
                $errors[] = 'Введенные пароли не совпадают';

            if ( !$errors )
            {
                $mailer = $this->c('/std mail:_mailer');

                $vLetter = $this->v('@letters/register');
                $vLetter->assign(array(
                                      'DOMAIN' => $this->app->domain,
                                      'LOGIN'  => $email,
                                      'PASS'   => $pass1
                                 ));

                $mailer->Subject = 'Ваш аккаунт на ' . $this->app->domain . ' создан';
                $mailer->Body = $vLetter->render();

                $mailer->AddAddress($email);

                if ( !$mailer->isError() )
                {
                    $mailer->Send();

                    UserModel::create(array(
                                      'login' => $email,
                                      'pass'  => md5($pass1),
                                      'email' => $email
                                 ));

                    $this->c('/std/access auth:login',
                             array(
                                  'login'    => $email,
                                  'pass'     => $pass1,
                                  'remember' => 1
                             ));

                    $this->js(':std_auth_register.form_real_submit');
                }
                else
                {
                    $errors[] = 'Мы не смогли отправить письмо на <b>' . $email . '</b><br>Убедитесь, что это действительный e-mail';
                }
            }
        }

        foreach ( $errors as $error )
            $this->error($error);
    }

    //

    public function error($message)
    {
        $this->js(':std_auth_register.error',
                  array(
                       'message' => $message
                  ));
    }

    public function view()
    {
        if ( !$this->_user() )
        {
            $v = $this->v();

            $this->css();
            $this->js(':std_auth_register.form_rebind',
                      array(
                           'path' => $this->_p(':register')
                      ));

            return $v;
        }
        else
        {
            $this->app->response->href();
        }
    }
}