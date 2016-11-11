@extends('layouts.app')

@section('title', 'Pros')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/offer/create') }}" class="btn btn-default btn-sm">New Pros</a>
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
                        <th>Subcategory</th>
                        <th>User email</th>
                        <th>Name</th>
                        <th>Busy</th>
                        <th>Contact</th>
                        <th>Description</th>
                        <th>Active</th>
                        <th>Cost</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ( $Data as $d)

                        <tr role="row" class="odd">
                            <td class="sorting_1" > <img src="{{ $d->Avatar }}" alt="" style="width:200px; height:auto;">  </td>
                            <td>{{ $d->CatID }} </td>
                            <td> {{ $d->UserID }}</td>
                            <td> {{$d->Name}}</td>
                            <td> <?php
                                if($d->Active == 1)
                                {
                                    echo "true";
                                }
                                else
                                {
                                    echo "false";
                                }

                                ?></td>
                            <td>{{$d->Contact}}</td>
                            <td> {{$d->Desc}}</td>
                            <td>
                                <?php
                                    if($d->Active == 1)
                                    {
                                        echo "true";
                                    }
                                    else
                                        {
                                            echo "false";
                                        }

                                        ?>

                             </td>
                            <td>
                                {{$d->Cost}}
                            </td>

                            <td>

                                <div class="control">
                                    <a href="/offer/{{$d->OfferID}}/edit" class="btn btn-info btn-sm"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                                    &nbsp;<a href="/offer/{{$d->OfferID}}/delete" class="btn btn-danger btn-sm">
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

