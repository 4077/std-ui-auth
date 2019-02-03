<?php namespace std\ui\auth\controllers\login;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function login()
    {
        $login = $this->data('login');
        $pass = $this->data('pass');

        if ($login && $pass) {
            if ($phone = $this->parsePhone($login)) {
                $login = $phone;
            }

            $logged = $this->app->access->auth->login($login, $pass);

            if ($logged) {
                $this->widget('<:', 'formRealSubmit');
            } else {
                $this->c('<:error', [
                    'message' => 'Неправильный логин или пароль'
                ]);
            }
        } else {
            if (!$login && !$pass) {
                $this->c('<:error', [
                    'message' => 'Не указаны логин и пароль'
                ]);
            } else {
                if (!$login) {
                    $this->c('<:error', [
                        'message' => 'Не указан логин'
                    ]);
                }

                if (!$pass) {
                    $this->c('<:error', [
                        'message' => 'Не указан пароль'
                    ]);
                }
            }
        }
    }

    private function parsePhone($login)
    {
        $phone = \ewma\Data\Formats\Phone::parse($login, 7);

        if (is_numeric($phone) && strlen($phone) == 11) {
            return $phone;
        }
    }
}
