@extends('layouts.app')

@section('title', 'Users Profiles')

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/profile/create') }}" class="btn btn-default btn-sm"> New Profile</a>
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <table id="profile_load" class="table table-clapped table-striped display dataTable no-footer">
                    <thead>
                    <tr role="row">
                        <th>Image</th>
                        <th>NickName</th>
                        <th>Email</th>
                        <th>Active</th>
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
        item_load = $('#profile_load').DataTable({
            order: [[0, "asc"]],
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            //searching: false,
            ajax: {
                url: '{{ url('/profile/ajax') }}'
            },
            "columnDefs": [
                {"orderable": false, "targets": length - 1}
            ],
            columns: [
                {data: 'Avatar'},
                {data: 'NickName'},
                {data: 'UserID'},
                {data: 'Active'},
                {data: 'control', 'searchable': false}
            ]
        });
    });
</script>
@endpush