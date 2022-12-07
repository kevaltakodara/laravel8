<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function fetchProduct(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $length = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $totalRecords = Product::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Product::select('count(*) as allcount')->where('product_name', 'like', '%' .$searchValue . '%')->count();

        $products = Product::orderBy($columnName,$columnSortOrder)
                        ->where('products.product_name', 'like', '%' .$searchValue . '%')
                        ->select('products.*')
                        ->skip($start)
                        ->take($length)
                        ->get();

        $data_arr = array();

        foreach($products as $key => $value){
            if($value->status == 'Active'){
                $status = '<span class="btn btn-success">'.$value->status.'</span>';
            }else{
                $status = '<span class="btn btn-danger">'.$value->status.'</span>';
            }

            $action = "<a href='".url('/product/edit/'. $value->id)."'>Edit</a><br /><a href='".url('/product/destroy/'. $value->id)."'>Delete</a>";
            
            $data_arr[] = array(
                "product_name" => $value->product_name ?? '',
                "price" => $value->price ?? 0,
                "min_qty" => $value->min_qty ?? '-',
                "max_qty" => $value->max_qty ?? '-',
                'image' => '<img width="100" height="100" src="'.url("/product/". $value->image).'">',
                'status' => $status,
                'action' => $action
            );

        }

        $response = array(
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "data" => $data_arr
         );

         return response()->json($response);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required'
        ], [
            'product_name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'image.required' => 'Product image is required',
            'price.required' => 'Product price is required',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'product/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $productImage);
            $input['image'] = $productImage;
        }

        Product::create($input);
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ], [
            'product_name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'price.required' => 'Product price is required',
        ]);

        $input = $request->except('_token');

        if ($image = $request->file('image')) {
            $destinationPath = 'product/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $productImage);
            $input['image'] = $productImage;
        }else{
            unset($input['image']);
        }

        Product::where('id', $id)->update($input);
        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }
}
