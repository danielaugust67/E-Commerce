<?php

namespace App\Models\Publics;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{

    public function getProducts($request)
    {
        $realCategoryId = null;
        if (isset($request->category)) {
            $realCategoryId = DB::table('categories')->where('url', $request->category)->pluck('id');
        }
        $search = $request->input('find');
        $order = $this->orderValidate($request);
        $products = DB::table('products')
                ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'))
                ->orderBy($order['column'], $order['type'])
                ->where('quantity', '>', 0)
                ->where('hidden', '=', 0)
                ->where('locale', '=', app()->getLocale())
                ->when($search, function ($query) use ($search) {
                    return $query->where('optik_products.name', 'LIKE', "%$search%");
                })
                ->when($realCategoryId, function ($query) use ($realCategoryId) {
                    return $query->where('products.category_id', $realCategoryId);
                })
                ->join('optik_products', 'optik_products.for_id', '=', 'products.id')
                ->paginate(12);
        return $products;
    }

    private function orderValidate($request)
    {
        $supportedColumns = [
            'created_at'
        ];
        $order_by = $request->input('order_by');
        $order_type = $request->input('type');
        if (in_array($order_by, $supportedColumns) && (strtolower($order_type) == 'asc' || strtolower($order_type) == 'desc')) {
            $order = [
                'column' => $order_by,
                'type' => $order_type
            ];
        } else {
            $order = [
                'column' => 'order_position',
                'type' => 'asc'
            ];
        }
        return $order;
    }

    public function setNewStock($post)
    {
        $this->post = $post;
        if($this->post['status_value'] == 3) {
            DB::table('products')
                    ->where('id', $this->post['product_id'])
                    ->update([
                        'quantity' => ($this->post['product_stok'] - $this->post['product_quantity'])
            ]);
        }
    }

    public function getProduct($id)
    {
        $product = DB::table('products')
                ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'
                                . ', (SELECT name FROM optik_brand WHERE for_id = products.category_id AND locale= "' . app()->getLocale() . '") as category_name'
                                . ', (SELECT for_id FROM optik_brand WHERE for_id = products.category_id AND locale= "' . app()->getLocale() . '") as category_id'
                                . ', (SELECT url FROM categories WHERE id = products.category_id) as category_url'))
                ->where('products.id', '=', $id)
                ->where('optik_products.locale', '=', app()->getLocale())
                ->join('optik_products', 'optik_products.for_id', '=', 'products.id')
                ->first();
        return $product;
    }

    public function getProductsWithTag($tag)
    {
        $products = DB::table('products')
                ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'))
                ->where('tags', 'LIKE', '%'.$tag.'%')
                ->where('hidden', '=', 0)
                ->where('locale', '=', app()->getLocale())
                ->join('optik_products', 'optik_products.for_id', '=', 'products.id')
                ->limit(8)
                ->get();
        return $products;
    }

    public function getMostSelledProducts()
    {
        $products = DB::table('products')
                ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'))
                ->where('quantity', '>', 0)
                ->where('hidden', '=', 0)
                ->where('locale', '=', app()->getLocale())
                ->join('optik_products', 'optik_products.for_id', '=', 'products.id')
                ->limit(8)
                ->get();
        return $products;
    }

    public function getProductsWithIds($ids)
    {
        $products = DB::table('products')
                        ->select(DB::raw('products.*, optik_products.name, optik_products.description, optik_products.price'))
                        ->where('hidden', '=', 0)
                        ->whereIn('products.id', $ids)
                        ->where('locale', '=', app()->getLocale())
                        ->join('optik_products', 'optik_products.for_id', '=', 'products.id')
                        ->get()->toArray();
        return $products;
    }

    public function getCategories()
    {
        $categories = DB::table('categories')
                        ->select(DB::raw('categories.*, optik_brand.name'))
                        ->where('locale', '=', app()->getLocale())
                        ->orderBy('position', 'desc')
                        ->join('optik_brand', 'optik_brand.for_id', '=', 'categories.id')
                        ->get()->toArray();
        return $categories;
    }

    public function getCategoryName($url)
    {
        return DB::table('categories')
                        ->where('locale', '=', app()->getLocale())
                        ->join('optik_brand', 'optik_brand.for_id', '=', 'categories.id')
                        ->where('url', $url)
                        ->pluck('name')->toArray();
    }

}