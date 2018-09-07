@extends('layouts.master')

@section('content')

    <div class="container">
        @include('includes.message-block')
        <div class="row">
            <div class="col-xs-6" style="float:left">
                <div class="row">
                    <div class="col-xs-12">
                        <span>
                            <?
                            $counter = 0;
                            ?>
                            @foreach($images as $image)

                                @if($counter == 0)
                                        <img style="width:56pt; height:45pt;border:solid transparent 2px;float:left"
                                             src="{{$image->image}}"
                                             class="prod-thumb img-thumbnail" id="img-thumb-main">
                                    @else
                                        <img style="width:56pt; height:45pt;border:solid transparent 2px;float:left"
                                             src="{{$image->image}}"
                                             class="prod-thumb img-thumbnail"
                                             id="img-thumb<?=$counter?>">
                                    @endif

                                <? $counter++?>
                            @endforeach

                        </span>
                    </div>
                    <div style="clear:both" class="row">
                        <div style="z-index: 3;" class="col-xs-12">
                            <img src="{{$main_image}}" height='300pt' width='100%' class="prod-full
                            img-rounded"
                                 id="prod-full">

                            <div class="prod-pic-text"></div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-xs-6">
                <h2> {{$product->name}}</h2>
                {{--<h4>by <a style='text-decoration:none;' href='/pages/seller/{{$product->user->toArray()['id']}}'>--}}
                        {{--{{$product->user->toArray()--}}
                    {{--['username']}} </a></h4>--}}
                <h4></h4>
                <h4>Cijena: {{$price->price}}</h4>
                <h4>Porez: {{$tax->tax}}</h4>

                <hr>

                        <div class="row">
                            <div class="col-xs-2"><h4>Quantity:</h4></div>
                            <div class="col-xs-2"
                                 style="line-height:30px; vertical-align: middle;height:40px; width:50px;text-align: center;border: solid 2px transparent;border-radius: 5px;"
                                 id="quantity_decrease">-
                            </div>
                            <input readonly class="col-xs-2 form-control" value='0'
                                   style="height:40px;line-height:40px; width:80px;text-align: center;vertical-align: middle;border: solid 1px;"
                                   id="quantity">

                            <div class="col-xs-2"
                                 style="line-height:30px;  height:40px; width:50px;vertical-align: middle;text-align: center;border: solid 2px transparent;border-radius: 5px;"
                                 id="quantity_increase">+
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="row">
                            <div class="col-xs-10"><h2>Total: <span id="total-product-price"
                                                                    value="{{$price->price}}"></span></h2></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                <button product-id='{{$product->id}}' id='add_to_cart' class="btn btn-default">Add to
                                    Cart
                                </button>
                            </div>
                        </div>
                    </div>
            </div>

        <div class="row">
            <div class="col-xs-12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class=""><h3>Opis Proizvoda:</h3></div>
        </div>

        <div class="product-description row" style="clear:both; padding-bottom: 30px;">
            <div class="">
                {{$product->description}}
                <br>
                @if($product->product_images)
                    <div>
                        @foreach($product->product_images->toArray() as $product_imageRS)
                            <img style="float:left; padding: 5px;" src="{{$product_imageRS['image']}}">

                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="row">

            <section class="row new-post">
                <div class="col-md-6 col-md-offset-3">
                    <header> <h3> Dodaj komentar</h3></header>

                    <form action="{{ route('comment.create') }}" method="post">
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="form-group">
                            <textarea  class="form-control" name="body" id="body"  rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Moj komentar</button>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>
                </div>
            </section>

            <section class="row posts">
                <div class="col-md-6 col-md-offset-3">
                    <header>
                        <h3>
                            Komentari
                        </h3>
                    </header>
                    @foreach($comments as $comment)
                        <article class="post" data-postid="{{ $comment->id }}">
                            <p>
                                {{$comment->description}}
                            </p>
                            <div class="info">
                                Posted by {{ $comment->user->name }} on {{$comment->updated_at}}
                            </div>
                            <div class="interaction">
                                @if(Auth::user() == $comment->user)
                                    <a class="edit" href="#">Edit</a>
                                    <a href="{{ route('comment.delete', ['comment_id' => $comment->id]) }}">Delete</a>
                                @endif
                            </div>
                        </article>

                    @endforeach
                </div>
            </section>
            <!-- Modal -->
            <div id="edit-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Post</h4>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <div class="form-group">
                                    <label for="post-body">Edit the Post</label>
                                    <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" id="modal-save">Save modal</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>

    <script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('comment.edit') }}';
        var url2 = '{{ route('product.buy') }}';
    </script>

@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/seller_pages.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/ajax_requests.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/product_page.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/pics.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/random_effects.js') }}" type="text/javascript"></script>
@endsection