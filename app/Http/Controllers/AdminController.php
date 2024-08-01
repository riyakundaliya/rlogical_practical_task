<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CartItem;
use DataTables;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
          
            $data = Category::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($row) {
                        $url = asset('/storage/images/' . $row->image); 
                        return '<img src="' . $url . '" border="0" width="80" class="img-rounded" align="center" alt="123"/>';
                     
                    })
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="' . route('admin.category.edit', $row->id) . '" class="edit btn btn-primary btn-sm mr-3" data-id="' . $row->id . '">Edit</a>';
                           $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('home');
      
    }

    public function user_cart()
    {
        $cartItems = CartItem::with(['user', 'product'])->get();
        return view('admin.user_cart',compact('cartItems'));
    }
}
