@extends('layouts.app')

@section('content')
<div class="row">
    @foreach ($product_list as $products)        
    <div class="col-lg-4 mb-3">
        <div>
            <img src="{{url('uploads/'.$products->product_image->file_path)}}" width="200" height="200">
        </div>
        <div class="mt-2">
            <a href="{{route('add_to_cart',$products->id)}}" class="btn btn-primary">Add to cart</a>
        </div>
        <h1>{{$products->name}}</h1>
        <p>Rs: {{$products->price}}</p>
    </div>
    @endforeach
</div>
@endsection
