<?php namespace std\ui\auth\controllers;

// todo

use std\access\models\User as UserModel;

class Restore extends \Controller
{
    private

            $restore_key_lifetime = 86400;

    public function request_key()
    {
        if ( $this->dataHas('email') )
        {
            $user = UserModel::whereEmail($this->data['email'])->first();

            if ( $user )
            {
                $restore_key = $user['restore_key'] ? $user['restore_key'] : k(32);

                $mailer = $this->c('/std mail:_mailer');

                $vLetter = $this->v('@letters/restore');
                $vLetter->assign(array(
                                         'RESTORE_LINK' => $this->app->host . '/restore/' . $restore_key
                                 ));

                $mailer->Subject = 'Восстановление доступа ' . $this->app->domain;
                $mailer->Body = $vLetter->render();

                $mailer->AddAddress($user['email']);

                if ( $mailer->Send() )
                {
                    $user->restore_key = $restore_key;
                    $user->restore_key_time = 0;

                    $user->save();

                    $this->raw_js('std_auth_restore.sent_info()');
                }
                else
                {
                    $this->error('E-mail указан правильно, но по каким-то причинам мы не можем отправить на него письмо.<br>Попробуйте позднее или обратитесь к нам по адресу <a href="mailto: info@' . $this->app->domain . '">info@' . $this->app->domain . '</a>');
                }
            }
            else
            {
                $this->error('Неправильный e-mail');
            }
        }
    }

    public function set_new_pass()
    {
        if ( isset($this->data['restore_key']) )
        {
            $errors = array();

            if ( empty($this->data['pass1']) || empty($this->data['pass2']) )
                $errors[] = 'Заполните оба поля';

            if ( !$errors && $this->data['pass1'] != $this->data['pass2'] )
                $errors[] = 'Пароли не совпадают';

            if ( !$errors )
            {
                $user = UserModel::where('restore_key', $this->data['restore_key'])->first();

                if ( $user )
                {
                    $user->pass = md5($this->data['pass1']);
                    $user->restore_key = null;
                    $user->restore_key_time = 0;

                    $user->save();

                    $this->c('/std/access auth:login',
                             array(
                                     'login'    => $user['email'],
                                     'pass'     => $this->data['pass1'],
                                     'remember' => 1
                             ));

                    $this->js(':std_auth_restore.form_real_submit');
                }
            }
            else
            {
                foreach ( $errors as $error )
                    $this->error($error);
            }
        }
    }

    //

    public function error($message)
    {
        $this->js(':std_auth_restore.error',
                  array(
                          'message' => $message
                  ));
    }

    public function reload()
    {
        $this->jquery('#std_auth_restore')->replace($this->view());
    }

    public function view() // todo test
    {
        $v = $this->v();

        $this->css();
        $this->js(':std_auth_restore.rebind',
                  array(
                          'request_key_path'  => $this->_p(':request_key'),
                          'set_new_pass_path' => $this->_p(':set_new_pass')
                  ));

        if ( isset($this->data['uri'][1]) )
        {
            $user = UserModel::whereRestore_key($this->data['uri'][1])->first();

            if ( $user )
            {
                if ( time() > $user['restore_key_time'] + $this->restore_key_lifetime )
                {
                    $v->assign('request_key_outdated');
                }
                else
                {
                    $v->assign('set_new_pass_form',
                               array(
                                       'RESTORE_KEY' => $this->data['uri'][1],
                                       'EMAIL'       => $user['email']
                               ));
                }
            }
            else
            {
                $v->assign('request_key_wrong');
            }
        }
        else
        {
            $v->assign('request_key_form');
        }

        return $v;
    }
}