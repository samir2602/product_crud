@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('product._form_fields')
</form>
@endsection