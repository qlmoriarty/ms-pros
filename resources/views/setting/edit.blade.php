@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['url' => url('/setting/'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}

                        @foreach($fields as $group)
                            <h4>{!! $group['title'] !!}</h4>
                            @foreach($group['fields'] as $key => $field)
                                <?php
                                if (!isset($field['options'])) {
                                    $field['options'] = [];
                                }
                                ?>
                                <div class="form-group{{ $errors->has($key) ? ' has-error' : '' }}">
                                    {!! Form::label($key, $field['title'], ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-6">
                                        @if($field['type'] == 'select')
                                            {!! Form::select($key, $$field['list'], $Setting[$key], ['class' => 'form-control'] + $field['options']) !!}
                                        @else
                                            {!! Form::text($key, isset($Setting[$key]) ? $Setting[$key] : '', ['class' => 'form-control'] + $field['options']) !!}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
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