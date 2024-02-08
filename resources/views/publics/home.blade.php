@extends('layouts.app_public')

@section('content')
<div class="home-page">
    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators"> 
                @php
                $i=0;
                @endphp 
                @foreach($carousel as $slide)
                <li data-target="#myCarousel" data-slide-to="{{$i}}" class="{{ $i == 0 ? 'active' : ''}}"></li>
                @php
                $i++;
                @endphp 
                @endforeach
            </ol>
            <div class="carousel-inner">
                @php
                $i=0;
                @endphp 
                @foreach($carousel as $slide)
                <div class="item {{ $i == 0 ? 'active' : ''}}">
                    <a href="{{$slide->link}}">
                        <img src="{{ asset('../storage/app/public/'.$slide->image) }}" alt="">
                    </a>
                </div>
                @php
                $i++;
                @endphp 
                @endforeach
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="row">
            @foreach ($mostSelledProducts as $mostSelledProduct)
            <div class="col-xs-6 col-sm-4 col-md-3 product-container">
                <div class="product">
                    <div class="img-container">
                        <a href="{{ lang_url($mostSelledProduct->url) }}">
                            <img src="{{asset('../storage/app/public/'.$mostSelledProduct->image)}}" alt="{{$mostSelledProduct->name}}">
                        </a>
                    </div>
                    <a href="{{ lang_url($mostSelledProduct->url) }}">
                        <h1>{{$mostSelledProduct->name}}</h1>
                    </a>
                    <span class="price">{{ number_format($mostSelledProduct->price) }}</span>
                    @php
                    if($mostSelledProduct->link_to != null) {
                        @endphp
                        <a href="{{ lang_url($mostSelledProduct->url) }}" class="buy-now" title="{{$mostSelledProduct->name}}">{{__('public_pages.buy')}}</a>
                        @php
                    } else {
                        @endphp
                        <a href="javascript:void(0);" data-product-id="{{$mostSelledProduct->id}}" class="buy-now to-cart">{{__('public_pages.buy')}}</a>
                        @php
                    }
                    @endphp
                </div>
            </div>
            @endforeach
        </div> 
        <div class="col-md-4 col-md-offset-4 product">            
            <a type="button" class="buy-now" href="{{ lang_url('products') }}">{{__('public_pages.viewall')}}</a>
        </div>
    </div>
</div>
@endsection
