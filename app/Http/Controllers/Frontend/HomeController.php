<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $flashSaleDate = FlashSale::first();

        $flashSaleItems = FlashSaleItem::where('show_at_home', 1)->where('status', 1)->pluck('product_id')->toArray();
        $brands = Brand::where('status', 1)->where('is_featured', 1)->get();

        $typeBaseProducts = $this->getTypeBaseProduct();
        $categoryProductSliderSectionOne = HomePageSetting::where('key', 'product_slider_section_one')->first();
        $categoryProductSliderSectionTwo = HomePageSetting::where('key', 'product_slider_section_two')->first();


        $sliders = Slider::where('status', 1)->orderBy('serial','asc')->get();
        return view('frontend.home.home',
         compact(
            'sliders',
            'flashSaleDate',
            'flashSaleItems',
            'brands',
            'typeBaseProducts',
            'categoryProductSliderSectionOne',
            'categoryProductSliderSectionTwo',

        ));
    }

    public function getTypeBaseProduct()
    {
        $typeBaseProducts = [];

        $typeBaseProducts['new_arrival'] = Product::with(['variants', 'category', 'productImageGalleries'])
        ->where(['product_type' => 'new_arrival', 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

        $typeBaseProducts['featured_product'] = Product::with(['variants', 'category', 'productImageGalleries'])
        ->where(['product_type' => 'featured_product', 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

        $typeBaseProducts['top_product'] = Product::with(['variants', 'category', 'productImageGalleries'])
        ->where(['product_type' => 'top_product', 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

        return $typeBaseProducts;
    }

    // function ShowProductModal(string $id) {
    //     $product = Product::findOrFail($id);

    //     $content = view('frontend.layouts.modal', compact('product'))->render();

    //     return Response::make($content, 200, ['Content-Type' => 'text/html']);
    //  }
}
