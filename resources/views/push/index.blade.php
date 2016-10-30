@extends('layouts.app')

@section('title', 'Pushes :: List')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/news/create') }}" class="btn btn-default btn-sm">Push</a>
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="offer_load" class="table table-clapped table-striped display dataTable no-footer">
                    <thead>
                    <tr role="row">
                        <th>Image</th>
                        <th>NewsID</th>
                        <th>DateAdd</th>
                        <th>Text</th>
                        <th>Title</th>
               
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $Data as $d)
                            
                         <tr role="row" class="odd">
                             <td class="sorting_1" ><img style="width:200px; height: auto;" src="{{ $d->ImageUrl }} ">  </td>
                            <td> {{ $d->NewsID }} </td>
                            <td> {{ $d->DateAdd }}</td>
                            <td> {{ $d->Text }}</td>
                            <td> {{ $d->Title }}</td>
                          </td>
                             </tr>

                           @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

