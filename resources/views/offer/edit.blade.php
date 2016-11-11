@extends('layouts.app')

@section('title', 'Pros :: Edit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => ['OfController@update', $id], 'method' => 'PATCH', 'class' => 'form-horizontal', 'files' => true]) !!}

                        <div class="form-group">
                            <label for="CatID" class="col-md-4 control-label">Subcategory</label>
                            <div class="col-md-6">
                               

                                <select class="form-control" id="CatID" name="CatID">
                                    <option value="{{ $get_sub->SubCatsID }}">
                                        @if  ( $get_sub->ParentCatID === 1)

                                            Lawyer
                                            &nbsp;&nbsp; - &nbsp;&nbsp;
                                        @elseif($get_sub->ParentCatID===2)

                                            Plumber
                                            &nbsp;- &nbsp;&nbsp;
                                        @elseif($get_sub->ParentCatID===20)

                                            Promo
                                            &nbsp;&nbsp; - &nbsp;&nbsp;
                                        @elseif($get_sub->ParentCatID===3)

                                            Personal Trainer
                                            &nbsp;&nbsp; - &nbsp;&nbsp;
                                        @endif
                                        {{ $get_sub->Name }}
                                    </option>

                                    @foreach($get_subcuts->sortBy('ParentCatID') as $sub)
                                        <option value="{{ $sub->SubCatsID }}">
                                            @if  ( $sub->ParentCatID === 1)

                                                Lawyer
                                                &nbsp;&nbsp; - &nbsp;&nbsp;
                                            @elseif($sub->ParentCatID===2)

                                                Plumber
                                                &nbsp;- &nbsp;&nbsp;
                                            @elseif($sub->ParentCatID===20)

                                                Promo
                                                &nbsp;&nbsp; - &nbsp;&nbsp;
                                            @elseif($sub->ParentCatID===3)

                                                Personal Trainer
                                                &nbsp;&nbsp; - &nbsp;&nbsp;
                                            @endif
                                                {{ $sub->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--UserID--}}
                        <div class="form-group{{ $errors->has('UserID') ? ' has-error' : '' }}">
                            {!! Form::label('UserID', 'User id:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('UserID', $off_get_data->UserID,  ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true', 'value' =>  $id]) !!}
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
                                {{--{{--}}
                                {{--dd($off_get_data->Active)--}}
                                {{--}}--}}
                                {!! Form::select('Active', [ 1 => 'True', 0 => 'False' ], [1 => $off_get_data->Active , 0 => $off_get_data->Active], ['class' => 'form-control']) !!}
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
                                {{--@if(!empty($Profile->Avatar))--}}
                                    {!! Html::image($off_get_data->Avatar, null, ['style' => 'max-width: 200px; max-height: 200px;']) !!}
                                {{--@endif--}}
                                {!! Form::file('Avatar' , ['class' => 'form-control']) !!}
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
                                {!! Form::text('Name', $off_get_data->Name, ['class' => 'form-control']) !!}
                                @if ($errors->has('Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('Busy') ? ' has-error' : '' }}">
                            {!! Form::label('Busy', 'Busy', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('Busy', [ 1 => 'True', 0 => 'False' ], $off_get_data->busy, ['class' => 'form-control']) !!}
                                @if ($errors->has('Busy'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('Busy') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>















                        {{--<div class="form-group{{ $errors->has('CatID') ? ' has-error' : '' }}">--}}
                            {{--{!! Form::label('CatID', 'Category id:', ['class' => 'col-md-4 control-label']) !!}--}}
                            {{--<div class="col-md-6">--}}
                                {{--{!! Form::text('CatID',  $off_get_data->CatID, ['class' => 'form-control', 'required' => 'true', 'autofocus' => 'true']) !!}--}}
                                {{--@if ($errors->has('CatID'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('CatID') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--Contacts--}}
                        <div class="form-group{{ $errors->has('Contacts') ? ' has-error' : '' }}">
                            {!! Form::label('Contacts', 'Contacts', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Contacts', $off_get_data->Contact, ['class' => 'form-control']) !!}
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
                                {!! Form::textarea('Desc', $off_get_data->Desc, ['class' => 'form-control']) !!}
                                @if ($errors->has('Desc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Cost') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Cost--}}
                        <div class="form-group{{ $errors->has('Cost') ? ' has-error' : '' }}">
                            {!! Form::label('Cost', 'Cost', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('Cost', $off_get_data->Cost, ['class' => 'form-control']) !!}
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
