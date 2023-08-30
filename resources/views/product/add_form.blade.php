@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
@csrf
@include('product._form_fields')
</form>
@endsection