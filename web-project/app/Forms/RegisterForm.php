<?php

namespace App\Forms;

class	RegisterForm extends \Nette\Application\UI\Form	{
				
				public function init() {								
								$this->addEmail('email', 'Email')
													->setRequired('Pole Email je povinné');
								
								$this->addPassword('password', 'Heslo')
													->addRule($this::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 8)
													->addRule($this::PATTERN, 'Heslo musí obsahovat číslici', '.*[0-9].*')			
													->setRequired('Pole Heslo je povinné');
								
								$this->addPassword('password_2', 'Heslo znovu')
													->setRequired('Pole Heslo znovu je povinné')
													->addRule(self::EQUAL,'Vaše vyplněné heslo se neshoduje.', $this['password']);
								
								$this->addSubmit('send', 'Registrovat');
				}
}
