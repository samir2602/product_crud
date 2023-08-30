@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{route('order')}}">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Enter Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{old('name')}}">    
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="city">Enter city</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Enter city" value="{{old('city')}}">    
                @error('city')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="mobile_no">Mobile No</label>
                <input type="number" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter mobile no" value="{{old('mobile_no')}}">    
                @error('mobile_no')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="city">Enter Address</label>
                <textarea name="address" class="form-control">{{old('address')}}</textarea>   
                @error('city')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="city">Payment</label>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="payment" value="0" checked>
                <label class="form-check-label" for="payment">
                    Cash on delivery
                </label>
                </div>
            </div>
            <input type="hidden" name="customer_id" value="{{auth()->user()->id}}">
            <input type="hidden" name="customer_email" value="{{auth()->user()->email}}">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-lg-4 row">
        @php
            $subtotal = 0;
            @endphp
        @foreach ($cart_data as $data)
        @php $total = $data->price * $data->quantity @endphp
        <div class="col-lg-6">
            <img src="{{url('uploads/'.$data->product_image->file_path)}}" width="100" height="100">
            <p>Name : {{$data->item_data->name}}</p>        
            <p>Quantity : {{$data->quantity}}</p>        
            <p>Price : {{$data->price}}</p>
            <p>Total : {{$data->price * $data->quantity}}</p>
        </div>
        @php
            $subtotal += $total;
            @endphp
        @endforeach
        <h1>Subtotal : {{$subtotal}} Rs</h1>
    </div>
</div>
@endsection