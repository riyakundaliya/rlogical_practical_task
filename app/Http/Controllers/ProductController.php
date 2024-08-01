<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
          
            $data =  Product::with('categories')->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('categories', function($row) {
                        
                        return $row->categories->pluck('title')->implode(', ');
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="' . route('admin.product.edit', $row->id) . '" class="edit btn btn-primary btn-sm mr-3" data-id="' . $row->id . '">Edit</a>';
                           $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action','categories'])
                    ->make(true);
        }
        return view('admin.product.index');
      
    }
    public function add()
    {
        $categories = Category::all();
        // dd($categories);
        return view('admin.product.add',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'qty' => $request->qty,
            'status' => $request->status,
        ]);
    
        $product->categories()->attach($request->categories);

        return redirect()->route('admin.product.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        // dd($product);
        $categories = Category::all();
        return view('admin.product.add', compact('product','categories'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);
    
        $id = $request->id;
        $product = Product::findOrFail($id); $product = Product::findOrFail($id);
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'qty' => $request->qty,
            'status' => $request->status,
        ]); 
        $product->categories()->sync($request->categories);
         return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
