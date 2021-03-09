<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    public function add_category_product() {
        return view('admin.add_category_product');
    }
    public function all_category_product() {
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }

    //Thêm
    public function save_category_product(Request $request) {
        $data=array();
        //Gửi dữ liệu từ category_product_name đến cột  category_name trong phpMyadmin
        $data['category_name'] = $request -> category_product_name;
        $data['category_desc'] = $request -> category_product_desc;
        $data['category_status'] = $request -> category_product_status;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-category-product');
    }   
    //Hiển thị
    public function active_category_product($category_product_id) {
        DB::table('tbl_category_product')
        ->where('category_id', $category_product_id)
        ->update(['category_status'=>0]);
        Session::put('message','Danh mục đã được ẩn');
        return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id) {
        DB::table('tbl_category_product')
        ->where('category_id',$category_product_id)
        ->update(['category_status'=>1]);
        Session::put('message','Danh mục đã được hiển thị');
        return Redirect::to('all-category-product');
    }
    //Sửa
    public function edit_category_product($category_product_id) {
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);          
    }
    public function update_category_product(Request $request, $category_product_id) {
        $data = array();
        $data['category_name'] = $request -> category_product_name;
        $data['category_desc'] = $request -> category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message', 'Cập nhật danh mục thành công');
        return Redirect::to('all-category-product');
    }    
    //Xóa
    public function delete_category_product($category_product_id) {
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message', 'Xóa danh mục thành công');
        return Redirect::to('all-category-product');
    }   

    //END FUNCTION ADMIN PAGE
    //Hiện Danh Mục SP
    public function show_category_home($category_id)
    {
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status','1')
            ->orderby('category_id', 'desc')
            ->get();  
        $brand_product = DB::table('tbl_brand_product')
            ->where('brand_status','1')
            ->orderby('brand_id', 'desc')
            ->get();  
        $category_by_id = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
            ->where('tbl_product.category_id',$category_id)
            ->get();
        $category_name = DB::table('tbl_category_product')
            ->where('tbl_category_product.category_id',$category_id)
            ->limit(1)
            ->get();
        return view('pages.category.show_category')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('category_by_id',$category_by_id)
            ->with('category_name',$category_name);
    }

     
}
