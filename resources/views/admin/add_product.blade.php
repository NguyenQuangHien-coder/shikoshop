@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>
            <div class="panel-body">
                <?php
                    $message = Session::get('message');
                    if($message){		
                        echo '<span class ="text-alert">',$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Điền tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Điền tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Chọn ảnh">
                        </div>                       
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm"</label>
                            <textarea style="resize: none" rows="5" name="product_desc" class="form-control" id="exampleInputPassword1" placeholder="Điền mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm"</label>
                            <textarea style="resize: none" rows="5" name="product_content" class="form-control" id="exampleInputPassword1" placeholder="Điền mô tả"></textarea>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_category" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    <option value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                @endforeach                                                                                       
                            </select>
                        </div>        
                        <div class="form-group">
                        <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">                               
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{($brand->brand_id)}}">{{($brand->brand_name)}}</option>
                                @endforeach                 
                            </select>
                        </div>        
                        <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>                              
                            </select>
                        </div>                                                                     
                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
