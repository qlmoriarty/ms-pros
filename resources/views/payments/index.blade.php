@extends('layouts.app')

@section('title', 'All Payments')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">


                {!! Form::open(['action' => ['PaymentsController@search'], 'method' => 'POST', 'class' => 'form-inline']) !!}
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
                            @foreach( App\Payments::all()->sortBy('DateAdd', SORT_ASC)->all() as $d)

                                 <tr role="row" class="odd">

                                 <td class="sorting_1" > <a href="/payments/{{ $d->UserID }}/search">{{ $d->UserID }}</a>  </td>
                                 <td id="payments-date-add">{{  date("Y-M-D H:i:s  ", $d->DateAdd/1000) }}</td>
{{--       <td>{{ date("jS F Y h:i:s A (T)  ", $d->DateAdd) }} </td>--}}
                                  <td> {{  date("Y-m-d H:i:s  ", $d->Subscribe/1000) }} </td>
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

@push('js.files')
<script>
    $(function () {


        $('#datefirst').datetimepicker({
            format: 'DD/MM/YYYY',
//            pickTime: false,
        });

//        $('#datetimepicker').datetimepicker({
//            format: 'DD/MM/YYYY'
//        });


    });
</script>
@endpush