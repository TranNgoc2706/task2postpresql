<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFromRequest;
use Illuminate\Http\Request;    
use App\Http\Services\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $ProductService;
    public function __construct(ProductService $ProductService )
    {
        $this->ProductService = $ProductService;
    }
    public function index()
    {
         $products =  $this->ProductService->get();
        return view('list',[
            'title'=>'danh sach san pham',
            'products'=>$products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $products =  $this->ProductService->get();
        return view('add', [
            'title' => 'them san pham moi ',
            'products'=> $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFromRequest $request )
    {
        $this->ProductService->insert($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product )
    {
        return view('edit',[
            'title'=>'chinh sua sản phẩm: '.$product->name,
            'product'=>$product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->ProductService->update($request, $product);
        return redirect()->route('edit', ['id' => $product->id])->with('success', 'Cập nhật thành công');
    }

    public function destroy(Request $request)
    {
        $result = $this->ProductService->delete($request);
        if($result){
            return response()->json([
                'error'=>false,
                'message' => 'xoa thanh cong'
            ]);
        }
        return response()->json([
            'error'=>true]);
    }
}
