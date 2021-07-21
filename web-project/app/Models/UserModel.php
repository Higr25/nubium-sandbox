<?php

namespace	App\Models;

use App\Models\BaseModel;

class	UserModel extends BaseModel	{
				use \Nette\SmartObject;
				
				/**
				 * Return user by email
				 * @param string $email
				 */
				public function getUser($email) {								
								return $this->db->table('t_user')
																								->where('login', $email)
																								->fetch();
				}
				
				/**
				 * Register user
				 * @param array $values
				 */
				public function registerUser($values) {
							return $id = $this->db->table('t_user')
																												->insert([
																															'login' => $values['email']	,
																															'password' => $this->passwords->hash($values['password']),
																															'created_at' => new \Nette\Utils\DateTime(),
																															'created_ip' => $values['created_ip'],
																															'active' => 1
																												]);
				}
				
				/**
				 * Update user password
				 * @param array $values
				 * @param string $email
				 */
				public function updatePassword($values, $email) {
								$this->db->table('t_user')
																 ->where('login', $email)
																 ->update([
																				'password' => $this->passwords->hash($values['password_new'])
																	]);
				}
}
