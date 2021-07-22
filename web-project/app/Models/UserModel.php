<?php

namespace App\Models;

use App\Models\BaseModel;
use Nette\Security\Passwords;

class UserModel extends BaseModel {

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
        $passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);

        return $id = $this->db->table('t_user')
                ->insert([
            'login' => $values['email'],
            'password' => $passwords->hash($values['password']),
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
        $passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);

        $this->db->table('t_user')
                ->where('login', $email)
                ->update([
                    'password' => $passwords->hash($values['password_new'])
        ]);
    }

}
