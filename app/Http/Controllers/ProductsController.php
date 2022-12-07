<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function products(Request $request){


        $products  = Product::when($request->category , function($query) use($request){
            $query->where('category', $request->category);

        })->when($request->brand , function($query) use($request){
            $query->whereIn('brand', $request->brand);

        })->when($request->searchText , function($query) use($request){

            $query->where( 'product', 'like','%'.$request->searchText .'%');
            $query->orWhere( 'brand', 'like','%'.$request->searchText .'%');
            $query->orWhere( 'category', 'like','%'.$request->searchText .'%');

     
        })
->paginate(8);

        $categories = Product::select('category')->groupBy('category')->get();
        $brands = Product::select('brand')->groupBy('brand')->get();

        $data = '';
                if ($request->ajax()) {

            foreach ($products as $key=>$product) {
                    $data .='<tr>
                    <td>'.$key +1+ ($request->page-1) *8 .'</td>
                    <td>'.$product->product.'</td>
                    <td>'.$product->category.'</td>
                    <td>'.$product->brand.'</td>
                    </tr>';
                }
                    return   $data ;
                }
                return view('productsPage' , compact('products','categories' , 'brands'));

            }


}
