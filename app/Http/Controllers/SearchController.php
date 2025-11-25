<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainMenu;

class SearchController extends Controller
{
   public function search(Request $request)
{
    $q = $request->q ?? '';
    if (!$q) return response()->json([]);

  $products = Product::where('name_en', 'like', "%{$q}%")
    ->orWhere('name_bn', 'like', "%{$q}%")
    ->select('id','slug','name_en as name')
    ->get()
    ->map(function($p) {
        return [
            'id' => $p->slug,   // slug use for product redirect
            'name' => $p->name,
            'type' => 'product'
        ];
    });

    $categories = MainMenu::where('name', 'like', "%{$q}%")
    ->select('id','name')
    ->get()
    ->map(function($c) {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'type' => 'category'
        ];
    });

    return response()->json($products->concat($categories));
}
}