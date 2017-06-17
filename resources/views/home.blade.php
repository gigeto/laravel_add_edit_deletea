<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Order page</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <style>
            .margin_t{
                margin-top: 10px;
            }
        </style>
        
    </head>
    <body>
    <div class='container'> 
      	
        <h1>ADD ORDER</h1>
       
        
 @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @if (isset($for_edit))
        <form class="margin_top col-sm-6" action="updateData" name="form" method="post" enctype="multipart/form-data">
            @foreach($for_edit as $fe)
            <input type="hidden" class="margin_t form-control" id="id_update" name="id_update" value='{{$fe->id}}' type="text" size="30">
            @endforeach
    @else
        <form class="margin_top col-sm-6" action="addData" name="form" method="post" enctype="multipart/form-data">
    @endif
            
            <label for="user">User</label>    
            <select class="form-control" id="user" placeholder="Select User" name="user">
                @foreach($users as $user)
                    @if (isset($for_edit))
                        @foreach($for_edit as $fe)
                            @if($fe->user_id == $user->id)
                                <option selected="true" value="{{$user->id}}">{{$user->name}}</option>
                            @else
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endif
                        @endforeach
                    @else
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endif
                @endforeach
            </select>

            <label for="product">Product</label>    
            <select class="form-control" id="product" placeholder="Select Product" name="product">
               
                @foreach($products as $product)
                    @if (isset($for_edit))
                        @foreach($for_edit as $fe)
                            @if($fe->product_id == $product->id)
                                <option selected="true" value="{{$product->id}}">{{$product->name}}</option>
                            @else
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endif
                        @endforeach
                    @else
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endif
                @endforeach
                
            </select>
            
            <label for="quantity">Quantity</label>   
            @if (isset($for_edit))
                @foreach($for_edit as $fe)
                    <input class="form-control" id="quantity" name="quantity" value='{{$fe->quantity}}' type="text" size="30">
                @endforeach
                <input type='submit' name='update' class='margin_t btn btn-default' value="update"></input>
            @else 
                <input class="form-control" id="quantity" name="quantity" value='' type="text" size="30">
                <input type='submit' name='add' class='margin_t btn btn-default' value="add"></input>
            @endif     

            <input type="hidden" name="_token" value="{{!! csrf_token() !!}}">
        {!! csrf_field() !!}
        </form> 

        <form class="margin_top col-sm-6" action="home" name="search" method="post" enctype="multipart/form-data">

            <label for="product">Search</label>    
            <select class="form-control" id="search_range" name="search_range">
                <option value="1">All time</option>
                <option value="2">Last 7 days</option>
                <option value="3">Today</option>
            </select>
            <input class="margin_t form-control" id="search_name" placeholder="enter search term" name="search_name" type="text" size="30">
            <input type='submit' name='search' class='margin_t btn btn-default' value="search"></input>
            {!! csrf_field() !!}
        </form>    

        <div class='container'>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->uname}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->order_add}}</td>
                    <td>
                        <form name="form" action="deleteData" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <button type='submit' name='delete' class='btn btn-default' value="delete">Delete</button>
                            <!--<input type='submit' name='delete' class='btn btn-default' value="delete"></input>-->
                            {!! csrf_field() !!}
                        </form>    
                    </td>
                    <td>
                        <form name="edit" action="home" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <button type='submit' name='edit' class='btn btn-default' value="edit">Edit</button>
                            <!--<input type='submit' name='edit' class='btn btn-default' value="edit"></input>-->
                            {!! csrf_field() !!}
                        </form>    
                    </td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        </div>

        </div>
    </body>
</html>    