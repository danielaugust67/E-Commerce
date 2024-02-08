@extends('layouts.app_public')

@section('content')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" /> 
<div class="products-page">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="categories">
                    <h2>{{__('public_pages.categories')}}</h2>
                    @php 
                    function loop_tree($treeArr, $is_recursion = false, $selectedCategory)
                    { 
                        echo '<ul class="' . ($is_recursion === true ? 'children' : 'parent') . '">';

                        foreach ($treeArr as $tree) {
                            $children = isset($tree->children) && !empty($tree->children);
                            echo '<li class="' . (isset($selectedCategory) && $selectedCategory == $tree->url ? 'active' : '') . '">'; 
                            echo '<a href="' . lang_url('category/'.$tree->url) . '">' . $tree->name . '<span></span></a>';

                            if ($children === true) {
                                echo '<span><i class="fa fa-plus" aria-hidden="true"></i><i class="fa fa-minus" aria-hidden="true"></i></span>';
                                loop_tree($tree->children, true, $selectedCategory);
                            } else {
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    }
                    loop_tree($categories, false, $selectedCategory);
                    @endphp
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-xs-12 section-title">
                        <h2>{{__('public_pages.all_products')}}</h2>
                        <div class="dropdown dropdown-order">
                            <button class="btn btn-bordered dropdown-toggle" type="button" data-toggle="dropdown">
                                @php
                                if(isset($_GET['order_by']) == 'created_at' && isset($_GET['type']) == 'asc'){
                                    echo __('public_pages.order_date_asc');
                                }
                                elseif(isset($_GET['order_by']) == 'created_at' && isset($_GET['type']) == 'desc'){                    
                                    echo __('public_pages.order_date_desc');
                                } else {
                                    echo __('public_pages.title_order');
                                }
                                @endphp 
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="?order_by=created_at&type=asc">{{__('public_pages.order_date_asc')}}</a></li>
                                <li><a href="?order_by=created_at&type=desc">{{__('public_pages.order_date_desc')}}</a></li>
                            </ul>
                        </div>
                    </div>
                    @if(!$products->isEmpty())
                        @foreach ($products as $product)
                        <div class="col-xs-6 col-md-4 product-container">
                            <div class="product">
                                <div class="img-container">
                                    <a href="{{ lang_url($product->url) }}">
                                        <img src="{{asset('../storage/app/public/'.$product->image)}}" alt="{{$product->name}}">
                                    </a>
                                </div>
                                <a href="{{ lang_url($product->url) }}">
                                    <h1>{{$product->name}}</h1>
                                </a>
                                <span class="price">{{ number_format($product->price) }}</span>
                                @if($product->link_to != null)
                                    <a href="{{lang_url($product->url)}}" class="buy-now" title="{{$product->name}}">{{__('public_pages.buy')}}</a>
                                @else
                                    <a href="javascript:void(0);" data-product-id="{{$product->id}}" class="buy-now to-cart">{{__('public_pages.buy')}}</a>
                                @endif
                            </div>
                        </div> 
                        @endforeach
                    @else
                        <div class="col-xs-12">
                            <div class="alert alert-danger">{{__('public_pages.no_products')}}</div>
                        </div>
                    @endif
                </div>
                {{ $products->links() }}
            </div>
        </div> 
    </div>
</div>
<script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
@endsection
