@extends('layouts.app')

@section('title', 'Profiles :: Update')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['url' => url('/profile/' . $Profile->UserID . '/'), 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}

                        <div class="form-group{{ $errors->has('UserID') ? ' has-error' : '' }}">
                            {!! Form::label('UserID', 'Email', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('UserID', $Profile->UserID, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('UserID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('UserID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Active') ? ' has-error' : '' }}">
                            {!! Form::label('Active', 'Active', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">

                                {!! Form::select('Active', $active_list, $Profile->Active, ['class' => 'form-control']) !!}
                                @if ($errors->has('Active'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('Active') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Avatar') ? ' has-error' : '' }}">
                            {!! Form::label('Avatar', 'Avatar', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {{--<img style="width:200px; height: auto;" src="{{ $off_get_data->Avatar }} ">--}}
                            @if(!empty($Profile->Avatar))
                                    {!! Html::image($Profile->Avatar, null, ['style' => 'max-width: 100px; max-height: 100px;']) !!}
                                @endif
                                {!! Form::file('Avatar', ['class' => 'form-control']) !!}
                                @if ($errors->has('Avatar'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('Avatar') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('NickName') ? ' has-error' : '' }}">
                            {!! Form::label('NickName', 'NickName', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('NickName', $Profile->NickName, ['class' => 'form-control']) !!}
                                @if ($errors->has('NickName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('NickName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Contacts') ? ' has-error' : '' }}">
                            {!! Form::label('Contacts', 'Contact', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Contacts', $Profile->Contacts, ['class' => 'form-control']) !!}
                                @if ($errors->has('Contacts'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Contacts') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
                            {!! Form::label('Description', 'Description', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::textarea('Description', $Profile->Description, ['class' => 'form-control']) !!}
                                @if ($errors->has('Description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('Subscribe') ? ' has-error' : '' }}">
                            {!! Form::label('Subscribe', 'Subscribe', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Subscribe', $Profile->Subscribe, ['class' => 'form-control datetimepicker']) !!}
                                @if ($errors->has('Subscribe'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Subscribe') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
