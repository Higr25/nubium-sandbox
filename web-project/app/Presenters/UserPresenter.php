<?php

namespace	App\Presenters;

use App\Forms\RegisterForm;
use App\Forms\LoginForm;
use App\Forms\PasswordForm;
use App\Models\UserModel;
use Nette\Security\Identity;

class	UserPresenter extends \Nette\Application\UI\Presenter	{
			 
				/** @var UserModel @inject */
				public $model;
				
				public function actionLogout() {
								$this->getUser()->logOut(true);
								$this->redirect(":Post:default");
				}
				
				public function createComponentRegisterForm() {
								$form = new RegisterForm();
								$form->init();
								
								$form->onValidate[] = [$this, 'onRegisterValidate'];
								$form->onSuccess[] = [$this, 'onRegisterSuccess'];
								
								return $form;
				}
				
				public function onRegisterValidate(RegisterForm $form, $values) {
								$u = $this->model->getUser($values['email']);
																
								if ($u) {
												$form->addError('Tento email je již registrovaný');
												return;
								}
				}
				
				public function onRegisterSuccess(RegisterForm $form, $values) {								
								$values['created_ip'] = $this->getHttpRequest()->remoteAddress;
								
								$row = $this->model->registerUser($values);
																
								$this->getUser()->login(new Identity($row->id, 'registered', ['email' => $values['email']]));
								
								$this->redirect(":Post:default");
				}
				
				public function createComponentLoginForm() {
								$form = new LoginForm();
								$form->init();
								
								$form->onValidate[] = [$this, 'onLoginValidate'];
								
								return $form;
				}
				
				public function onLoginValidate(LoginForm $form, $values) {
								$u = $this->model->getUser($values['email']);
																
								if (!$u) {
												$form->addError('Přihlašovací údaje nejsou správné.');
												return;
								}
								
								$pwdMatch = $this->model->passwords->verify($values['password'], $u->password);
								
								if (!$pwdMatch) {
												$form->addError('Přihlašovací údaje nejsou správné.');
												return;
								}
								
								$this->getUser()->login(new Identity($u->id, 'registered', ['email' => $values['email']]));
								$this->redirect(":Post:default");
				}
				
				public function createComponentPasswordForm() {
								$form = new PasswordForm();
								$form->init();
								
								$form->onValidate[] = [$this, 'onPasswordValidate'];
								
								return $form;
				}
				
				public function onPasswordValidate(PasswordForm $form, $values) {
								$u = $this->model->getUser($this->getUser()->identity->email);
																
								if (!$u) {
												$form->addError('Uživatel neexistuje.');
												return;
								}
								
								$pwdMatch = $this->model->passwords->verify($values['password'], $u->password);
								
								if (!$pwdMatch) {
												$form->addError('Vyplněné heslo se neshoduje.');
												return;
								}
								
								$this->model->updatePassword($values, $u->login);
								
								$this->flashMessage('Heslo bylo úspěšně změněno.',	'success');
								$this->redirect('Post:default');
				}
}
