<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index() {
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id', 'desc')->get();  

        // $all_product = DB::table('tbl_product')
        // // Nhận dữ liệu tương đương từ table khác
        // -> join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // -> join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id') 
        // -> orderby('tbl_product.product_id','desc') -> get();
        $all_product = DB::table('tbl_product')
        ->where('product_status','1')
        ->orderby('product_id', 'desc')
        ->limit(30)
        ->get();  
        return view('pages.home')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('all_product',$all_product);      
    }   
}
