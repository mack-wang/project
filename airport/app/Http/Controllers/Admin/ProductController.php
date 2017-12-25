<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductFormRequest;
use App\Models\FetchCigarette;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = FetchCigarette::paginate(6);
        return view('admin.product',[
            "products"=>$products,
        ]);
    }

    public function search(Request $request)
    {
        if(strlen($request->title) > 0){
            $products = FetchCigarette::where('name','like',"%".$request->title."%")->paginate(6);
            return view('admin.product',[
                "products"=>$products,
                "title"=>$request->title,
            ]);
        }else{
            return back()->with("error","您未输入任何字符");
        }
    }

    public function getProduct($id)
    {
        return FetchCigarette::find($id)->toJson();
    }

    public function getContent(Request $request)
    {
        return FetchCigarette::where('brand',$request->brand)
            ->first()
            ->toJson();
    }

    public function form(ProductFormRequest $request)
    {
        if(!$request->id){
            $request->request->add([
                'cigarette_id'=>FetchCigarette::max('cigarette_id')+1,
            ]);
        }

        if(!$request->brand_id){
            $request->request->add([
                'brand_id'=>FetchCigarette::max('brand_id')+1,
            ]);
        }else{
            $request->brand = FetchCigarette::where('brand_id',$request->brand_id)->first()->brand;
        }


        FetchCigarette::updateOrCreate(
            ["id"=>$request->id],
            $request->except('editorValue')
        );

        return back()->with('success',$request->id ? "修改成功" : "上传成功");
    }
}
