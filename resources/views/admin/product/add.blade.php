@extends('layouts.app')


@section('content')
<div class="container">

<div class="row justify-content-center mt-3">
<div class="col-md-8">
    <a href="{{ route('admin.product.index')}}" class="add btn btn-primary btn-sm float-right">Back</a>
    <h3>Add Product </h3>
  
    <form id="productForm" action="{{ isset($product) ? route('admin.product.update', $product->id) : route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <!-- Hidden Input for Product ID -->
        <input type="hidden" name="id" class="id" id="id" value="{{ isset($product) ? $product->id : '' }}">
    
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title', isset($product) ? $product->title : '') }}" required>
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Description">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="categories">Categories</label>
            <select id="categories" name="categories[]" multiple="multiple" class="form-control" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ isset($product) && $product->categories->contains($cat->id) ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
            @error('categories')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="{{ old('price', isset($product) ? $product->price : '') }}" required>
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="qty">Quantity</label>
            <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Quantity" value="{{ old('qty', isset($product) ? $product->qty : '') }}" required>
            @error('qty')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" {{ old('status', isset($product) ? $product->status : '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', isset($product) ? $product->status : '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    
</div>
</div>

</div>
@endsection



@push('scripts')
<script>

$(document).ready(function(){
console.log('ready')

$('#categories').select2({
        placeholder: 'Select categories',
        allowClear: true 
    });

    $('#productForm').validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 255
                },
                description: {
                    maxlength: 1000
                },
                categories: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                qty: {
                    required: true,
                    digits: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    maxlength: "Title cannot be more than 255 characters"
                },
                description: {
                    maxlength: "Description cannot be more than 1000 characters"
                },
                categories: {
                    required: "Please select at least one category"
                },
                price: {
                    required: "Please enter a price",
                    number: "Please enter a valid price"
                },
                qty: {
                    required: "Please enter a quantity",
                    digits: "Please enter only whole numbers"
                },
                status: {
                    required: "Please select a status"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

});

</script>


    
@endpush