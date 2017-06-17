<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author GIGA
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    public $timestamps = false;
    
    protected $table = 'product';
    
    public function get_productsts()
    {
        $result = \DB::select('Select id, name From product');
        
        return $result;
        
//        $products = json_encode($result); 
//        return $products;
    }
        
}
