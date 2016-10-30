@extends('layouts.app')

@section('title', 'Payments :: List')

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
                  

                    </tr>

                    </thead>
                    <tbody>
                           {{--@foreach ( App\Payments::all()->sortBy('DateAdd', SORT_ASC) as $d)--}}
                            @foreach( App\Payments::all()->sortBy('DateAdd', SORT_ASC)->all() as $d)
<tr role="row" class="odd">
       <td class="sorting_1" > <a href="/payments/{{ $d->UserID }}">{{ $d->UserID }}</a>  </td>
    <td>{{

     date("d-M-Y H:i:s  ", $d->DateAdd/1000)
      }} </td>
{{--       <td>{{ date("jS F Y h:i:s A (T)  ", $d->DateAdd) }} </td>--}}
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

