<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Gọi CSDL
use DB;
//Thêm thư viện để làm phần đăng nhập
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    // //Bảo mật khii user nhập routing thủ công
    // public function AuthLogin() {
    //     $admin_id = Session::get('admin_id');
    //     if($admin_id){
    //         return Redirect::to('dashboard');
    //     }else{
    //         return Redirect::to('admin')->send();
    //     }
    // }
    public function index() {
        return view('admin_login');
    }
    public function show_dashboard() {
        // $this->AuthLogin();
        return view('admin.dashboard');
    }
    // Đăng nhập
    public function dashboard(Request $request) {
       $admin_email = $request->admin_email;
       $admin_password = md5($request->admin_password);

    //    truy vấn trong CSDL
       $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    //    echo '<pre>';
    //    print_r ($result);
    //    echo '</pre>';
        if($result) {
            // Nếu thông tin kiểm tra tồn tại trong CSDL, lấy thông tin đó 
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            // Trả về trang dashboard
            return Redirect::to('/dashboard');
        }
        else{
            // Nếu người dùng nhập sai thông tin tài khoản, trả về trang admin
            Session::put('message','Tài khoản hoặc mật khẩu không đúng');
            return Redirect::to('/admin');
        }
    }
    // Đăng xuất
    public function logout() {
        $this->AuthLogin();
        Session::put('admin_name','null');
        Session::put('admin_id','null');
        return Redirect::to('/admin');
     }
}
