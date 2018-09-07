<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Price;
use App\Category;
use App\Tax;
use App\ProductImage;
use App\Comment;
use App\OrderProduct;
use App\Order;
use Carbon\Carbon;

class ProductController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {

//        $products =  \DB::table('product')
//            ->leftJoin('category', 'category.id', '=', 'product.category_id')
//            ->leftJoin('price', 'price.product_id', '=', 'product.id')
//            ->leftJoin('tax', 'tax.product_id', '=', 'product.id')
//            ->select(
//                'product.id',
//                'product.name',
//                'product.description',
//                'product.category_id',
//                'category.name as category_name',
//                'price.price',
//                'tax.tax',
//                'product.created_at',
//                'product.updated_at'
//            )->orderBy('product.id', 'asc')->orderBy('price.id', 'asc')->get();

        $products = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at')
            ->orderBy('t1.id', 'asc')->orderBy('t2.id', 'asc')->get();

        $popular_products_week = $products;

        //$products = json_decode($products, true);
//        $array = json_decode(json_encode($products), true);
//        $data = [];
//        foreach($array as $pr){
//            $data[$pr["id"]] = $pr;
//        }
//        $products = json_decode(json_encode($data));

        //$products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        //$prices = $products->prices();

        return view('admin.add_product', ["products" => $products, "categories" => $categories,
        "popular_products_week" => $popular_products_week]);
    }

    public function saveProduct(Request $request)
    {
        $saved_price = true;
        $saved_tax = true;

        $this->validate($request,[
            'files' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'tax' => 'required',
            'category_id' => 'required|not_in:-1',
        ]);

        $product_id = $request["product_id"];
        $product_name = $request["product_name"];
        $product_price = $request["price"];
        $product_tax = $request["tax"];
        $description = $request["description"];
        $category_id = $request["category_id"];

        //var_dump($_FILES);

        $images = $request->file('files');
        $images_array = [];
        if($images[0] != null){
            foreach($images as $im){
                $fileName = $im->getClientOriginalName();
                $im->move("images/products/", $fileName);
                $images_array[] = $fileName;
            }
        }


        if($product_id == "-1"){

            $product = new Product();
            $product->name = $product_name;
            $product->category_id = $category_id;
            $product->description = $description;
            $saved = $product->save();
            $inserted_id = $product->id;

            if($saved){

                $price = new Price();
                $price->price = $product_price;
                $price->product_id = $inserted_id;
                $saved_price = $price->save();

                $tax = new Tax();
                $tax->tax = $product_tax;
                $tax->product_id = $inserted_id;
                $saved_tax = $tax->save();

                foreach($images_array as $im){
                    $image = new ProductImage();
                    $image->product_id = $inserted_id;
                    $image->image = "/images/products/" . $im;
                    $image->main = 0;
                    $saved_image = $image->save();
                    if(!$saved_image)
                        break;
                }
            }
        }
        else{

            $product = Product::find($product_id);
            $product->name = $product_name;
            $product->description = $description;
            $product->category_id = $category_id;
            $saved = $product->update();

            if($saved){

                $old_price = $request["old_price"];
                $old_tax = $request["old_tax"];

                if($product_price != $old_price){

                    $price = new Price();
                    $price->price = $product_price;
                    $price->product_id = $product_id;
                    $saved_price = $price->save();
                }
                if($product_tax != $old_tax){

                    $tax = new Tax();
                    $tax->tax = $product_tax;
                    $tax->product_id = $product_id;
                    $saved_tax = $tax->save();
                }

                foreach($images_array as $im){
                    $image = new ProductImage();
                    $image->product_id = $product_id;
                    $image->image = "/images/products/" . $im;
                    $image->main = 0;
                    $saved_image = $image->save();
                    if(!$saved_image)
                        break;
                }
            }
        }

        if($saved && $saved_price && $saved_tax)
            $message = "Dodato uspješno";
        else
            $message = "Greška prilikom dodavanja";

        return redirect()->route('add_product')->with(['message' => $message]);

    }

    public function showHistory($product_id){

        $product = Product::find($product_id);
        $prices = $product->prices()->orderBy('created_at', 'desc')->get();
        $taxes = $product->taxes()->orderBy('created_at', 'desc')->get();

        return response()->json(['prices' => $prices, "taxes" => $taxes, "product" => $product], 200);
    }

    public function list_all(){

        $user_obj = Auth::user();
        if($user_obj){
            $user_id = $user_obj->id;
        }
        else{
            $user_id = 0;
        }


//        $products =  \DB::table('product')
//            ->leftJoin('category', 'category.id', '=', 'product.category_id')
//            ->leftJoin('price', 'price.product_id', '=', 'product.id')
//            ->leftJoin('tax', 'tax.product_id', '=', 'product.id')
//            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.id')
//            ->select(
//                'product.id',
//                'product.name',
//                'product.description',
//                'product.category_id',
//                'category.name as category_name',
//                'price.price',
//                'tax.tax',
//                'image',
//                'product.created_at',
//                'product.updated_at'
//            )->groupBy('product.id')->orderBy('product.id', 'asc')
//            ->orderBy('price.id', 'asc')->orderBy('product_image.id', 'asc')->limit(5)->get();

        $products = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->leftJoin('order_product', 'order_product.product_id', '=', 't1.id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at',
                \DB::raw('SUM(quantity) as orders'))
            ->orderBy('orders', 'desc')->orderBy('t4.id', 'asc')->groupBy("t1.id")->limit(8)->get();

        $now = Carbon::now();
        $last_week = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('-1 week')));
        $last_month = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('-30 day')));
//
//        $last_week = date('Y-m-d H:i:s', strtotime('-1 week'));
//        $last_month = date('Y-m-d H:i:s', strtotime('-30 day'));
//        $mytime = Carbon::now();


        $popular_products_week = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->leftJoin('order_product', 'order_product.product_id', '=', 't1.id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at',
                \DB::raw('SUM(quantity) as orders'))
            ->orderBy('orders', 'desc')->orderBy('t4.id', 'asc')->whereDate('order_product.created_at', '>', $last_week)->groupBy("t1.id")->limit(8)->get();

        $popular_products_month = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->leftJoin('order_product', 'order_product.product_id', '=', 't1.id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at',
                \DB::raw('SUM(quantity) as orders'))
            ->orderBy('orders', 'desc')->whereDate('order_product.created_at', '>', $last_month)->groupBy("t1.id")->limit(8)->get();



//        $array = json_decode(json_encode($products), true);
//        $data = [];
//        foreach($array as $pr){
//            $data[$pr["id"]] = $pr;
//        }
//        $products = json_decode(json_encode($data))

//        $popular_products_week  = $products;
//        $popular_products_month   = $products;
        $popular_products_all   = $products;
        $product_week_count  = count($popular_products_week);
        $product_month_count   = count($popular_products_month);

        $categories = Category::orderBy('created_at', 'desc')->get();

        //$orders = OrderProduct::orderBy('created_at', 'desc')->where(["payment_type" => "not submitted"])->get();
        $orders = \DB::table('order')
            ->join('order_product', 'order.id', '=', 'order_product.order_id')
            ->select('order_product.*')
            ->where(["payment_status" => "not submitted", "user_id" => $user_id])
            ->get();

        return view('home', [ "products" => $products, "categories" => $categories,
            "shopping_cart_orders" => $orders,
            "popular_products_week" => $popular_products_week,
            "popular_products_month" => $popular_products_month,
            "popular_products_all" => $popular_products_all,
        "product_week_count" => $product_week_count,
        "product_month_count" => $product_month_count,

        ]);

    }

    public function show_category(){


        $user_obj = Auth::user();
        if($user_obj){
            $user_id = $user_obj->id;
        }
        else{
            $user_id = 0;
        }


        $products =  \DB::table('product')
            ->leftJoin('category', 'category.id', '=', 'product.category_id')
            ->leftJoin('price', 'price.product_id', '=', 'product.id')
            ->leftJoin('tax', 'tax.product_id', '=', 'product.id')
            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.id')
            ->select(
                'product.id',
                'product.name',
                'product.description',
                'product.category_id',
                'category.name as category_name',
                'price.price',
                'tax.tax',
                'image',
                'product.created_at',
                'product.updated_at'
            )->groupBy('product.id')->orderBy('product.id', 'asc')
            ->orderBy('price.id', 'asc')->orderBy('product_image.id', 'asc')->limit(5)->get();


        $array = json_decode(json_encode($products), true);
        $data = [];
        foreach($array as $pr){
            $data[$pr["id"]] = $pr;
        }
        $products = json_decode(json_encode($data));

        $categories = Category::orderBy('created_at', 'desc')->get();

        $orders = \DB::table('order')
            ->join('order_product', 'order.id', '=', 'order_product.order_id')
            ->select('order_product.*')
            ->where(["payment_status" => "not submitted", "user_id" => $user_id])
            ->get();



        return view('category', ["products" => $products, "categories" => $categories, "shopping_cart_orders" => $orders,]);



    }

    public function show_product($product_id){

        $user_obj = Auth::user();
        if($user_obj){
            $user_id = $user_obj->id;
        }
        else{
            $user_id = 0;
        }

        $product = Product::find($product_id);
        $prices = $product->prices()->orderBy('created_at', 'desc')->limit(1)->get();
        $taxes = $product->taxes()->orderBy('created_at', 'desc')->limit(1)->get();
        $images = $product->product_images()->orderBy('created_at', 'asc')->get();
        $comments = $product->comment()->orderBy('created_at', 'asc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();


        $orders = \DB::table('order')
            ->join('order_product', 'order.id', '=', 'order_product.order_id')
            ->select('order_product.*')
            ->where(["payment_status" => "not submitted", "user_id" => $user_id])
            ->get();



        if(empty($prices->toArray()))
            $price = (object) array('price' => '0');
        else
            $price = $prices[0];

        if(empty($taxes->toArray()))
            $tax = (object) array('tax' => '0');
        else
            $tax = $taxes[0];

        if(empty($images->toArray()))
            $image = (object) array('image' => '/images/products/im10.jpg');
        else
            $image = $images[0];

        return view('product', ["product" => $product,
            "categories" => $categories, "comments" => $comments, "shopping_cart_orders" => $orders,
        "images" => $images, "price" => $price, "tax" => $tax, "main_image" => $image->image]);

    }

    public function postCreatePost(Request $request){

        $this->validate($request,[
            'body' => 'required|max:1000',
            'product_id' => 'required'
        ]);

        $product_id = $request['product_id'];

        $comment = new Comment();
        $comment -> description = $request['body'];
        $comment -> product_id = $product_id;
        $message = 'Greska prilokom unosa.';
        if($request->user()->comment()->save($comment)){
            $message = 'Komentar unjet uspješno';

        }
        #return redirect()->route('product')->with(['message' => $message]);

        $product = Product::find($product_id);
        $prices = $product->prices()->orderBy('created_at', 'desc')->limit(1)->get();
        $taxes = $product->taxes()->orderBy('created_at', 'desc')->limit(1)->get();
        $images = $product->product_images()->orderBy('created_at', 'asc')->get();
        $comments = $product->comment()->where("product_id", $product_id)->orderBy('created_at', 'asc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();

        if(empty($prices->toArray()))
            $price = (object) array('price' => '0');
        else
            $price = $prices[0];

//        if(empty($taxes->toArray()))
//            $tax = (object) array('tax' => '0');
//        else
//            $tax = $taxes[0];

        if(empty($images->toArray()))
            $image = (object) array('image' => '/images/products/im10.jpg');
        else
            $image = $images[0]->image;

        return redirect()->route('product', $product_id)->with(["product" => $product, "categories" => $categories,
            "comments" => $comments,
            "images" => $images,
            "price" =>$price, "tax" => $taxes,
            "main_image" => $image,
            'message' => $message]);


    }

    public function getDeletePost($post_id){

        $comment = Comment::where('id', $post_id)->first();
        $product_id = $comment->product_id;

        if(Auth::user() != $comment->user){
            return redirect()->back();
        }
        $comment->delete();

        return redirect()->route('product', $product_id)->with(
            ["message" => "Uspješno obrisano."]);


    }

    public function postEditPost(Request $request){

        $this->validate($request, ['body' => 'required']);

        $comment = Comment::find($request["postId"]);
        $comment->description = $request["body"];
        $comment->update();
        return response()->json(['new_body' => $comment->description], 200);


    }

    public function add_to_cart(Request $request){

        $user_obj = $request->user();
        $user_id = $user_obj->id;

        $product_id = $request["cart_product_id"];
        $quantity = $request["cart_quantity"];

        $product = Product::find($product_id);
        $prices = $product->prices()->orderBy('created_at', 'desc')->first()->price;
        //$taxes = $product->taxes()->orderBy('created_at', 'desc')->first()->tax;
        $taxes = 0;
        $total_price = $prices * $quantity;

        $order = $user_obj->order()->where(["payment_status" => "not submitted"])->orderBy('created_at', 'desc')->first();

        if($order == null){

            $order = new Order();
            $order->user_id = $user_id;
            $order->payment_status = "not submitted";
            $order->price = $total_price;
            $order->save();
            $order_id = $order->id;

        }
        else{

            $order_id = $order->id;
        }

        $order_product = new OrderProduct();
        $order_product->order_id = $order_id;
        $order_product->product_id = $product_id;
        $order_product->price = $prices;
        $order_product->tax = $taxes;
        $order_product->quantity = $quantity;

        $order_product->save();

//        return redirect()->route('product', $product_id)->with(
//            ["message" => "Successfully added."]);

//        $cart = new OrderProduct();
//        $cart->order_id = $order_id;
//        $cart->product_id = $product_id;
//        $cart->quantity = $quantity;
//        $cart->save();

        echo json_encode(["message" => "Uspješno dodato."]);


    }

    public function listCurrentOrder(Request $request){

        //echo json_encode(["1" => 1]);

        $user_obj = $request->user();
        $user_id = $user_obj->id;

        #$order = $user_obj->order()->where('payment_status', 'not submitted')->get();


        $order =$request->user()->order()
            ->where('payment_status', 'not submitted')
            ->orderBy('created_at', 'desc')->get();

        //var_dump($order->toArray());

        if($order->toArray()){

            $order_id = $order[0]->id;

            $order = Order::find($order_id);
            $order_products = $order->order_product()->orderBy('created_at', 'asc')->get();

            $total_price = 0;
            foreach($order_products as $order_pr){
                $total_price += $order_pr->quantity * $order_pr->price + $order_pr->quantity * $order_pr->tax;
            }
        }
        else{
            $order_products = [];
            $total_price = 0;
            $order_id = 0;
        }


        return view('shopping_cart', ["order" => $order_products, "main_image" => "0",
            "cart_orders" => $order_products, "shopping_cart_orders" => $order_products,
            "total_price" => $total_price , "order_id" => $order_id,
        "user_info" => $user_obj]);

    }

    public function show_product_all(){

        $user_obj = Auth::user();
        if($user_obj){
            $user_id = $user_obj->id;
        }
        else{
            $user_id = 0;
        }


//        $products =  \DB::table('product')
//            ->leftJoin('category', 'category.id', '=', 'product.category_id')
//            ->leftJoin('price', 'price.product_id', '=', 'product.id')
//            ->leftJoin('tax', 'tax.product_id', '=', 'product.id')
//            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.id')
//            ->select(
//                'product.id',
//                'product.name',
//                'product.description',
//                'product.category_id',
//                'category.name as category_name',
//                'price.price',
//                'tax.tax',
//                'image',
//                'product.created_at',
//                'product.updated_at'
//            )->orderBy('product.id', 'asc')
//            ->orderBy('price.id', 'asc')->orderBy('product_image.id', 'asc')->limit(15)->get();

        $products = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at'
            )->orderBy('t1.id', 'asc')
            ->paginate(15);

//        var_dump($products);
//
//
//
//        $products =  \DB::table('product')
//            ->leftJoin('category', 'category.id', '=', 'product.category_id')
//            ->leftJoin('price', 'price.product_id', '=', 'product.id')
//            ->leftJoin('tax', 'tax.product_id', '=', 'product.id')
//            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.id')
//            ->select(
//                'product.id',
//                'product.name',
//                'product.description',
//                'product.category_id',
//                'category.name as category_name',
//                'price.price',
//                'tax.tax',
//                'image',
//                'product.created_at',
//                'product.updated_at'
//            )->orderBy('product.id', 'asc')
//            ->orderBy('price.id', 'asc')->orderBy('product_image.id', 'asc')->limit(15)->get();
//
//        $array = json_decode(json_encode($products), true);
//        $data = [];
//        foreach($array as $pr){
//
////            if(empty($pr["price"]))
////                $pr["price"] = 0;
//            $data[$pr["id"]] = $pr;
//        }
//        $products = json_decode(json_encode($data));
//        $products = $products->paginate();

        $categories = Category::orderBy('created_at', 'desc')->get();
        $orders = \DB::table('order')
            ->join('order_product', 'order.id', '=', 'order_product.order_id')
            ->select('order_product.*')
            ->where(["payment_status" => "not submitted", "user_id" => $user_id])
            ->get();


        return view('product_all', ["products" => $products, "categories" => $categories, "shopping_cart_orders" => $orders]);


    }

    public function getDeleteProductOrder($product_order_id){

        $order = OrderProduct::where('id', $product_order_id)->first();
        $status =$order->delete();
        if(!$status){
            return redirect()->back();
        }
        return redirect()->route('shopping_cart')->with(
            ["message" => "Uspješno obrisano."]);
    }

    public function buyOrder($order_id){

        $order = Order::find($order_id);
        $order->payment_status = "payment successful";
        $order->save();

        return redirect()->route('shopping_cart')->with(
            ["message" => "Uspješno kupljeno."]);



    }

    public function show_product_searched(){

        $user_obj = Auth::user();
        if($user_obj){
            $user_id = $user_obj->id;
        }
        else{
            $user_id = 0;
        }

        $search = $_GET["search"];

        $products = \DB::table('product AS t1')
            ->leftJoin(\DB::raw('(SELECT * FROM price productA WHERE id = (SELECT MAX(id) FROM price productB WHERE productA.product_id=productB.product_id)) AS t2'), function($join) {
                $join->on('t1.id', '=', 't2.product_id');
            })
            ->leftJoin(\DB::raw('(SELECT * FROM tax productAA WHERE id = (SELECT MAX(id) FROM tax productBB WHERE productAA.product_id=productBB.product_id)) AS t3'), function($join) {
                $join->on('t1.id', '=', 't3.product_id');})
            ->leftJoin(\DB::raw('(SELECT * FROM product_image productAAA WHERE id = (SELECT MIN(id) FROM product_image productBBB WHERE productAAA.product_id=productBBB.product_id)) AS t4'), function($join) {
                $join->on('t1.id', '=', 't4.product_id');})
            ->leftJoin('category', 'category.id', '=', 't1.category_id')
            ->select(
                't1.id',
                't1.name',
                't1.description',
                't1.category_id',
                'category.name as category_name',
                't2.price',
                't3.tax',
                't4.image',
                't1.created_at',
                't1.updated_at'
            )->orderBy('t1.id', 'asc')->where("t1.description", 'like', "%".$search."%")->orWhere('t1.name', 'like', "%".$search."%")->paginate(15);


        $categories = Category::orderBy('created_at', 'desc')->get();
        $orders = \DB::table('order')
            ->join('order_product', 'order.id', '=', 'order_product.order_id')
            ->select('order_product.*')
            ->where(["payment_status" => "not submitted", "user_id" => $user_id])
            ->get();


        return view('product_all', ["products" => $products, "categories" => $categories, "shopping_cart_orders" => $orders]);


    }

}
