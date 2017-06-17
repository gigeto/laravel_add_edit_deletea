<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use View;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class HomeController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        
        $product = new Product;
        $user = new User;
        $order = new Order;
        
        $products = $product->get_productsts();
        $users = $user->get_users();
//        $orders = $order->get_all_orders();
        
        $search_range='';
        $search_name='';
        if ($request->has($request['search'])){
            if ($request->has('search_range')) {
                $search_range=$request->input('search_range');
            }
            if ($request->has('search_name')) {
           
                $rules = array(
                    'search_name' => 'regex:/^[a-zA-Z]+$/u',
                );

                $validator = Validator::make(Input::all(),$rules);

                if($validator->fails())
                {
                    return Redirect::to('home')
                            ->withErrors($validator)
                            ->withInput(Input::all());
                }    
                
                $search_name=$request->input('search_name');
            }    
                        
            $orders = $order->get_search_orders($search_range, $search_name);
        } 

        
        if (($request->input('edit')))
        {
            if ($request->has('id')) {
                $id_edit=$request->input('id');
            }
            
            $for_edit = $order->get_current_order($id_edit);    
            
            return View::make('/home', array(
                                        'users' => $users,
                                        'products' => $products,
                                        'orders' => $orders,
                                        'for_edit' => $for_edit,    
                                        ));
            
        }
            return View::make('/home', array(
                                        'users' => $users,
                                        'products' => $products,
                                        'orders' => $orders 
                                        ));
         
    }
    
    public function postData(Request $request)
    { 
       
        if ($request->has($request['add'])) 
        {

            $order = new Order;

            $rules = array(
                'user' => 'required',
                'product' => 'required',
                'quantity' => 'required|numeric',
            );

            $validator = Validator::make(Input::all(),$rules);

            if($validator->fails())
            {
                return Redirect::to('home')
                        ->withErrors($validator)
                        ->withInput(Input::all());
                
            }else{

                if ( $request['product'] ) {
                    $order->product_id =$request['product'];
                }
                if ( $request['user'] ) {
                    $order->user_id =$request['user'];
                }
                if ( $request['quantity'] ) {
                    $order->quantity =$request['quantity'];
                }

                $date = date('Y-m-d H:i:s');
                $order->order_add = $date;
                $order->order_update = $date;

                $order->save(); 
                $fetchedOrder = Order::find($order->id);

                return Redirect::action('HomeController@index');
                
            }
        }
    }
            
    public function deleteOrder(Request $request)
    {
        if ($request->has($request['delete'])) 
        {

            $order = new Order();
            $order->destroy($request['id']); 

            return Redirect::action('HomeController@index');
        
        }
    }
    
    public function editOrder($request)
    {
        
        $product = new Product;
        $user = new User;
        $order = new Order;
        
        if ($request->has($request['edit'])) 
        {
            $for_edit = $order->get_current_order($request['id']); 
        
        
        $products = $product->get_productsts();
        $users = $user->get_users();
        $orders = $order->get_all_orders();
        
        return View::make('/home', array(
                                        'users' => $users,
                                        'products' => $products,
                                        'orders' => $orders,
                                        'for_edit' => $for_edit   
                                        ));
        }
      
    }
    
    public function updateOrder(Request $request)
    { 
       
        if ($request->has($request['update'])) 
        {

            $order = new Order;

            $rules = array(
                'user' => 'required',
                'product' => 'required',
                'quantity' => 'required|numeric',
            );

            $validator = Validator::make(Input::all(),$rules);

            if($validator->fails())
            {
                return Redirect::to('home')
                        ->withErrors($validator)
                        ->withInput(Input::all());
                
            }else{

                if ( $request['id_update']) {
                    $id=$request['id_update'];
                }
                if ( $request['product'] ) {
                    $order['product_id'] =$request['product'];
                }
                if ( $request['user'] ) {
                    $order['user_id'] =$request['user'];
                }
                if ( $request['quantity'] ) {
                    $order['quantity'] =$request['quantity'];
                }

                $date = date('Y-m-d H:i:s');
                $order['order_update'] = $date;

                $order->update_order($id, $order);
                
                return Redirect::action('HomeController@index');
                
            }
        }
    }
 }