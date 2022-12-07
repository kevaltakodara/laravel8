@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Product Edit
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{route('products.index')}}"> Back</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{url('/product/update/'.$product->id)}}" method="POST" enctype="multipart/form-data" id="productEdit">
                        {{csrf_field()}}
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Product Name</label>
                            <input type="text" class="form-control" name="product_name" value="{{$product->product_name}}"/>
                            @if ($errors->has('product_name'))
                                <span class="text-danger">{{ $errors->first('product_name') }}</span>
                            @endif
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="6">{{$product->description}}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            @if(isset($product->image) && $product->image != '')
                                <img src="{{url('/product/', $product->image)}}" class="mt-2" width="100" height="100" alt="">
                            @endif
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Price</label>
                            <input type="number" class="form-control" name="price" id="price" value="{{$product->price}}">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Min Qty.</label>
                            <input type="number" class="form-control" name="min_qty" id="min_qty" value="{{$product->min_qty}}">
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Max Qty.</label>
                            <input type="number" class="form-control" name="max_qty" id="max_qty" value="{{$product->max_qty}}">
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="Active" @if($product->status == 'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($product->status == 'Inactive') selected @endif>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script>
    $(function() {
        $("#productEdit").validate({
        rules: {
            product_name: {
               required: true
            },
            description: {
                required: true
            },
            // image: {
            //     required: true
            // },
            price: {
                required: true
            },
        },
        messages: {
            product_name: {
                required: "Product name is required"
            },
            description: {
                required: "Product description is required"
            },
            image: {
                required: "Product image is required"
            },
            price: {
                required: "Product price is required"
            },
        }
        });
    });
</script>
@endsection