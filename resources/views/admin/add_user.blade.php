@extends('layouts.master')

@section('title')
    Korisnici
@stop

@section('content')
    <div class="container">
    @include('includes.message-block')


    <div class="container">

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Korisnici</div>
            <div class="panel-body">
                <button onclick="resetId()" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#edit-modal">
                    Dodaj Novog Korisnika</button>
            </div>

            <!-- Table -->

            <div>
                <table id="table" class="display" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <td>Ime</td>
                        <td>Prezime</td>
                        <td>E-mail</td>
                        <td>Šifra</td>
                        <td>Datim rođenja</td>
                        <td>Adresa</td>
                        <td>Grad</td>
                        <td>Država</td>
                        <td>Telefon</td>
                        <td>Admin</td>
                        <td>Akcije</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($users))
                        <tr>
                            <td>Nema korisnika</td>
                        </tr>
                    @else
                        @foreach($users as $user)
                            <tr id="user{{$user->id}}">
                                <td>{{$user->name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->password}}</td>
                                <td>{{$user->date_of_birth}}</td>
                                <td>{{$user->address}}</td>
                                <td>{{$user->city}}</td>
                                <td>{{$user->country}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->is_admin}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default btn-sm" onclick="updateUser({{$user->id}})">Izmjeni</button>
                                        <form id="deleteForm" style="display: inline-block;" method="get" action="/admin/user/delete/{{$user->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm">Izbriši</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="edit-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Korisnik</h4>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{ Session::token() }}">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Ime</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Adresa</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">šifra</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Porvrdi Šifru</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-md-4 control-label">Datum rođenja</label>

                                <div class="col-md-6">
                                    <input type="text" value="2012-30-05" id="datepicker" name="date_of_birth">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-md-4 control-label">Prezime</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-md-4 control-label">Adresa</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-md-4 control-label">Grad</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="city" value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country" class="col-md-4 control-label">Država</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="country" value="{{ old('country') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Telefon</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>
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
    <script src="{{ URL::to('src/js/user.js') }}" type="text/javascript"></script>
@endsection