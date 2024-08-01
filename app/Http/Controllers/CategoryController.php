<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function add()
    {
        return view('admin.Category');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'description' =>  'maxlength: 1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images');
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = null;
        }

        $category = new Category();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->image = $imageName;
        $category->status = $request->input('status', 'active'); 
        $category->save();

        return redirect()->route('admin.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
            $category = Category::findOrFail($id);
            return view('admin.category', compact('category'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048'; 
        }
    
        $id = $request->id;
        $category = Category::findOrFail($id);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->status = $request->status;
    
        if ($request->hasFile('image')) {


            if ($category->image) {
                $oldImagePath = public_path('/storage/images/' . $category->image); // Full path to the old image
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image
                }
            }
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images');
            $image->move($destinationPath, $imageName);
           
            $category->image = $imageName;

        }
    
        $category->save();
    
        return redirect()->route('admin.index')->with('success', 'Category updated successfully.');
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::delete($category->image);
        }
    
        // Delete the category
        $category->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
