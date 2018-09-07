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

                <div class="row">

                    <hr>
                </div>
                <?
                $i = 0;
                ?>
                @foreach($products as $product)
                    @if(fmod($i,4)==0)
                        <div class="row">
                            @endif
                            {{--ispisivanje proizvoda--}}
                            <div class="col-xs-3"
                                 id="product-data-{{$product->id}}"
                                 style="padding:20px;   align-content: center;font-size: 8pt; border:1px solid transparent">

                                <div class="row">
                                    <div class="col-xs-12" style="text-align: center">
                                    </div>
                                    <div class="col-xs-12" style="padding: 5px; align: center">
                                        <a href="/product/{{$product->id}}">
                                            <img style="max-width:100%;max-height:100%;" class="img-rounded"
                                                 src="{{$product->image == ""?"/images/products/im10.jpg":$product->image }}"
                                                    >
                                        </a>
                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-xs-12" style="font-size: 14pt;">
                                        <a href="/pages/product/{{$product->id}}">
                                            {{$product->name}}
                                        </a>
                                    </div>

                                </div>


                                <div class="row">
                                    {{--Price je u id-u div elementa da se prava vrijednost ne bi
                                    gubila pri promjenama koriscene valute--}}
                                    <div class="col-xs-12 product_price"
                                         id="{{$product->price}}">
                                        <h5>{{"Price: " . $product->price}}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        {{--<h4>--}}
                                            {{--{{"By "}}<a--}}
                                                    {{--href="/pages/seller/{{$product->id}}">--}}
                                                {{--{{$product->user->toArray()['username']}}--}}
                                            {{--</a>--}}
                                        {{--</h4>--}}
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-7">
                                    </div>
                                </div>
                            </div>
                            @if(fmod($i+1,4)==0)
                        </div>
                    @endif
                        <?
                        $i++;
                        ?>
                @endforeach

            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    {{ $products->links() }}
                </div>
            </div>

            {{--/main row--}}
        </div>
        {{--/main container fluid--}}
    </div>
@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/index.js') }}" type="text/javascript"></script>
@endsection