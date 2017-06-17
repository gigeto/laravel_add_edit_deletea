<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author GIGA
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    
    public $timestamps = false;
    
    protected $table = 'user';
    
    public function get_users()
    {
        $users = \DB::select('Select id, CONCAT(first_name, family_name) as name From user');
        return $users;
    }
    
    
}
