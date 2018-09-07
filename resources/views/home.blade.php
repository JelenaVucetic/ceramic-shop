@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row well well-sm">
            <div class="col-xs-2" style="float:left;height:100%;">
                <div class="list-group">
                    @foreach($categories as $category)
                        <a href="/category/{{$category->id}}" class="list-group-item">{{$category->name}}</a>
                    @endforeach
                </div>
                {{--<ul class="category_ul list-group">--}}
                    {{--@foreach($categories as $categoryRS)--}}
                        {{--<li style="border: solid 1px transparent; margin: 1px;" class="category_li list-group-item"--}}
                            {{--value={{$categoryRS['id']}} id="category_li_{{$categoryRS['id']}}">--}}
                            {{--&nbsp&nbsp{{$categoryRS['name']}}--}}
                            {{--<div style='width: 100%;' class="category_div" id="category_div_{{$categoryRS['id']}}">--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            </div>

            <div class="col-xs-8">
                <ul class="rslides" id="discout-products-slide" style='background-color:white;'>
                    @foreach($products as $discount_product)
                        <li>
                            <div class="row">
                                <div class="col-xs-7">
                                    <a href="/product/{{$discount_product->id}}">
                                        <img
                                                class='slide-prod-img'
                                                {{--src="http://lorempixel.com/350/250/technics/?{{$discount_product->id}}"--}}

                                                src="{{$discount_product->image == ""?"/images/products/im10.jpg":$discount_product->image }}">
                                        {{--<p class="caption">{{$discount_product->name}}</p>--}}
                                    </a>
                                </div>
                                <div class="col-xs-5">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>{{$discount_product->name}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h5>{{$discount_product->description}}</h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="new-product-price"
                                                 value="{{$discount_product->price}}">
                                                <h3>{{'Price: '.$discount_product->price}} </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>
                                                <a href="/product/{{$discount_product->id}}">{{$discount_product->name}}</a>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <br>
                                        <div class="col-xs-12">
                                            <a href="/product_all/">
                                                Prikaži sve
                                            </a>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr>
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Najpopularniji proizvodi</h2>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs">
                            <li><a href="#week" data-toggle="tab">This week</a></li>
                            <li><a href="#month" data-toggle="tab">Past month</a></li>
                            <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All time</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade" id="week">
                                <div class="container-fluid">
                                   <?
                                    $i = 1;
                                    ?>
                                       @foreach($popular_products_week as $product_week)
                                           @if(fmod($i,4)==0)
                                               <div class="row">
                                                   @endif
                                                   {{--ispisivanje proizvoda--}}
                                                   <div class="col-xs-3"
                                                        id="product-data-{{$product_week->id}}"
                                                        style="padding:20px;   align-content: center;font-size: 8pt; border:1px solid transparent">

                                                       <div class="row">
                                                           <div class="col-xs-12" style="text-align: center">
                                                               <h4>{{$product_week->orders}} narudžbi</h4>
                                                           </div>
                                                           <div class="col-xs-12" style="padding: 5px; align: center">
                                                               <a href="/product/{{$product_week->id}}">
                                                                   <img style="max-width:100%;max-height:100%;"
                                                                        class="img-rounded"
                                                                        src="{{$product_week->image == ""?"/images/products/im10.jpg":$product_week->image }}"
                                                                        {{--src="http://lorempixel.com/350/250/technics/?{{$product_week->id}}"--}}>
                                                               </a>
                                                           </div>
                                                       </div>


                                                       <div class="row">
                                                           <div class="col-xs-12" style="font-size: 14pt;">
                                                               <a href="/product/{{$product_week->id}}">
                                                                   {{$product_week->name}}
                                                               </a>
                                                           </div>
                                                       </div>


                                                       <div class="row">
                                                           {{--Price je u id-u div elementa da se prava vrijednost ne bi
                                                           gubila pri promjenama koriscene valute--}}
                                                           <div class="col-xs-12 product_price"
                                                                id="{{$product_week->price}}">
                                                               <h5>{{"Price: " . $product_week->price}}</h5>
                                                           </div>
                                                       </div>
                                                       <div class="row">
                                                           <div class="col-xs-12">
                                                           </div>

                                                       </div>
                                                       <div class="row">
                                                           <div class="col-xs-7">
                                                               <h5>
                                                               </h5>
                                                           </div>

                                                       </div>
                                                   </div>

                                               @if(fmod($i,4)==0)
                                </div>
                                @endif
                                               <?
                                               $i++;
                                               ?>
                                @endforeach
                                       </div>
                            </div>
                            <div class="tab-pane fade" id="month">
                                <div class="container-fluid">
                                    <?
                                    $i = 1;
                                    ?>
                                    @foreach($popular_products_month as $product_week)
                                        @if(fmod($i,4)==0)
                                            <div class="row">
                                                @endif
                                                {{--ispisivanje proizvoda--}}
                                                <div class="col-xs-3"
                                                     id="product-data-{{$product_week->id}}"
                                                     style="padding:20px;   align-content: center;font-size: 8pt; border:1px solid transparent">

                                                    <div class="row">
                                                        <div class="col-xs-12" style="text-align: center">
                                                            <h4>{{$product_week->orders}} narudžbi</h4>
                                                        </div>
                                                        <div class="col-xs-12" style="padding: 5px; align: center">
                                                            <a href="/product/{{$product_week->id}}">
                                                                <img style="max-width:100%;max-height:100%;"
                                                                     class="img-rounded"
                                                                     src="{{$product_week->image == ""?"/images/products/im10.jpg":$product_week->image }}">
                                                            </a>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-xs-12" style="font-size: 14pt;">
                                                            <a href="/product/{{$product_week->id}}">
                                                                {{$product_week->name}}
                                                            </a>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        {{--Price je u id-u div elementa da se prava vrijednost ne bi
                                                        gubila pri promjenama koriscene valute--}}
                                                        <div class="col-xs-12 product_price"
                                                             id="{{$product_week->price}}">
                                                            <h5>{{"Price: " . $product_week->price}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7">
                                                            <h5>
                                                            </h5>
                                                        </div>

                                                    </div>
                                                </div>

                                                @if(fmod($i,4)==0)
                                            </div>
                                        @endif
                                            <?
                                            $i++;
                                            ?>

                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade in active" id="all">
                                <div class="container-fluid">
                                    <?
                                    $i = 1;
                                    ?>
                                    @foreach($popular_products_all as $product_week)
                                        @if(fmod($i,4)==0)
                                            <div class="row">
                                                @endif
                                                {{--ispisivanje proizvoda--}}
                                                <div class="col-xs-3"
                                                     id="product-data-{{$product_week->id}}"
                                                     style="padding:20px;   align-content: center;font-size: 8pt; border:1px solid transparent">

                                                    <div class="row">
                                                        <div class="col-xs-12" style="text-align: center">
                                                            <h4>{{$product_week->orders}} narudžbi</h4>
                                                        </div>
                                                        <div class="col-xs-12" style="padding: 5px; align: center">
                                                            <a href="/product/{{$product_week->id}}">
                                                                <img style="max-width:100%;max-height:100%;"
                                                                     class="img-rounded"
                                                                     src="{{$product_week->image == ""?"/images/products/im10.jpg":$product_week->image }}">
                                                            </a>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-xs-12" style="font-size: 14pt;">
                                                            <a href="/product/{{$product_week->id}}">
                                                                {{$product_week->name}}
                                                            </a>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        {{--Price je u id-u div elementa da se prava vrijednost ne bi
                                                        gubila pri promjenama koriscene valute--}}
                                                        <div class="col-xs-12 product_price"
                                                             id="{{$product_week->price}}">
                                                            <h5>{{"Price: " . $product_week->price}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7">
                                                            <h5>
                                                            </h5>
                                                        </div>

                                                    </div>
                                                </div>

                                                @if(fmod($i,4)==0)
                                            </div>
                                        @endif
                                        <?
                                            $i++;
                                            ?>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{--<div class="row">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<ul class="nav nav-tabs">--}}
                            {{--<li><a href="#week" data-toggle="tab">This week</a></li>--}}
                            {{--<li><a href="#month" data-toggle="tab">Past month</a></li>--}}
                            {{--<li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All time</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <hr>

                {{--'products','top_product_info','top_seller_info','popular_products_week','popular_products_month','
            popular_products_all', 'discount_products', 'categories', 'sub_categories',
            'user', 'selected_user_info', 'shopping_cart_orders', 'rates_array'--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-6">--}}
                        {{--<div class="panel panel-success well well-sm">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">Top sellers</h3>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}

                    {{--<div class="col-xs-6">--}}
                        {{--<div class="panel panel-warning well well-sm">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">Top products</h3>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-xs-12">--}}
                    {{--<div class="panel panel-info">--}}
                        {{--<div class="panel-heading">--}}
                            {{--<h3 class="panel-title">Recently added products</h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--/main row--}}
        </div>
        {{--/main container fluid--}}
    </div>
@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/index.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/product_page.js') }}" type="text/javascript"></script>
@endsection