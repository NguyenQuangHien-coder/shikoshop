<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function add_product() {
        $cate_product = DB::table('tbl_category_product') -> orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product') -> orderby('brand_id', 'desc')->get();          
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product); 
    }
    public function all_product() {
        $all_product = DB::table('tbl_product')
        // Nhận dữ liệu tương đương từ table khác
        -> join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        -> join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id') 
        -> orderby('tbl_product.product_id','desc') -> get();
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.all_product',$manager_product);
    }

    //Thêm
    public function save_product(Request $request) {
        $data=array();
        //Gửi dữ liệu từ brand_product_name đến cột  brand_name trong phpMyadmin
        //Trái là tên cột, phải là tên name
        $data['product_name'] = $request -> product_name;
        $data['product_price'] = $request -> product_price;       
        $data['product_desc'] = $request -> product_desc;
        $data['product_content'] = $request -> product_content;
        $data['product_status'] = $request -> product_status;
        $data['brand_id'] = $request -> product_brand;
        $data['category_id'] = $request -> product_category;   

        $get_image = $request -> file('product_image');      
        if($get_image) {     
            // Tạo tên mới cho hình ảnh trong thư mục uploads/product 
            //Ảnh mới sẽ có dạng: Tên ảnh cũ + số random từ 0 đến 99. tên đuôi mở rộng của hình ảnh(png, jpg,..)
            $get_name_image = $get_image -> getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image -> getClientOriginalExtension();

            $get_image -> move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('all-product');     
    }   
    //Hiển thị
    public function active_product($product_id) {
        DB::table('tbl_product')
        ->where('product_id', $product_id)
        ->update(['product_status'=>0]);
        Session::put('message','Sản phẩm đã được ẩn');
        return Redirect::to('all-product');
    }
    public function unactive_product($product_id) {
        DB::table('tbl_product')
        ->where('product_id',$product_id)
        ->update(['product_status'=>1]);
        Session::put('message','Sản phẩm đã được hiển thị');
        return Redirect::to('all-product');
    }
    //Sửa
    //Hiện dữ liệu trong trang edit
    public function edit_product($product_id) {
        $cate_product = DB::table('tbl_category_product') -> orderby('category_id', 'desc')->get();  
        $brand_product = DB::table('tbl_brand_product') -> orderby('brand_id', 'desc')->get();          
        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')
        ->with('edit_product',$edit_product) 
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product',$manager_product);          
    }
    //Lưu dữ liệu vào database
    public function update_product(Request $request, $product_id) {
        $data = array();
        $data['product_name'] = $request -> product_name;
        $data['product_price'] = $request -> product_price;       
        $data['product_desc'] = $request -> product_desc;
        $data['product_content'] = $request -> product_content;
        $data['product_status'] = $request -> product_status;
        $data['brand_id'] = $request -> product_brand;
        $data['category_id'] = $request -> product_category;   
        $get_image = $request-> file('product_image');
        if($get_image) {     
            // Tạo tên mới cho hình ảnh trong thư mục uploads/product 
            //Ảnh mới sẽ có dạng: Tên ảnh cũ + số random từ 0 đến 99. tên đuôi mở rộng của hình ảnh(png, jpg,..)
            $get_name_image = $get_image -> getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image -> getClientOriginalExtension();

            $get_image -> move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');            
    }    
    //Xóa
    public function delete_product($product_id) {
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }   

    //END FUNCTION ADMIN PAGE
    //Show Details
    public function details_product($product_id) {
    $cate_product = DB::table('tbl_category_product')
        ->where('category_status','1')
        ->orderby('category_id', 'desc')
        ->get();  
    $brand_product = DB::table('tbl_brand_product')
        ->where('brand_status','1')
        ->orderby('brand_id', 'desc')
        ->get();  
    $details_product = DB::table('tbl_product')
        // Nhận dữ liệu tương đương từ table khác
        -> join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        -> join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id') 
        -> where('tbl_product.product_id',$product_id) -> get();

    //Lấy danh mục để hiện sản phẩm liên quan   
    foreach($details_product as $key => $value){
        $category_id = $value->category_id;
    }
        
    //Sản Phẩm Liên Quan
    $related_product = DB::table('tbl_product')
        // Nhận dữ liệu tương đương từ table khác
        -> join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        -> join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id') 
        -> where('tbl_category_product.category_id',$category_id) ->whereNotIn('tbl_product.product_id',[$product_id]) -> get();

    return view('pages.product.show_details')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('product_details',$details_product)
        ->with('relate',$related_product);
    }
}
