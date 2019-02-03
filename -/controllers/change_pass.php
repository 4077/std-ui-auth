<?php namespace std\ui\auth\controllers;

// TODO std\ui\auth

use std\access\models\User as UserModel;

class Change_pass extends \Controller
{
    public function change_pass()
    {
        if ( $this->_user() )
        {
            $errors = array();

            if ( isset($this->data['current_pass']) && isset($this->data['pass1']) && isset($this->data['pass2']) )
            {
                if ( empty($this->data['current_pass']) || empty($this->data['pass1']) || empty($this->data['pass2']) )
                    $errors[] = 'Заполните все поля';

                if ( $this->data['pass1'] != $this->data['pass2'] )
                    $errors[] = 'Пароли не совпадают';

                $user = UserModel::find($this->_user('id'));

                if ( !empty($this->data['current_pass']) && $user['pass'] != md5($this->data['current_pass']) )
                    $errors[] = 'Неверный текущий пароль';

                if ( !$errors )
                {
                    $user->pass = md5($this->data['pass1']);
                    $user->save();

                    $this->c('/std/access auth:login',
                             array(
                                     'login'    => $user['login'],
                                     'pass'     => $this->data['pass1'],
                                     'remember' => 1
                             ));

                    $this->js(':std_auth_change_pass.form_real_submit');
                }
                else
                {
                    foreach ( $errors as $error )
                        $this->error($error);
                }
            }
        }
    }

    //

    public function error($message)
    {
        $this->js(':std_auth_change_pass.error',
                  array(
                          'message' => $message
                  ));
    }

    public function view()
    {
        if ( $this->_user() )
        {
            $v = $this->v();

            $this->css();
            $this->js(':std_auth_change_pass.form_rebind',
                      array(
                              'path' => $this->_p(':change_pass')
                      ));

            return $v;
        }
    }
}