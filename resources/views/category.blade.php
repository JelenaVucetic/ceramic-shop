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
            </div>

            <div class="col-xs-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <?
                                $i = 0;
                                ?>
                                @foreach($products as $product)
                                    @if(fmod($i,4)==0)
                                        <div class="row">
                                            @endif
                                            {{--ispisivanje proizvoda--}}
                                            <div class="col-sm-3" id="product-data-{{$product->id}}"
                                                 style="align-content: center;font-size: 8pt; border:1px solid transparent">

                                                <div class="row">

                                                    <div class="col-sm-12" style="padding: 10px; align: center">
                                                        <a href="/product/{{$product->id}}">
                                                            <img style="max-width:100%;max-height:100%;"
                                                                 class="img-rounded"
                                                                 src="{{$product->image == ""?"/images/products/im10.jpg":$product->image }}"
                                                                    >
                                                        </a>
                                                    </div>

                                                </div>


                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <a href="/product/{{$product->id}}">
                                                            <h3>{{$product->name}}</h3>
                                                        </a>
                                                    </div>

                                                </div>


                                                <div class="row">
                                                    {{--Price je u id-u div elementa da se prava vrijednost ne bi
                                                    gubila pri promjenama koriscene valute--}}
                                                    <div class="col-sm-12 product_price"
                                                         id="{{$product->price}}">
                                                        <h4>{{"Price: " . $product->price}}</h4>
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
                        </div>
                    </div>
                </div>
                <div>

                </div>
            </div>
            {{--/col-sm-9--}}
        </div>

        {{--/main row--}}
    </div>
    {{--/main container fluid--}}
    </div>


@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/index.js') }}" type="text/javascript"></script>
@endsection