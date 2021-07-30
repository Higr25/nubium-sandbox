<?php

namespace App\Forms;

class PasswordForm extends \Nette\Application\UI\Form {

    public function init() {
        $this->addPassword('password', 'Aktuální heslo')
             ->addRule($this::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 8)
             ->addRule($this::PATTERN, 'Heslo musí obsahovat číslici', '.*[0-9].*')
             ->setRequired('Pole Heslo je povinné');

        $this->addPassword('password_new', 'Nové heslo')
             ->addRule($this::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 8)
             ->addRule($this::PATTERN, 'Heslo musí obsahovat číslici', '.*[0-9].*')
             ->setRequired('Pole Heslo je povinné');

        $this->addPassword('password_new_2', 'Nové heslo znovu')
             ->setRequired('Pole Heslo znovu je povinné')
             ->addRule(self::EQUAL, 'Nové heslo a Nové heslo znovu se neshoduje.', $this['password_new']);

        $this->addSubmit('send', 'Registrovat');
    }

}
