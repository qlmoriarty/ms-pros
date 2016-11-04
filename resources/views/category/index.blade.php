@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/category/create') }}" class="btn btn-default btn-sm">New Category</a>
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
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Category as $Category_)
                        <tr>
                            <td>{!! $Category_['CatID'] !!}</td>
                            <td><img src="{!! $Category_['Avatar'] !!}" style="max-width: 100px;max-height: 100px;"></td>
                            <td>{!! $Category_['Name'] !!}  </td>
                            <td>{!! ($Category_['Active']) ? \App\Constant\UniversalConstant::TITLE_YES : \App\Constant\UniversalConstant::TITLE_YES !!}</td>
                            <td>{!! $Category_['control'] !!}</td>
                        </tr>
                        @if(count($Category_['sub']))
                            @foreach($Category_['sub'] as $Category_sub_)
                                <tr>
                                    <td>{!! $Category_sub_['SubCatsID'] !!}</td>
                                    <td><img src="{!! $Category_sub_['Avatar'] !!}" style="max-width: 100px;max-height: 100px;"></td>
                                    <td>
                                        <p>{!! $Category_['Name'] !!} >> {!! $Category_sub_['Name'] !!}</p>
                                        <p>{!! $Category_sub_['Description'] !!}</p>
                                    </td>
                                    <td>{!! ($Category_sub_['Active']) ? \App\Constant\UniversalConstant::TITLE_YES : \App\Constant\UniversalConstant::TITLE_NO !!}</td>
                                    <td>{!! $Category_sub_['control'] !!}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
@endsection

@push('js.files')
<script>
    var item_load = null;
    $(function () {
        item_load = $('#category_load').DataTable({
            order: [[0, "asc"]],
            paging: false,
            info: false,
        });
    });
</script>
@endpush