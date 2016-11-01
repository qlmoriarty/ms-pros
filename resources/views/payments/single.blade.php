@extends('layouts.app')

@section('title', 'User Payments :: List')

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
                           
                        {{--<th>UserID </th>--}}

                        <th>DateAdd </th>
                        <th>Subscribe </th>

                        <th>Value</th>
                  

                    </tr>

                    </thead>
                    <tbody>
                           @foreach ( $Payments as $d)
                                                                
                                    <tr role="row" class="odd">
                                         
                                           <td>{{ $d->DateAdd }} </td>
                                           <td> {{ $d->Subscribe }}</td>
                                           <td> {{$d->Value }}</td>
                                           
                                        </td>
                                    </tr>


                           @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

