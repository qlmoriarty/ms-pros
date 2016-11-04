@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                <a href="{{ url('/setting/create') }}" class="btn btn-default btn-sm">New Setting</a>
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

                        <th>Key </th>


                        <th>Value</th>
                        <th>Action</th>


                    </tr>

                    </thead>
                    <tbody>
                    @foreach ( $Setting as $d)

                        <tr role="row" class="odd">

                            <td>{{ $d->Key }} </td>

                            <td> {{$d->Value }}</td>
                            <td>
                                <a href="/setting/{id}/delete" class="btn btn-danger btn-sm" >
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>
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

