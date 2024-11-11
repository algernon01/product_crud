<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $products = Product::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'LIKE', "%{$query}%");
        })->paginate(10);
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif,webp|max:2048',
            'images' => 'array|max:5',
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
    
   
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePath = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $imagePath);
    
                
                $product->images()->create([
                    'image_path' => 'images/' . $imagePath,
                ]);
            }
        }
    
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

        public function update(Request $request, Product $product)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif,webp|max:2048', 
                'images' => 'array|max:5',
            ]);
        
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();
        
        
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $imagePath = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('images'), $imagePath);
        
        
                    $product->images()->create([
                        'image_path' => 'images/' . $imagePath,
                    ]);
                }
            }
        
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

        public function destroyImage($id)
        {
            $image = ProductImage::findOrFail($id);


            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }

      
            $image->delete();

            return back()->with('success', 'Image deleted successfully.');
        }
}