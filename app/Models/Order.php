<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author GIGA
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    
    public $timestamps = false;
    
    protected $table = 'order';
    
    public $fillable = ['product_id','user_id', 'order_add', 'order_update', 'quantity']; 
    
    /*
     * Get data to show in table
     * $range, $name - filter requests
     */
    
    public function get_search_orders($range, $name){

        $where_r='';
        $where_n='';
        if($range==1){
            $where_r = ' ';
        }
        if($range==2){
            $where_r = ' AND (DATE(o.order_add) >= date_sub(date(now()), INTERVAL 1 week)) ';
        }
        if($range==3){
            $where_r = ' AND (DATE(o.order_add) = date(now())) ';
        }
        
        if(!empty($name)){
            $where_n = ' AND (p.name Like "%'.$name.'%"
                                    or Concat(u.first_name,u.family_name) Like "%'.$name.'%"
                                    )  '; 
        }
        
        $res = \DB::select('Select o.id,
                                    Concat(u.first_name,u.family_name) as uname, 
                                    p.name, 
                                    p.price,
                                    o.quantity, 
                                    date(o.order_add) as order_add,
                                    case when (o.quantity >= 3 and p.id = 2) then 
                                        ROUND((((p.price * o.quantity)/100)*80), 2)  
                                    else
                                        ROUND((p.price * o.quantity) ,2)
                                    end as total
                            From `order` o
                            Left Join product p On p.id = o.product_id
                            Left Join user u On u.id = o.user_id
                            Where 1=1 
                            '.$where_r.' 
                            '.$where_n.' Order by id desc'       
                );

        return $res;
        
    }
    
    /*
     * Get row for update by id
     * $id or row, witch will be update
     * return data for update
     */
    
    public function get_current_order($id){
        
        $res = \DB::select('Select 
                                    o.id,
                                    o.product_id, 
                                    o.user_id,
                                    o.quantity
                            From `order` o
                            Where o.id='.$id.'
                            ');

        return $res;
    } 
    
    /*
     * Update orders table function
     * $id - id wich will be update
     * $data - data for update
     */
    
    public function update_order($id, $data)
    {
  
        if(empty($id)){
            return false;
        }
        
        $res = \DB::update("Update `order`
                            Set product_id=".$data['product_id'].", user_id=".$data['user_id'].", quantity=".$data['quantity'].", order_update='".$data['order_update']."'
                            WHERE id=".$id);
        return $res;
        
    }
    
}
