@extends('layouts.app')

@section('title', 'Offer :: New')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['url' => url('/offer'), 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}



{{--UserID--}}
                        <div class="form-group{{ $errors->has('CatID') ? ' has-error' : '' }}">
                            {!! Form::label('CatID', 'Category ID:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('CatID', null, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('CatID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('CatID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{--UserID--}}
                        <div class="form-group{{ $errors->has('UserID') ? ' has-error' : '' }}">
                            {!! Form::label('UserID', 'For User(email)', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('UserID', null, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('UserID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('UserID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

{{--Active--}}
                        <div class="form-group{{ $errors->has('Active') ? ' has-error' : '' }}">
                            {!! Form::label('Active', 'Active', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('Active', [ 1 => 'True', 0 => 'False' ], null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Active'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('Active') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
{{--Avatar--}}
                        <div class="form-group{{ $errors->has('Avatar') ? ' has-error' : '' }}">
                            {!! Form::label('Avatar', 'Avatar', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::file('Avatar', ['class' => 'form-control']) !!}
                                @if ($errors->has('Avatar'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('Avatar') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
{{--Name--}}
                        <div class="form-group{{ $errors->has('Name') ? ' has-error' : '' }}">
                            {!! Form::label('Name', 'Offer Name', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Name', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
{{--Contacts--}}
                        <div class="form-group{{ $errors->has('Contacts') ? ' has-error' : '' }}">
                            {!! Form::label('Contacts', 'Contacts', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Contacts', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Contacts'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Contacts') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    
{{--Desc--}}
                        <div class="form-group{{ $errors->has('Desc') ? ' has-error' : '' }}">
                            {!! Form::label('Desc', 'Desc', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::textarea('Desc', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Desc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Desc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Cost--}}
                        <div class="form-group{{ $errors->has('Cost') ? ' has-error' : '' }}">
                            {!! Form::label('Cost', 'Cost', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Cost', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Cost'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Cost') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
