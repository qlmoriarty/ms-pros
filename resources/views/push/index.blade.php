@extends('layouts.app')

@section('title', 'News')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/pushes/create') }}" class="btn btn-default btn-sm"> News Create</a>
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
                      {{--  <th> News #</th> --}}
                        <th>Date</th>

                        <th>Title</th>
                        <th style="width: 200px;">Message</th>
                        <th>Action</th>
               
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $Data as $d)
                            
                         <tr role="row" class="odd">
                             <td class="sorting_1" ><img style="width:200px; height: auto;" src="{{ $d->ImageUrl }} ">  </td>
                            {{--<td> {{ $d->NewsID }} </td>--}}

{{--                             <td> {{  date("Y-m-d H:i:s  ", ($d->DateAdd)*1000) }}</td>--}}
                            <td> {{ $d->DateAdd }}</td>
                            <td> {{ $d->Title }}</td>
                            <td style="width: 200px;"> {{ $d->Text }}</td>
                             <td>
                                 <div class="control">
                                     <a href="/pushes/{{$d->NewsID}}/{{$d->DateAdd}}/pushall/" class="btn btn-info btn-sm">
                                         <i class="fa  fa-paper-plane-o" aria-hidden="true"></i>
                                     </a>
                                     {{--<a href="/pushes/push" class="btn btn-info btn-sm">--}}
                                         {{--<i class="fa  fa-at" aria-hidden="true"></i>--}}
                                     {{--</a>--}}
                                     <a href="/pushes/{{$d->NewsID}}/{{$d->DateAdd}}/edit" class="btn btn-info btn-sm"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                                     &nbsp;<a href="/pushes/{{$d->NewsID}}/{{$d->DateAdd}}/delete" class="btn btn-danger btn-sm">
                                         <i class="fa fa-trash" aria-hidden="true"></i>
                                     </a>

                                 </div>
                             </td>

                             </tr>

                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

