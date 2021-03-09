@extends('layout')
@section('content')
<section id="cart_items">
	<div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Thanh Toán</li>
            </ol>
        </div><!--/breadcrums-->
              
        <div class="register-req">
            <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">             
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Vui lòng điền thông tin giao hàng</p>
                        <div class="form-one">
                            <form action="{{URL::to('/save-checkout-customer')}}" method="POST">     
                                {{csrf_field()}}                          
                                <input type="text" name="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_name" placeholder="Họ Và Tên*">
                                <input type="text" name="shipping_address" placeholder="Địa Chỉ*">
                                <input type="text" name="shipping_phone" placeholder="SĐT">                               
                                <textarea name="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
                                <input type="submit" value="Hoàn Tất" name="send_order" class="btn btn-primary btn-sm">
                            </form>
                        </div>                        
                    </div>
                </div>
                {{-- <div class="col-sm-4">
                    <div class="order-message">
                        <p>Ghi Chú Gửi Hàng</p>
                        <textarea name="message" name="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>               
                    </div>	
                </div>					 --}}
            </div>
        </div>
        <div class="review-payment">
            <h2>Xem Lại Giỏ Hàng</h2>
        </div>

       
        <div class="payment-options">
                <span>
                    <label><input type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input type="checkbox"> Check Payment</label>
                </span>
                <span>
                    <label><input type="checkbox"> Paypal</label>
                </span>
        </div>
	</div>
</section> <!--/#cart_items-->
@endsection