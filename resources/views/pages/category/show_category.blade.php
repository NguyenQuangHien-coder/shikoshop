@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
  
    @foreach($category_name as $key => $show_category_by_id)
    <h2 class="title text-center">{{$show_category_by_id -> category_name}}</h2>
    @endforeach
    <form action="{{URL::to('/save-cart')}}" method="POST">
        {{csrf_field()}}
    {{-- Biến all_product được tạo trong HomeController.php --}}
    @foreach($category_by_id as $key => $all_product)
     <a href="{{URL::to('/chi-tiet-san-pham/'.$all_product->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$all_product->product_image)}}" alt="" width="250px" height="250px"/>
                        <h2>{{number_format($all_product->product_price).' '.'VNĐ'}}</h2>
                        <p>{{$all_product->product_name}}</p>
                        <input name="productid_hidden" type="hidden" min="1" max="99" value="{{$all_product->product_id}}" />
                        <input name="qty" type="number" min="1" max="99" value="1" type="hidden" style="visibility: hidden !important; display:block"/>
                        <button type="submit" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>
                            Thêm Vào Giỏ
                        </button>
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
</form>												
</div><!--features_items-->
@endsection
                    
