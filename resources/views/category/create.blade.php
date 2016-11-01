@extends('layouts.app')

@section('title', 'Category :: New')

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => url('/category' . '?' . http_build_query(['SubCategoryIs' => $SubCategoryIs])), 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}

                @if($SubCategoryIs)
                    <div class="form-group{{ $errors->has('ParentCatID') ? ' has-error' : '' }}">
                        {!! Form::label('ParentCatID', 'Parent category', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('ParentCatID', $category_list, $ParentCatID, ['class' => 'form-control']) !!}
                            @if ($errors->has('ParentCatID'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ParentCatID') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                @endif

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

                <div class="form-group{{ $errors->has('Name') ? ' has-error' : '' }}">
                    {!! Form::label('Name', 'Name', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('Name', null, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                        @if ($errors->has('Name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
                    {!! Form::label('Description', 'Description', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('Description', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('Description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('Active') ? ' has-error' : '' }}">
                    {!! Form::label('Active', 'Active', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('Active', $active_list, null, ['class' => 'form-control']) !!}
                        @if ($errors->has('Active'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Active') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('MaxUsers') ? ' has-error' : '' }}">
                    {!! Form::label('MaxUsers', 'The number of users in a group', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('MaxUsers', null, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
                        @if ($errors->has('MaxUsers'))
                            <span class="help-block">
                                <strong>{{ $errors->first('MaxUsers') }}</strong>
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
    </section>
@endsection
