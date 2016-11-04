@extends('layouts.app')

@section('title', 'Category :: Edit')

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => url('/category/' . (($SubCategoryIs) ? $category->SubCatsID : $category->CatID). '/' . '?' . http_build_query(['SubCategoryIs' => $SubCategoryIs])), 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}

                @if($SubCategoryIs)
                    <div class="form-group{{ $errors->has('ParentCatID') ? ' has-error' : '' }}">
                        {!! Form::label('ParentCatID', 'Parent category', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('ParentCatID', $category_list, $category->ParentCatID, ['class' => 'form-control']) !!}
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
                        {!! Html::image($category->Avatar, null, ['style' => 'max-width: 100px; max-height: 100px;']) !!}
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
                        {!! Form::text('Name', $category->Name, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}
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
                        {!! Form::textarea('Description', $category->Description, ['class' => 'form-control']) !!}
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
                        {!! Form::select('Active', $active_list, $category->Active, ['class' => 'form-control']) !!}
                        @if ($errors->has('Active'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Active') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('MaxUsers') ? ' has-error' : '' }}">
                    {!! Form::label('MaxUsers', 'The number of pros', ['class' => 'col-md-4 control-label']) !!}
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
                            Edit
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
