@extends('layouts.app')

@section('title', 'Settings :: List')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                <!-- <a href="{{ url('/profile/create') }}" class="btn btn-default btn-sm">New</a> -->
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="payments_load" class="table table-clapped table-striped display dataTable no-footer">
                    <thead>

                    <tr role="row">

                        <th>UserID </th>

                        <th>DateAdd </th>
                        <th>Subscribe </th>

                        <th>Value</th>
                        <th>Action</th>


                    </tr>

                    </thead>
                    <tbody>
                    @foreach ( $Data as $d)

                        <tr role="row" class="odd">

                            <td>{{ $d->Key }} </td>

                            <td> {{$d->Value }}</td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm item_destroy" data-url="' . url('/profile/' . $data->UserID) . '"><i class="fa fa-trash"></i></a>
                                <a href="' . url('/profile/' . $data->UserID . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>
                            </td>

                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

