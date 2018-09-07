@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        @include('includes.message-block')
        <div class="row">
            <div class="col-xs-12">
                Korisnički
                podaci: {{$user_info->name.' '.$user_info->last_name.", ".$user_info->address.' iz '.$user_info->city
            .'/'.$user_info->country}}
            </div>
        </div>

        @foreach($cart_orders as $order)
            <br>
            <div class="row">
                <div class="col-xs-12 order-row-{{$order->id}}">
                    {{"Broj narudžbe: ".$order->id}}
                </div>
            </div>
            <br>
            <div class="row order-row-{{$order->id}}">
                <div class="col-xs-1">
                    <img class='img-thumbnail' style='height:100px;width:150px;'
                         src="{{$order->image == ""?"/images/products/im10.jpg":$order->image }}">
                         {{--src="{{$order->product->product_images()->first()["image"]}}">--}}
                </div>
                <div class="col-xs-2">
                    <div class="row" style="">Proizvod:</div>
                    <hr>
                    <div class="row">{{$order->product->name}}</div>
                    {{--<div class="row">Type: <span>{{$order['type']}}</span></div>--}}
                </div>
                <div class="col-xs-1">
                    <div class="row" style="text-align:center;">Količina:</div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row">
                        <input value='{{$order->quantity}}' class='form-control'
                                            style="text-align: center;vertical-align: middle;border: solid 1px;"
                                            id="quantity">
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="row">
                        <div class="col-xs-12">Cijena:</div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">{{$order->price}}</div>
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="row">
                        <div class="col-xs-12">Porez:</div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">{{$order->tax}}</div>
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="row">
                        <div class="col-xs-12">
                            Ukupno:
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            {{$order->price*$order->quantity + $order->tax*$order->quantity}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row"><a href="{{route('delete_product_order', $order->id)}}" value={{$order->id}} id="remove-order-{{$order->id}}"
                                        class="btn btn-default btn-sm">Ukloni</a></div>
                </div>
            </div>
            <hr>
        @endforeach
        @if(count($shopping_cart_orders)!=0)
            <div class="row">
                <div class="col-xs-4 col-xs-offset-3">
                    <div class="row">
                        <div class="col-xs-12"><h3>Ukupna cijena: {{$total_price}}</h3></div>
                    </div>
                    <div class="row">
                        <div class="row"><a href="{{route('buy_product_order', $order_id)}}"
                                            class="btn btn-default btn-sm">Kupi</a></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section("js-end")
    {{--<script src="{{ URL::to('src/js/index.js') }}" type="text/javascript"></script>--}}
@endsection