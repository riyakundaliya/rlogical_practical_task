@extends('layouts.app')


@section('content')
<div class="container">

<div class="row justify-content-center mt-3">
<div class="col-md-8">
    <a href="{{ route('admin.index')}}" class="add btn btn-primary btn-sm float-right">Back</a>
    <h3>Add Category </h3>
  
    <form  id="categoryForm" action="{{ isset($category) ? route('admin.category.update') : route('admin.category.store') }}"  method="POST"  enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" class="id" id="id" value="{{ isset($category) ? $category->id : '' }}">
        <div class="form-group mb-3">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Enter Title"  value="{{ old('title', isset($category) ? $category->title : '') }}">
          @error('title')
          <span class="text-danger">{{ $message }}</span>
          @enderror
         </div>

         <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Description">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
            
          </div>

       <div class="form-group mb-3">
          <label for="image">Image</label>
          <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
          @if(isset($category) && $category->image)
       
          <img src="{{ asset('storage/images/' . $category->image) }}" alt="Category Image" width="100">
         @endif
          @error('image')
          <span class="text-danger">{{ $message }}</span>
          @enderror

        </div>
    
        <div class="form-group mb-3">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
              <option value="active" {{ old('status', isset($category) ? $category->status : '') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ old('status', isset($category) ? $category->status : '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
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

$("#categoryForm").validate({
    rules: {
      title: {
        required: true,
        maxlength: 255,
        // email:true
      },
      description: {
        maxlength: 1000 
      },
      image: {
      
        extension: "jpg|jpeg|png|gif",
        
      },
      
    },
    messages: {
      title: {
        required: "Please enter a title",
        maxlength: "Title cannot be more than 255 characters"
      },
      description: {
        required: "Please enter a description"
      },
      image: {
        required: "Please upload an image",
        extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
         
      },
   
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
    },
      
   
  });




});

</script>


    
@endpush