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

class UsersController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $reques)
    {
        $user = new User;
        
        $users = $user->get_users();

        return View::make('/home', compact('users'));
//        return response()->json($users);
        
    }
        
    
}