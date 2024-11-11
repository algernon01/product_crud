@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add Product</h1>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
            </div>
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" id="price" placeholder="Price" step="0.01" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="imageInput">Images (Max 5)</label>
                <input type="file" class="form-control" name="images[]" id="imageInput" multiple>
                <div id="imagePreview" class="image-preview" style="display: flex; flex-wrap: wrap; margin-top: 10px;">
                    <!-- Preview images will be displayed here -->
                </div>
            </div>
        
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mr-2">Cancel</a>
    </form>
</div>

<style>
    .image-preview img.preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>

<script>
    document.getElementById("imageInput").addEventListener("change", function() {
        const imagePreview = document.getElementById("imagePreview");
        const maxFiles = 5; 

        if (this.files.length > maxFiles) {
            alert("You can only upload up to 5 images.");
            this.value = ""; 
            imagePreview.innerHTML = ''; 
            return;
        }

        imagePreview.innerHTML = ''; 

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("preview-image");
                imagePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
