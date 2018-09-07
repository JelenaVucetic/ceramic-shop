@extends('layouts.master')

@section('title')
    Proizvodi
@stop

@section('content')
    <div class="container">
    @include('includes.message-block')
    <div class="container">

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Proizvodi</div>
            <div class="panel-body">
                <button onclick="resetId()" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#edit-modal">
                    Dodaj Novi Proizvod</button>
            </div>

            <!-- Table -->
            <table id="table" class="display" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <td>Naziv</td>
                        <td>Kategorija</td>
                        <td>Cijena</td>
                        <td>Porez</td>
                        <td>Opis</td>
                        <td>Akcije</td>
                    </tr>
                </thead>
                <tbody>
                @if(empty($products))
                    <tbody>
                        <tr>
                            <td>Nema proizvoda</td>
                        </tr>
                @else
                    @foreach($products as $product)
                        <tr id="prod{{$product->id}}">
                            <td>{{$product->name}}</td>
                            <td><span data-id="{{$product->category_id}}">{{$product->category_name}}</span></td>
                            <td><span data-price="{{$product->price}}">{{$product->price}}</span></td>
                            <td><span data-tax="{{$product->tax}}">{{$product->tax}}</span></td>
                            <td>{{$product->description}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default btn-sm" onclick="updateProduct({{$product->id}})">Izmjeni</button>
                                    <form id="deleteForm" style="display: inline-block;" method="get" action="/admin/product/delete/{{$product->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Izbriši</button>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="showHistory({{$product->id}})">Istorija</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="edit-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form enctype="multipart/form-data" action="{{ route('product.save') }}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Proizvod</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="product_id" name="product_id" value="-1">
                        <input type="hidden" id="old_price" name="old_price" value="-1">
                        <input type="hidden" id="old_tax" name="old_tax" value="-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_name">Naziv proizvoda</label>
                                    <input class="form-control" type="text" placeholder="Naziv proizvoda" id="product_name" name="product_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Kategorija</label>
                                    <select style="width: 100%" id="category_id" name="category_id">
                                        <option value="-1">Odaberi kategoriju</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Cijena</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">€</span>
                                        <input  name="price" id="price" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax">Porez</label>
                                    <div class="input-group">
                                        <input id="tax" name="tax" type="text" class="form-control" placeholder="Unesi porez" aria-describedby="basic-addon2">
                                        <span class="input-group-addon" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Opis</label>
                                    <textarea  class="form-control" name="description" id="description" rows="5" placeholder="Unesi opis"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="files">Slike</label>
                                        <input type="file" id="files"  name="files[]" multiple="multiple">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                        <button type="submit" class="btn btn-default" id="modal-save">Sačuvaj</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div id="history-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Proizvod</h4>
                </div>
                <div class="modal-body" id="history-modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                    <button type="submit" class="btn btn-default" id="modal-save">Sačuvaj</button>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script>
        var token = '{{ Session::token() }}';
    </script>
@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/product.js') }}" type="text/javascript"></script>
@endsection