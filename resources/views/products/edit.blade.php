@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <!-- Update Product Form -->
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" id="name" placeholder="Name" required>
            </div>
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" id="price" value="{{ $product->price }}" placeholder="Price" step="0.01" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="image">Add New Images (Max 5)</label>
                <input type="file" class="form-control" name="images[]" id="imageInput" multiple>
                <div id="imagePreview" class="image-preview" style="display: flex; flex-wrap: wrap; margin-top: 10px;">
                    <!-- Preview images will be displayed here -->
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description" rows="4">{{ $product->description }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mr-2">Cancel</a>
    </form>

    <!-- Button to View Images in Table -->
    <button id="viewImagesButton" class="btn btn-info" style="margin-top: 20px;" onclick="toggleImageTable()">View Images</button>

    <!-- Image Table to View Images -->
    <div id="imageTableContainer" style="display: none; margin-top: 20px;">
        <h3>Product Images</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->images as $image)
                    <tr>
                        <td>
                            <img src="{{ asset($image->image_path) }}" alt="Product Image" style="width: 100px; height: 100px; object-fit: cover;">
                        </td>
                        <td>
                            <!-- Delete Image Action -->
                            <form method="POST" action="{{ route('product.images.destroy', $image->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">&times;</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<style>
    .delete-btn {
        background-color: #ff4d4d;
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 18px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .delete-btn:hover {
        background-color: #ff1a1a;
    }

    .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>

<script>
    function toggleImageTable() {
        const imageTableContainer = document.getElementById("imageTableContainer");
        imageTableContainer.style.display = imageTableContainer.style.display === "none" ? "block" : "none";
    }

    document.getElementById("imageInput").addEventListener("change", function() {
        const imagePreview = document.getElementById("imagePreview");
        const maxFiles = 5;
        const existingImagesCount = document.querySelectorAll("#imageTableContainer tbody tr").length;
        const selectedFilesCount = this.files.length;
        const totalImagesCount = existingImagesCount + selectedFilesCount;

        if (totalImagesCount > maxFiles) {
            alert("You can only upload a total of 5 images.");
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
