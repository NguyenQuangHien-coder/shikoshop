@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Kết Quả Tìm Kiếm</h2>
    {{-- Biến all_product được tạo trong HomeController.php --}}
    @foreach($search_product as $key => $all_product)
     <a href="{{URL::to('/chi-tiet-san-pham/'.$all_product->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$all_product->product_image)}}" alt="" width="250px" height="250px"/>
                        <h2>{{number_format($all_product->product_price).' '.'VNĐ'}}</h2>
                        <p>{{$all_product->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ</a>
                    </div>
                    {{-- <div class="product-overlay">
                        <div class="overlay-content">
                            <h2>{{number_format($all_product->product_price).' '.'VNĐ'}}</h2>
                            <p>{{$all_product->product_name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ</a>
                        </div>
                    </div> --}}
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu Thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So Sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>	
    </a>
    @endforeach   											
</div><!--features_items-->

@endsection
                    
