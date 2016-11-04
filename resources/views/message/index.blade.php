@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    {{--<a href="{{ url('/message/create') }}" class="btn btn-default btn-sm">New</a>--}}
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="message_load" class="table table-clapped table-striped display dataTable no-footer">
                    <thead>
                    <tr role="row">
                        <th>Image</th>
                        <th>NickName</th>
                        <th>Email</th>
                        <th>Have unread</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

@push('js.files')
<script>
    var item_load = null;
    $(function(){
        item_load = $('#message_load').DataTable({
            order: [[0, "asc"]],
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            //searching: false,
            ajax: {
                url: '{{ url('/message/ajax') }}'
            },
            "columnDefs": [
                {"orderable": false, "targets": length - 1}
            ],
            columns: [
                {data: 'Avatar'},
                {data: 'NickName'},
                {data: 'UserID'},
                {data: 'MessageUnReaded'},
                {data: 'control', 'searchable': false}
            ]
        });
    });
</script>
@endpush