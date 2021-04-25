<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    //Xử lý nút thanh toán (điều hướng nếu chưa đăng nhập)
    public function login_checkout() {
        //Gọi table category và brand (lấy danh mục và thương hiệu SP)
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id', 'desc')->get();  
        return view('pages.checkout.login_checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
    //Thêm tài khoản user mới
    public function add_customer(Request $request) {
        $data = array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);
        $data['customer_phone']=$request->customer_phone;   
        
        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }
    //Giao diện checkout được return sau khi đăng nhập
    public function checkout() {
        //Gọi table category và brand (lấy danh mục và thương hiệu SP)
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id', 'desc')->get();  
        return view('pages.checkout.show_checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
    //Lưu thông tin giao hàng
    public function save_checkout_customer(Request $request) {
        $data = array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_phone']=$request->shipping_phone;  
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_address']=$request->shipping_address;  
        $data['shipping_notes']=$request->shipping_notes;
               
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);  
        //Sau khi nhập thông tin ship thì được chuyển tới trang thanh toán     
        return Redirect::to('/payment');
    }
    //Trang Thanh Toán
    public function payment() {
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id', 'desc')->get();  
        return view('pages.checkout.payment')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
    //Trang Order-PLace
    public function order_place(Request $request) {
        //Insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status']= 'Đang chờ xử lý';       
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //Insert Order
        $order_data = array();
        $order_data['customer_id']= Session::get('customer_id');
        $order_data['shipping_id']= Session::get('shipping_id');
        $order_data['payment_id']= $payment_id;
        $order_data['order_total']= Cart::total();
        $order_data['order_status']= 'Đang chờ xử lý';      
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //Insert Order_Details
        $content = Cart::content();
        foreach($content as $v_content)
        {
            $order_d_data['order_id']= $order_id;
            $order_d_data['product_id']= $v_content -> id;
            $order_d_data['product_name']= $v_content -> name;
            $order_d_data['product_price']= $v_content -> price;
            $order_d_data['product_sales_quantity']= $v_content -> qty;    
            $order_id = DB::table('tbl_order_details')->insert($order_d_data);
        }
        //Sau khi nhập thông tin ship thì được chuyển tới trang thanh toán     
        if($data['payment_method'] == 1)
        {
            echo 'Thanh toán thẻ ATM';
        }
        elseif($data['payment_method'] == 2)
        {
            echo 'Tiền mặt';
        }
        else
        {
            echo 'Thẻ ghi nợ';
        }
        // return Redirect::to('/payment');
    }
    //Nút đăng xuất
    public function logout_checkout() {
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    //Xử lý nút Đăng Nhập
    public function login_customer(Request $request) {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $resulf = DB::table('tbl_customers')
        ->where('customer_email',$email)
        ->where('customer_password',$password)        
        ->first();
      
        if($resulf)
        {
            Session::put('customer_id',$resulf->customer_id);  
            return Redirect::to('/checkout');
        }
        else
        {
            return Redirect::to('/login-checkout');
        }               
    }
}
