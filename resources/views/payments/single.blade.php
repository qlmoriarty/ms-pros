

@extends('layouts.app')

@section('title', 'Payments for choused user')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">

                    {!! Form::open(['action' => ['PaymentsController@searchUser', $userID], 'method' => 'POST', 'class' => 'form-inline']) !!}
                    <p style="display: inline;">Period:  &nbsp </p>
                    {{--{!! Form::text('Date_user_name' , null, ['class' => 'form-control datetimepicker']) !!}--}}
                    {!! Form::text('Date_From' , null, ['class' => 'form-control datetimepicker' , 'id' => 'datefirst']) !!}
                    {!! Form::text('Date_To' , null, ['class' => 'form-control datetimepicker', 'id'=> 'datesecond']) !!}
                    <button type="submit" class="btn btn-primary">
                        Load Payments
                    </button>

                    {!! Form::close() !!}
                    {{--{{!!  !!}}--}}

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

                        <th>User mail </th>
                        <th> Payment date </th>
                        <th> Subscribe date </th>
                        <th>Payment value</th>

                    </tr>

                    </thead>
                    <tbody>
                    {{--@foreach ( App\Payments::all()->sortBy('DateAdd', SORT_ASC) as $d)--}}


                    <?php
                    foreach ($response['Items'] as $key => $value) { ?>
                    <tr role="row" class="odd">

                        <td class="sorting_1" >
                            <a href="/payments/<?php echo   $value['UserID']['S']; ?>/search">
                                <?php echo   $value['UserID']['S']; ?>
                            </a>
                        </td>
                        <td id="payments-date-add"><?php echo  date("Y-m-d H:m:s" , $value['DateAdd']['N']/1000); ?></td>
                        <td> <?php echo  date("Y-m-d H:m:s" , $value['Subscribe']['N']/1000) ; ?> </td>
                        <td> <?php echo   $value['Value']['N'] ; ?></td>

                        </td>
                    </tr>


                    <?php } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

@push('js.files')
<script>
    $(function () {


    });
</script>
@endpush
