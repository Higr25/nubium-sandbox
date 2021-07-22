<?php

namespace App\Models;

use Nette\Database\Context;

class BaseModel {

    public $db;

    public function __construct(Context $db) {
        $this->db = $db;
    }

}
