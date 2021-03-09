<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layout');
// });
// Route::get('/trangchu', function () {
//     return view('layout');
// });

//Frontend*
Route::get('/','App\Http\Controllers\HomeController@index');
Route::get('/trangchu','App\Http\Controllers\HomeController@index');

//Danh mục sản phẩm - Trang Chủ
Route::get('/danh-muc-san-pham/{category_id}','App\Http\Controllers\CategoryProduct@show_category_home');
//Thương hiệu sản phẩm - Trang chủ
Route::get('/thuong-hieu-san-pham/{brand_id}','App\Http\Controllers\BrandProduct@show_brand_home');
//Chi tiết sản phẩm - Trang chủ
Route::get('/chi-tiet-san-pham/{product_id}','App\Http\Controllers\ProductController@details_product');

//Backend*
Route::get('/admin','App\Http\Controllers\AdminController@index');
Route::get('/dashboard','App\Http\Controllers\AdminController@show_dashboard');
// Route::get('/dashboard', function () {
//     return view('admin/dashboard');
// })->middleware('auth');
// Route::get('/dashboard', function () {
//     return view('admin/dashboard');
// })->middleware('checklogin::class');
// Phần đăng nhập admin
Route::post('/admin-dashboard','App\Http\Controllers\AdminController@dashboard');
// Phần đăng xuất admin
Route::get('/logout','App\Http\Controllers\AdminController@logout');

//Category-Product*
Route::get('/add-category-product','App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all-category-product','App\Http\Controllers\CategoryProduct@all_category_product');
Route::get('/edit-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@delete_category_product');
Route::post('/update-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@update_category_product');
Route::post('/save-category-product','App\Http\Controllers\CategoryProduct@save_category_product');
//Phần hiển thị
Route::get('/active-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@active_category_product');
Route::get('/unactive-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@unactive_category_product');

//Brand-Product*
Route::get('/add-brand-product','App\Http\Controllers\BrandProduct@add_brand_product');
Route::get('/all-brand-product','App\Http\Controllers\BrandProduct@all_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@delete_brand_product');
Route::post('/update-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@update_brand_product');
Route::post('/save-brand-product','App\Http\Controllers\BrandProduct@save_brand_product');
//Phần hiển thị
Route::get('/active-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@active_brand_product');
Route::get('/unactive-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@unactive_brand_product');

//Product*
Route::get('/add-product','App\Http\Controllers\ProductController@add_product');
Route::get('/all-product','App\Http\Controllers\ProductController@all_product');
Route::get('/edit-product/{product_id}','App\Http\Controllers\ProductController@edit_product');
Route::get('/delete-product/{product_id}','App\Http\Controllers\ProductController@delete_product');
Route::post('/update-product/{product_id}','App\Http\Controllers\ProductController@update_product');
Route::post('/save-product','App\Http\Controllers\ProductController@save_product');
//Phần hiển thị
Route::get('/active-product/{product_id}','App\Http\Controllers\ProductController@active_product');
Route::get('/unactive-product/{product_id}','App\Http\Controllers\ProductController@unactive_product');


//GIỎ HÀNG
//Thêm vào giỏ
Route::post('/save-cart','App\Http\Controllers\CartController@save_cart');
//Trang giỏ hàng
Route::get('/show-cart','App\Http\Controllers\CartController@show_cart');
//Xóa giỏ hàng
Route::get('/delete-to-cart/{rowId}','App\Http\Controllers\CartController@delete_to_cart');
//Cập nhật số lượng
Route::post('/update-cart-quantity','App\Http\Controllers\CartController@update_cart_quantity');

//THANH TOÁN và ĐĂNG KÍ-ĐĂNG NHẬP-ĐĂNG XUẤT
//Xử lý nút Checkout (Thanh Toán)
Route::get('/login-checkout','App\Http\Controllers\CheckoutController@login_checkout');
//Xử lý nút Đăng Xuất
Route::get('/logout-checkout','App\Http\Controllers\CheckoutController@logout_checkout');
//Nút xử lý Đăng Nhập
Route::post('/login-customer','App\Http\Controllers\CheckoutController@login_customer');
//Tạo tài khoản user mới
Route::post('/add-customer','App\Http\Controllers\CheckoutController@add_customer');
//Trang Checkout sau khi return (sau khi đăng nhập thành công)
Route::get('/checkout','App\Http\Controllers\CheckoutController@checkout');
//Lưu thông tin giao hàng
Route::post('/save-checkout-customer','App\Http\Controllers\CheckoutController@save_checkout_customer');
//Home*
// Route::get('/danh-muc-san-pham/{category_id}','App\Http\Controllers\HomeController@');
// Route::get('/thuong-hieu-san-pham/{brand_id}','App\Http\Controllers\HomeController@');





