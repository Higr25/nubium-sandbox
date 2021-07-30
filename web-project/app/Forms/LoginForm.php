<?php

namespace App\Forms;

class LoginForm extends \Nette\Application\UI\Form {

    public function init() {
        $this->addEmail('email', 'Email')
             ->setRequired('Pole Email je povinné');

        $this->addPassword('password', 'Heslo')
             ->setRequired('Pole Heslo je povinné');

        $this->addSubmit('send', 'Přihlásit');
    }

}
