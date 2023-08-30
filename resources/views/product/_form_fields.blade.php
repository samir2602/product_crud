<div class="form-group mb-3">
    <label for="name">Enter Name</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="@isset($product->name){{$product->name}}@else{{old('name')}}@endisset">    
    @error('name')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="name">Enter price</label>
    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" value="@isset($product->price){{$product->price}}@else{{old('price')}}@endisset">    
    @error('price')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="upc">Enter UPC</label>
    <input type="text" class="form-control" name="upc" id="upc" placeholder="Enter UPC" value="@isset($product->upc){{$product->upc}}@else{{old('upc')}}@endisset">    
    @error('upc')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="name">Select image</label>
    <input type="file" class="form-control" name="image" id="image">    
    @error('image')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
@isset($product_image)
    <div class="form-group mb-3">
        <img src="{{url('uploads/'.$product_image)}}" width="100" height="100"/>
    </div>
@endisset
<button type="submit" class="btn btn-primary">Submit</button>