<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attachment;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Request()->request->add(['Pagetitle' => 'Product', 'btntext' => 'Add Product', 'btnclass' => 'btn btn-primary', 'btnurl' => route('product.create')]);
        if ($request->ajax()) {
            $data = Product::with('product_image')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="'.url('uploads/'.$row->product_image->file_path).'" width="100" height="100"/>';
                })
                ->addColumn('status', function ($row) {
                    $check = ($row->status) ? "checked" : '';
                    $btn = '<div class="form-check form-switch">
                            <input class="form-check-input status" type="checkbox" role="switch" id="flexSwitchCheckDefault" data-url="' . route('change_status', $row->id) . '" data-id="' . $row->id . '" ' . $check . ' value="' . $row->status . '">
                        </div>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="'.route('product.edit',$row->id). '" class="btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" data-url="'.route('product.destroy', $row->id).'" class="delete-item btn btn-danger btn-sm">Delete</a>';                    
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Request()->request->add(['Pagetitle' => 'Add Product', 'btntext' => 'Back', 'btnclass' => 'btn btn-danger', 'btnurl' => route('product.index')]);
        return view('product.add_form');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userid = auth()->user()->id;
        Request()->request->add(['created_by' => $userid]);        
        $post = $request->except('image');
        $image = $request->file('image');
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'upc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        $product = Product::create($post);
        if($product){
            $name = time().$image->getClientOriginalName();
            $file_path = 'products/'.$product->id;
            $image->move('uploads/'.$file_path, $name);  
            $data = [];
            $data['file_name'] = $name;
            $data['file_path'] = $file_path.'/'.$name;
            $data['meta_id'] = $product->id;
            $data['meta_key'] = 'products';
            $data['created_by'] = $userid;
            Attachment::create($data);
        }
        return redirect()->to('product')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Request()->request->add(['Pagetitle' => 'Edit Product', 'btntext' => 'Back', 'btnclass' => 'btn btn-danger', 'btnurl' => route('product.index')]);
        $data['product'] = $product;
        $product_image = Attachment::where(['meta_id' => $product->id, 'meta_key' => 'products'])->first();
        $data['product_image'] = $product_image->file_path;
        return view('product.edit_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $userid = auth()->user()->id;
        $post = $request->except('image');
        $image = $request->file('image');
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'upc' => 'required',
        ]);
        $product->update($post);
        if($product && $image){
            $old_image = Attachment::where(['meta_id' => $product->id, 'meta_key' => 'products'])->first();                        
            
            if (file_exists(public_path('uploads/'. $old_image->file_path))) {                
                unlink(public_path('uploads/' . $old_image->file_path));
                Attachment::where(['meta_id' => $product->id, 'meta_key' => 'products'])->delete();
            }

            $name = time() . $image->getClientOriginalName();
            $file_path = 'products/' . $product->id;
            $image->move('uploads/' . $file_path, $name);
            $data = [];
            $data['file_name'] = $name;
            $data['file_path'] = $file_path . '/' . $name;
            $data['meta_id'] = $product->id;
            $data['meta_key'] = 'products';
            $data['created_by'] = $userid;            
            Attachment::create($data);
        }
        return redirect()->to('product')->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $old_image = Attachment::where(['meta_id' => $product->id, 'meta_key' => 'products'])->first();

        if (file_exists(public_path('uploads/' . $old_image->file_path))) {
            unlink(public_path('uploads/' . $old_image->file_path));
            Attachment::where(['meta_id' => $product->id, 'meta_key' => 'products'])->delete();
        }
        $product->delete();
        return response()->json(['message' => 'Record deleted', 'status' => TRUE]);
    }

    public function change_status(Request $request, $id)
    {
        $post = $request->all();       
        Product::where(['id' => $id])->update(['status' => $post['status']]);
        return response()->json(['message' => 'Record deleted', 'status' => TRUE]);
    }
}
