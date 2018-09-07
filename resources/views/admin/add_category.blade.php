@extends('layouts.master')

@section('title')
    Kategorije
@stop

@section('content')
    <div class="container">
    @include('includes.message-block')


    <div class="container">

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Kategorije</div>
            <div class="panel-body">
                <button onclick="resetId()" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#edit-modal">
                    Dodaj Novu Kategoriju</button>
            </div>

            <!-- Table -->
            <table class="table">
                <tr>
                    <th>Kategorija</th>
                    <th>Opis</th>
                    <th>Akcije</th>
                </tr>
                @if($categories->isEmpty())
                    <tr>
                        <td>Nema kategorija</td>
                    </tr>
                @else
                @foreach($categories as $category)
                    <tr id="cat{{$category->id}}">
                        <td>{{$category->name}}</td>
                        <td>{{$category->description}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default btn-sm" onclick="updateCategory({{$category->id}})">Izmjeni</button>
                                <form id="deleteForm" style="display: inline-block;" method="get" action="/admin/category/delete/{{$category->id}}">
                                    <button type="submit" class="btn btn-danger btn-sm">Izbriši</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @endif
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="edit-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ route('category.save') }}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                        <input type="hidden" id="category_id" name="category_id" value="-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_name">Kategorija</label>
                                    <input class="form-control" type="text" placeholder="Naziv kategorije" id="category_name" name="category_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Opis</label>
                                    <textarea  class="form-control" name="description" id="description" rows="5" placeholder="Unesi opis"></textarea>
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
    </div>
    <script>
        var token = '{{ Session::token() }}';
    </script>
@endsection

@section("js-end")
    <script src="{{ URL::to('src/js/category.js') }}" type="text/javascript"></script>
@endsection