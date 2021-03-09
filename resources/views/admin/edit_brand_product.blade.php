@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật thương hiệu sản phẩm
            </header>
            <div class="panel-body">
                <?php
                    $message = Session::get('message');
                    if($message){		
                        echo '<span class ="text-alert">',$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                @foreach($edit_brand_product as $key => $edit_value)                                 
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Điền tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu"</label>
                            <textarea style="resize: none" rows="5" name="brand_product_desc" class="form-control" id="exampleInputPassword1" placeholder="Điền mô tả">{{$edit_value->brand_desc}}
                            </textarea>
                        </div>
                        {{-- <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>                              
                            </select>
                        </div>                                                                      --}}
                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
                 @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
