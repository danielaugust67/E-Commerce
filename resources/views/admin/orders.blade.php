@extends('layouts.app_admin')

@section('content')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" /> 
<div class="orders-page">
    <div class="card card-cascade narrower">
        <div class="table-responsive-xs"> 
            <table class="table">
                <thead class="blue-grey lighten-4">
                    <tr>
                        <th>#</th>
                        <th>{{__('admin_pages.time_created')}}</th>
                        <th>{{__('admin_pages.order_type')}}</th>
                        <th>{{__('admin_pages.phone')}}</th>
                        <th>{{__('admin_pages.status')}}</th>
                        <th class="text-right"><i class="fa fa-list" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->time_created }}</td>
                        <td>{{ __('admin_pages.ord_'.$order->type) }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>
                            @foreach (unserialize($order->products) as $product)
                            @php
                                $producta = $controller->getProductInfo($product['id']);
                            @endphp
                            @endforeach
                            @if($order->status != 3)
                            <select class="selectpicker change-ord-status change-stock-status" data-ord-id="{{$order->orderId}}" data-pro-id="{{$product['id']}}" data-pro-quantity="{{$product['quantity']}}" data-pro-stok="{{$producta->quantity}}" data-style="btn-secondary">
                                <option {{ $order->status == 0 ? 'selected="selected"' : '' }} value="0">{{__('admin_pages.ord_status_new')}}</option>
                                <option {{ $order->status == 1 ? 'selected="selected"' : '' }} value="1">{{__('admin_pages.ord_status_processed')}}</option>
                                <option {{ $order->status == 2 ? 'selected="selected"' : '' }} value="2">{{__('admin_pages.ord_status_rej')}}</option>
                                <option {{ $order->status == 3 ? 'selected="selected"' : '' }} value="3">{{__('admin_pages.ord_status_done')}}</option>
                            </select>
                            @elseif ($order->status == 3)
                            <select class="selectpicker change-ord-status change-stock-status" data-ord-id="{{$order->orderId}}" data-pro-id="{{$product['id']}}" data-pro-quantity="{{$product['quantity']}}" data-pro-stok="{{$producta->quantity}}" data-style="btn-secondary" disabled="true">
                                <option {{ $order->status == 0 ? 'selected="selected"' : '' }} value="0">{{__('admin_pages.ord_status_new')}}</option>
                                <option {{ $order->status == 1 ? 'selected="selected"' : '' }} value="1">{{__('admin_pages.ord_status_processed')}}</option>
                                <option {{ $order->status == 2 ? 'selected="selected"' : '' }} value="2">{{__('admin_pages.ord_status_rej')}}</option>
                                <option {{ $order->status == 3 ? 'selected="selected"' : '' }} value="3">{{__('admin_pages.ord_status_done')}}</option>
                            </select>
                            @endif
                            
                        </td>
                        <td class="text-right">
                            <a href="javascript:void(0);" class="btn btn-sm btn-secondary show-more" data-show-tr="{{ $order->order_id }}">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                <i class="fa fa-chevron-up" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="tr-more" data-tr="{{ $order->order_id }}">
                        <td colspan="6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.first_name') }}</b> <span>{{ $order->first_name }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.last_name') }}</b> <span>{{ $order->last_name }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.email') }}</b> <span>{{ $order->email }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.phone') }}</b> <span>{{ $order->phone }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.address') }}</b> <span>{{ $order->address }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.city') }}</b> <span>{{ $order->city }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.post_code') }}</b> <span>{{ $order->post_code }}</span></br>
                                        </li>
                                        <li>
                                            <b class="col-sm-3">{{ __('admin_pages.notes') }}</b> <span>{{ $order->notes }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    @php
                                    foreach(unserialize($order->products) as $product) {
                                        $producta = $controller->getProductInfo($product['id']);
                                        @endphp
                                        <div class="product">
                                            <a href="{{ lang_url($producta->url) }}" target="_blank">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <img src="{{asset('../storage/app/public/'.$producta->image)}}" alt="">
                                                        
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <ul>
                                                            <li>
                                                                <b class="col-sm-3">{{ __('admin_pages.products') }}</b> <span>{{$producta->name}}</span></br>
                                                            </li>
                                                            <li>
                                                                <b class="col-sm-3">{{ __('admin_pages.quantity') }}</b> <span>{{$product['quantity']}}</span>
                                                            </li>
                                                            <li>
                                                                <b class="col-sm-3">{{ __('admin_pages.product_price') }}</b> <span>{{number_format($producta->price)}}</span>
                                                            </li>
                                                            <li>
                                                                <b class="col-sm-3">{{ __('admin_pages.stock') }}</b> <span>{{$producta->quantity}}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                    }
                                    @endphp
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 
    </div>
    {{ $orders->links() }}
</div>
<script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script>
    $('.change-ord-status').change(function () {
        var order_id = $(this).data('ord-id');
        var order_value = $(this).val();
        $.ajax({
            type: "POST",
            url: urls.changeStatus,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {order_id: order_id, order_value: order_value}
        }).done(function (data) {
            showAlert('success', "{{ __('admin_pages.status_changed') }}");
        });
    });

    $('.change-stock-status').change(function () {
        var product_id = $(this).data('pro-id');
        var product_quantity = $(this).data('pro-quantity');
        var product_stok = $(this).data('pro-stok');
        var status_value = $(this).val();
        $.ajax({
            type: "POST",
            url: urls.changeStock,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {product_id: product_id, product_quantity: product_quantity, product_stok: product_stok, status_value: status_value}
        }).done(function (data) {
            location.reload();
        });
    });

    $('.show-more').click(function () {
        var tr_id = $(this).data('show-tr');
        $('table').find('[data-tr="' + tr_id + '"]').toggle(function () {
            if ($('[data-tr="' + tr_id + '"]').is(':visible')) {
                $('.orders-page .fa-chevron-up').show();
                $('.orders-page .fa-chevron-down').hide();
            } else {
                $('.orders-page .fa-chevron-up').hide();
                $('.orders-page .fa-chevron-down').show();
            }
        });

    });
</script>
@endsection