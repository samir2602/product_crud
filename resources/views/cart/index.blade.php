@extends('layouts.app')

@section('content')
<?php if( sizeof($cart_data) == 0 ){ ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">              
                <h1>Your cart is empty</h1>
            </div>
        </div>
    </div>
<?php } else{ ?>

<table class="table">
  <thead>
    <tr>
        <th>item</th>
        <th>name</th>
        <th>quantity</th>
        <th>price</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @php
        $subtotal = 0;
    @endphp
    @foreach ($cart_data as $data)
    @php $total = $data['price'] * $data['quantity'] @endphp
    <tr>
        <td><img src="{{url('uploads/'.$data['product_image']['file_path'])}}" width="100" height="100"></td>
        <td>{{$data['item_data']['name']}}</td>
        <td>{{$data['quantity']}}</td>
        <td>{{$data['price']}}</td>
        <td>{{$total}}</td>
        <td><a href="javascript:void(0);" data-url="{{route('cart.destroy',$data['id'])}}" class="btn btn-danger btm-sm remove-item">Delete</a></td>
    </tr>
    @php
        $subtotal += $total;
    @endphp
    @endforeach
  </tbody>
</table>
<div class="row">
<div class="col-lg-6 text-start"><a href="{{route('chekcout')}}" class="btn btn-primary">Checkout</a></div>
<div class="col-lg-6 text-end">Subtotal : {{$subtotal}}</div>

<?php } ?>
@endsection

@push('custom-script')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).on('click', '.remove-item', function(e){
    if (confirm('Are you sure you want to remove item')) {
        var _this = $(this);
        var url = _this.data("url");   
        $.ajax(
            {
                url: url,
                type: 'DELETE',        
                success: function (){             
                  _this.parents('tr:first').fadeOut();                       
                }
            });
        }
    });
</script>
@endpush