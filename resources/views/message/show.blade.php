@extends('layouts.app')

@section('title', 'Message')

@section('content')
    <section class="content">

        <!-- Chat box -->
        <div class="box box-success">
            <div class="box-header">
                <i class="fa fa-comments-o"></i>
                <h3 class="box-title">@yield('title')</h3>
            </div>

            <div class="box-body chat" id="chat-box">
                <div class="text-center">
                    <button id="load_more" class="btn btn-success btn-sm"
                            data-last-time="{!! $Message['last_time'] !!}">Load more...
                    </button>
                </div>
                @include('message.show_message')
            </div><!-- /.chat -->
            <div class="box-footer">
                <form id="message_form">
                    <div class="input-group">
                        <input id="message_text" class="form-control" placeholder="Enter you message...">
                        <div class="input-group-btn">
                            <button id="message_send" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.box (chat box) -->

    </section>
@endsection

@push('js.files')
<script>
    $('#message_form').submit(function () {
        $.ajax({
            url: '{!! url('/message/' . $To->UserID . '/') !!}',
            data: {
                _token: window.Laravel.csrfToken,
                message: $('#message_text').val()
            },
            beforeSend: function (jqXHR, settings) {
                $('#message_text, #message_text').attr('disabled', true);
            },
            dataType: 'json',
            type: 'PUT',
            success: function (data_r) {
                clearTimeout(last_time_timeout);
                if (last_time_ajax != null) {
                    last_time_ajax.abort();
                }
                load_new_message();
                $('#message_text').val('');
                $('#message_text, #message_text').attr('disabled', false);
            },
            error: function (data_r) {
                $('#message_text, #message_text').attr('disabled', false);
            }
        });
        return false;
    });
    $('#load_more').click(function () {
        $.ajax({
            url: '{!! url('/message/' . $To->UserID . '/show_message') !!}',
            data: {
                _token: window.Laravel.csrfToken,
                last_time: $('#load_more').attr('data-last-time'),
                direction: '{!! \App\Message::DIRECTION_BEFORE !!}'
            },
            beforeSend: function (jqXHR, settings) {
                $('#load_more').attr('disabled', true);
            },
            dataType: 'json',
            type: 'POST',
            success: function (data_r) {
                $('#load_more').attr('disabled', false);
                $('#load_more').parent().after(data_r.html);
                $('#load_more').attr('data-last-time', data_r.last_time);
            },
            error: function (data_r) {
                $('#load_more').attr('disabled', false);
            }
        });
        return false;
    });

    var last_time = {!! \Carbon\Carbon::now()->timestamp !!};
    var last_time_timeout = null;
    var last_time_timeout_seconds = 60;
    var last_time_ajax = null;
    function load_new_message() {
        last_time_ajax = $.ajax({
            url: '{!! url('/message/' . $To->UserID . '/show_message') !!}',
            data: {
                _token: window.Laravel.csrfToken,
                last_time: last_time,
                direction: '{!! \App\Message::DIRECTION_AFTER !!}'
            },
            beforeSend: function (jqXHR, settings) {
            },
            dataType: 'json',
            type: 'POST',
            success: function (data_r) {
                $('#chat-box').append(data_r.html);
                last_time = data_r.last_time;
                last_time_timeout = setTimeout(function () {
                    load_new_message();
                }, last_time_timeout_seconds * 1000);
            },
            error: function (data_r) {
            }
        });
    }
    last_time_timeout = setTimeout(function () {
        load_new_message();
    }, last_time_timeout_seconds * 1000);
</script>
@endpush