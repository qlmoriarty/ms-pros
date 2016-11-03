@extends('layouts.app')

@section('title', 'News :: New')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => ['PushController@push'], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}

                        <div class="form-group{{ $errors->has('Title') ? ' has-error' : '' }}">
                            {!! Form::label('Title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Title', null, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('Title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('UserID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


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


                        <div class="form-group{{ $errors->has('Text') ? ' has-error' : '' }}">
                            {!! Form::label('Text', 'News Description', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::textarea('Text',null, ['class' => 'form-control']) !!}
                                @if ($errors->has('Text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit
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
