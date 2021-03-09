@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Giỏ Hàng</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
			{{-- Khai báo content --}}
			<?php
				$content = Cart::content();				
			?>			
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình Ảnh</td>
							<td class="description">Mô Tả</td>
							<td class="price">Giá</td>
							<td class="quantity">Số Lượng</td>
							<td class="total">Tổng Tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>					
					@foreach($content as $v_content)																			
						<tr>
							<td class="cart_product">
								<img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" alt="" width="50px" height="50px"/>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>				
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->price).' '.'VNĐ'}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-cart-quantity')}}" method="POST">
										{{ csrf_field() }}										
										<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" size="5">																			
										<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
										<input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
									<form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
								<?php
								$subtotal = $v_content->price * $v_content->qty;
								echo number_format($subtotal).' '.'VNĐ';
								?>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>	
					@endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>Hóa Đơn Mua Hàng</h3>	
			</div>
			<div class="row">				
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tổng <span>{{Cart::total().' '.'VNĐ'}}</span></li>
							<li>Thuế <span>{{Cart::tax().' '.'VNĐ'}}</span></li>
							<li>Phí vận chuyển  <span>Free</span></li>
							<li>Thành tiền <span>{{Cart::total().' '.'VNĐ'}}</span></li>
						</ul>							
							{{-- Nút Thanh Toán cho khách vãng lai và user --}}
						<?php
							$customer_id = Session::get('customer_id');
							if($customer_id != NULL) {							
						?>
						<a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh Toán</a>
						<?php
							}else{
						?>
						<a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh Toán</a>
						<?php
							}
						?>							
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection