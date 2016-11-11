@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => ['SettingController@update',$data->Key], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}


                        <div class="form-group{{ $errors->has('Key') ? ' has-error' : '' }}">
                            {!! Form::label('Key', 'Setting Name:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Key', $data->Key, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('Key'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Key') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Value') ? ' has-error' : '' }}">
                            {!! Form::label('Value', 'Setting Value:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Value', $data->Value, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                                @if ($errors->has('Value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <button type="reset" class="btn btn-primary">
                                    Reset
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