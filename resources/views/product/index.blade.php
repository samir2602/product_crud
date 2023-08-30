@extends('layouts.app')

@section('content')
<table id="productTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Price</th>
            <th>UPC</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@push('custom-script')
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(function () {
    
    var table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'upc', name: 'upc'},
            {data: 'image', name: 'image'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
        ]
    });
    
  });

  $(document).on('click', '.delete-item', function(e){
    if (confirm('Are you sure you want to delete record')) {
        var url = $(this).data("url");   
        $.ajax(
        {
            url: url,
            type: 'DELETE',        
            success: function (){
                $('#productTable').DataTable().ajax.reload();                
                var _this = $('#toast');                
                _this.show();
                _this.addClass('alert-danger');                    
                _this.text('Product Deleted Successfully');
                _this.fadeOut(5000);                
                
                
            }
        });
    }
  });

  $(document).on('change', '.status', function(e){        
    var url = $(this).data("url");   
    var status = $(this).is(':checked') ? 1 : 0;       
    $.ajax(
    {
        url: url,
        type: 'POST',        
        data: {'status' : status},        
        success: function (){                        
            var _this = $('#toast');                
            _this.show();
            _this.addClass('alert-success');                    
            _this.text('Status update successfully');
            _this.fadeOut(5000);                            
        }
    });    
  });
</script>
@endpush