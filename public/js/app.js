$(document).on('click', '.item_destroy', function () {
    if (confirm('Вы уверены что хотите удалить?')) {
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            data: {
                _token: window.Laravel.csrfToken
            },
            dataType: 'json',
            type: 'DELETE',
            success: function (data_r) {
                item_load.ajax.reload();
            },
            error: function (data_r) {
                console.info('ERROR');
            }
        });
    }
    return false;
});

$(document).on('click', '.item_destroy_category', function () {
    if (confirm('Вы уверены что хотите удалить?')) {
        var url = $(this).attr('data-url');
        var CatID = $(this).attr('data-CatID');

        $(this).closest('tr').remove();

        if (CatID != undefined) {
            $('.control[data-ParentCatID="' + CatID + '"]').each(function (i, el) {
                el.closest('tr').remove();
            });
        }

        $.ajax({
            url: url,
            data: {
                _token: window.Laravel.csrfToken
            },
            dataType: 'json',
            type: 'DELETE',
            success: function (data_r) {
            }
        });
    }
    return false;
});

$(function(){
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'ru'
    });
});