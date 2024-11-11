@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<div class="">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand">List of Products</a>
        <div class="row">
            <form class="form-inline" method="GET" action="{{ route('products.index') }}">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </form>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </nav>

    @if ($message = session('success'))
    <div class="p-2 alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row mt-4 px-4">
        @foreach ($products as $product)
        <div class="col-12 col-md-3">
            <div class="card shadow" style="margin-top: 20px;">
                @if ($product->images->isNotEmpty())
                <div id="carousel-{{ $product->id }}" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($product->images as $index => $image)
                        <li data-target="#carousel-{{ $product->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>

                    <div class="carousel-inner">
                        @foreach ($product->images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 100%; height: 310px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>

                    <a class="carousel-control-prev" href="#carousel-{{ $product->id }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-{{ $product->id }}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @else
                <img src="https://placehold.co/600x400?text=Product" class="card-img-top" alt="Product Placeholder" style="width: 100%; height: 310px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">₱ {{ $product->price }}</p>

                    <!-- Star Rating Widget -->
                    <div class="star-widget mb-3">
                        <input type="radio" name="rate-{{ $product->id }}" id="rate-5-{{ $product->id }}">
                        <label for="rate-5-{{ $product->id }}" class="fas fa-star"></label>
                        <input type="radio" name="rate-{{ $product->id }}" id="rate-4-{{ $product->id }}">
                        <label for="rate-4-{{ $product->id }}" class="fas fa-star"></label>
                        <input type="radio" name="rate-{{ $product->id }}" id="rate-3-{{ $product->id }}">
                        <label for="rate-3-{{ $product->id }}" class="fas fa-star"></label>
                        <input type="radio" name="rate-{{ $product->id }}" id="rate-2-{{ $product->id }}">
                        <label for="rate-2-{{ $product->id }}" class="fas fa-star"></label>
                        <input type="radio" name="rate-{{ $product->id }}" id="rate-1-{{ $product->id }}">
                        <label for="rate-1-{{ $product->id }}" class="fas fa-star"></label>
                    </div>
                    <br>
                    <div class="d-flex flex-column flex-md-row justify-content-start">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mb-2 mb-md-0 mr-md-2">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>

<style>
    .btn-danger {
        margin-right: 10px;
    }

    .star-widget input {
        display: none;
    }

    .star-widget label {
        font-size: 20px;
        color: #444;
        cursor: pointer;
        transition: color 0.2s ease;
        position: relative;
        bottom: 10px;
        margin-left: 5px;
        float: right;
        right: 55%;
    }

    .star-widget input:not(:checked) ~ label:hover,
    .star-widget input:not(:checked) ~ label:hover ~ label {
        color: #fd4;
    }

    .star-widget input:checked ~ label {
        color: #fd4;
    }

    @media (max-width: 768px) {
        .btn-danger {
            margin-right: 0;
        }
        .btn-primary{
            margin-right: 0;
            width: 27%;
        }
        .star-widget label {
            font-size: 18px;
            right: 50%;
        }

        .star-widget label {
            position: relative;
            bottom: 5px;
            right: 50%;
            transform: translateX(50%);
        }
    }

    @media (max-width: 480px) {
        .btn-danger {
            margin-right: 0;
        }
        .btn-primary{
            margin-right: 0;
            width: 27%;
        }
        .star-widget label {
            font-size: 16px;
        }

        .star-widget label {
            right: 50%;
            transform: translateX(50%);
            bottom: 2px;
        }
    }
</style>

@endsection
