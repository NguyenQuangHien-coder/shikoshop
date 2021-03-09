<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    //Thêm Vào Giỏ Hàng
    public function save_cart(Request $request) {
        //Lấy productid của sản phẩm trong trang show_details
        $productid = $request->productid_hidden;
        //Lấy số lượng của sản phẩm trong trang show_details
        $quantity = $request->qty;
        //lấy sản phẩm và so sánh trong table product
        $product_info = DB::table('tbl_product') -> where('product_id',$productid)->first();
        
        //Sử dụng hàm trong gói bumbummen99
        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);  
        // Cart::destroy();
        //Gọi từng thành phần của sản phẩm
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);    
        return Redirect::to('/show-cart');  
    }
    public function show_cart() {
        //Gọi table category và brand (lấy danh mục và thương hiệu SP)
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')->orderby('brand_id', 'desc')->get();  
        return view('pages.cart.show_cart')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
    //Xóa Sản Phẩm Trong Giỏ Hàng
    public function delete_to_cart($rowId) {
        //Xóa bằng cú pháp của bumbummen99 (chuyển số lượng về 0 = xóa)
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    //Cập nhật số lượng
    public function update_cart_quantity(Request $request) {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
