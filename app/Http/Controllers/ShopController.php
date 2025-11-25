<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;
use App\Models\CategoryBanner;

class ShopController extends Controller
{
   // ✅ Shop Page → সব product show করবে
    public function index()
{
    $mainMenus = MainMenu::with('subMenus.childMenus')->get();

    $products = Product::where('published_site', 'Y')
        ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
        ->latest()
        ->paginate(12);

    // সব category banners থেকে random pick
    $bannerRecord = CategoryBanner::inRandomOrder()->first();

    if ($bannerRecord) {
        // DB path full URL handle
        if (str_starts_with($bannerRecord->banner_image, 'http')) {
            $bannerUrl = $bannerRecord->banner_image;
        } else {
            $bannerUrl = asset('storage/' . $bannerRecord->banner_image);
        }
        $bannerTitle = $bannerRecord->title ?? 'Shop';
    } else {
        // DB তে banner না থাকলে fallback default
        $bannerUrl = asset('assets/images/product_banner.jpg');
        $bannerTitle = 'Shop';
    }

    $category = (object)[
        'name' => 'Shop',
        'banner' => $bannerUrl,
        'title' => $bannerTitle
    ];

    return view('product-categories.index', compact('mainMenus', 'products', 'category'));
}


    // ✅ Main Category (slug-based)
    public function listBySlug($slug)
    {
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();
        $category = MainMenu::where('name', $slug)->firstOrFail();

        $subIds = $category->subMenus->pluck('id')->toArray();
        $childIds = \App\Models\ChildMenu::whereIn('sub_menu_id', $subIds)->pluck('id')->toArray();

        $products = Product::where('published_site','Y')
            ->where(function($q) use($category, $subIds, $childIds){
                $q->where('main_menu_id', $category->id)
                  ->orWhereIn('sub_menu_id', $subIds)
                  ->orWhereIn('child_menu_id', $childIds);
            })
            ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
            ->latest()
            ->paginate(12);

        $banner = CategoryBanner::where('main_menu_id', $category->id)->first();

        return view('product-categories.index', compact('mainMenus','products','category','banner'));
    }

    // ✅ Sub / Child Category (id-based)
    public function listById($id)
    {
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();
        $products = [];
        $category = null;
        $banner = null;
        $mainMenu = null;
        $subMenu = null;
        $childMenu = null;

        $routeName = request()->route()->getName();

        if ($routeName == 'subcategory.list') {
            $category = \App\Models\SubMenu::findOrFail($id);
            $childIds = $category->childMenus->pluck('id')->toArray();

            $products = Product::where('published_site','Y')
                ->where(function($q) use($id, $childIds){
                    $q->where('sub_menu_id', $id)
                      ->orWhereIn('child_menu_id', $childIds);
                })
                ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
                ->latest()
                ->paginate(12);

            $banner = CategoryBanner::where('main_menu_id', $category->main_menu_id)->first();
            $mainMenu = MainMenu::find($category->main_menu_id);
            $subMenu = $category;
        } 
        elseif ($routeName == 'childcategory.list') {
            $category = \App\Models\ChildMenu::findOrFail($id);

            $products = Product::where('child_menu_id', $id)
                ->where('site_view_status','Y')
                ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
                ->latest()
                ->paginate(12);

            $banner = CategoryBanner::where('main_menu_id', $category->main_menu_id)->first();
            $mainMenu = MainMenu::find($category->main_menu_id);
            $subMenu = \App\Models\SubMenu::find($category->sub_menu_id);
            $childMenu = $category;
        }

        return view('product-categories.index', compact(
            'mainMenus','products','category','banner','mainMenu','subMenu','childMenu'
        ));
    }
}
