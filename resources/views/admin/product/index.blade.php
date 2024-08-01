@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="{{ route('admin.index')}}">Categories</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                      <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('admin.product.index') }}">Products <span class="sr-only">(current)</span></a>
                          </li> 
                      </ul>
                    </div>
                    
                  </nav>
            </div>
        </div>    
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            
                
    <h3>Products </h3>
    <a href="{{ route('admin.product.add')}}" class="add btn btn-primary btn-sm float-right">Add</a>

    <table class="table table-bordered data-table" id="data_table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Categories</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

            </div>
        </div>    
    </div>

</div>
@endsection

@push('scripts')
<script>

$(document).ready(function(){
console.log('ready')
});

  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.product.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'}, 
            {data: 'categories', name: 'categories'}, 
            {data: 'price', name: 'price'},
            {data: 'qty', name: 'qty'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });


    /**
     Delete
    **/
  $('body').on('click', '.delete', function() {
        var id = $(this).data('id');
        
      

        if(confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '{{ route('admin.product.delete', ':id') }}'.replace(':id', id),
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(result) {
                   
                    $('#data_table').DataTable().ajax.reload();
                    toastr.success('Item deleted successfully.');
                },
                error: function(xhr) {
                    toastr.error('An error occurred while deleting the item.');
                }
            });
        }

    });

    /**
     * Edit 
     * */
     $('body').on('click', '.edit', function() {
        var id = $(this).data('id');
        
        console.log('delete')

          $.ajax({
                url: '{{ route('admin.category.edit', ':id') }}'.replace(':id', id),
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(result) {
                   
                    $('#data_table').DataTable().ajax.reload();
                    toastr.success('Item deleted successfully.');
                },
                error: function(xhr) {
                    toastr.error('An error occurred while deleting the item.');
                }
            });
    });


</script>


    
@endpush
