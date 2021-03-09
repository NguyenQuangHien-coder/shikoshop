<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
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
