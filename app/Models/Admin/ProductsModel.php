<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;
use Config;

class ProductsModel extends Model
{

    private $defaultLang;
    private $id;

    public function __construct()
    {
        $this->defaultLang = Config::get('app.defaultLocale');
    }

    public function getProducts($request)
    {
        $search = $request->input('search');
        $products = DB::table('products')
                ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'))
                ->where('optik_products.locale', $this->defaultLang)
                ->when($search, function ($query) use ($search) {
                    return $query->where('optik_products.name', 'LIKE', "%$search%");
                })
                ->join('optik_products', 'products.id', '=', 'optik_products.for_id')
                ->paginate(12);
        return $products;
    }

    public function deleteProduct($id)
    {
        $this->id = $id;
        DB::transaction(function () {
            DB::table('products')->where('id', $this->id)->delete();
            DB::table('optik_products')->where('for_id', $this->id)->delete();
        });
    }
}