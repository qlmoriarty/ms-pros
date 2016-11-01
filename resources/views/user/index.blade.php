@extends('layouts.app')

@section('title', 'Users :: List')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/user/create') }}" class="btn btn-default btn-sm">New</a>
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="user_load" class="table table-clapped table-striped display dataTable no-footer">
                    <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
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
        item_load = $('#user_load').DataTable({
            order: [[0, "asc"]],
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            //searching: false,
            ajax: {
                url: '{{ url('/user/ajax') }}'
            },
            "columnDefs": [
                {"orderable": false, "targets": length - 1}
            ],
            columns: [
                {data: 'UserId'},
                {data: 'name'},
                {data: 'email'},
                {data: 'role'},
                {data: 'control', 'searchable': false}
            ]
        });
    });
</script>
@endpush