<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Faq;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;


class FrontendProductController extends Controller
{
    public function productsIndex(Request $request)
    {
        // Set default price range
        $defaultRange = Config::get('constants.default_price_range');
        $from = $defaultRange['from'];
        $to = $defaultRange['to'];

        // Check if range is provided in the request
        if ($request->has('range')) {
            $price = explode(';', $request->range);
            $from = $price[0];
            $to = $price[1];
        }

        // Query products
        $query = Product::with(['variants', 'category', 'productImageGalleries'])
            ->where('status', 1);

        // Apply price range filter
        $query->where('price', '>=', $from)->where('price', '<=', $to);

        // If category is provided in the request, filter by category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // If subcategory is provided in the request, filter by subcategory
        if ($request->has('subcategory')) {
            $subcategory = SubCategory::where('slug', $request->subcategory)->firstOrFail();
            $query->where('sub_category_id', $subcategory->id);
        }

        // If childcategory is provided in the request, filter by childcategory
        if ($request->has('childcategory')) {
            $childcategory = ChildCategory::where('slug', $request->childcategory)->firstOrFail();
            $query->where('child_category_id', $childcategory->id);
        }

        // If brand is provided in the request, filter by brand
        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->firstOrFail();
            $query->where('brand_id', $brand->id);
        }

        // If search query is provided, search by product name or category name
        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('long_description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('long_description', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Paginate the results
        $products = $query->paginate(12);

        // Get categories and brands for sidebar filter
        $categories = Category::where(['status' => 1])->get();
        $brands = Brand::where(['status' => 1])->get();

        // banner ad

        // $productpage_banner_section = Adverisement::where('key', 'productpage_banner_section')->first();
        // $productpage_banner_section = json_decode($productpage_banner_section?->value);

        // 'productpage_banner_section'
        // Pass data to the view
        return view('frontend.pages.product', compact('products', 'categories', 'brands'));
    }



    /** Show product detail page */
    public function showProduct(string $slug)
    {
        $faqs = Faq::all();
        $product = Product::with(['category','productImageGalleries','variants','brand'])->where('slug', $slug)->where('status', 1)->first();
        return view('frontend.pages.product-detail', compact('product' ,'faqs'));
    }

    public function chageListView(Request $request)
    {
       Session::put('product_list_style', $request->style);
    }
}
