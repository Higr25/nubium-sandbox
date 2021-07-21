<?php

namespace	App\Models;

use Nette\Database\Context;
use Nette\Security\Passwords;

class	BaseModel	{
				
				public $passwords;
				public $db;
    
    public function __construct(Context $db, Passwords $passwords) {
								$this->passwords = $passwords;
        $this->db = $db;
    }
}
