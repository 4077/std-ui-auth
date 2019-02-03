<?php namespace std\ui\auth\controllers;

class Login extends \Controller
{
    public function error()
    {
        $this->widget(':', 'addError', $this->data('message'));
    }

    public function formSubmit()
    {
        if ($this->dataHas('redirect')) {
            $this->app->response->redirect($this->data['redirect'], 303);

            return true;
        }
    }

    public function view()
    {
        if (!$this->_user()) {
            $v = $this->v();

            $v->assign([
                           'FORM_SUBMIT_ROUTE'     => force_slashes($this->data('form_submit_route')),
                           'REDIRECT'              => $this->data('redirect'),
                           'RESTORE_ACCESS_BUTTON' => $this->c('\std\ui route:view', [ // todo
                               'visible' => false,
                               'path'    => '/restore/',
                               'class'   => 'restore_access_button',
                               'content' => 'Восстановление доступа'
                           ])
                       ]);

            $this->css();
            $this->widget(':', [
                'paths'      => [
                    'login' => $this->_p('>xhr:login')
                ],
                'bodyColors' => $this->getBodyColors()
            ]);

            return $v;
        } else {
            $this->app->response->redirect($this->data('user_redirect_route'));

            return true;
        }
    }

    private function getBodyColors()
    {
        return l2a('#735555, #735572, #555673, #557371, #567355, #737055');
    }
}