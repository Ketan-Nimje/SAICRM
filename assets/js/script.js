function successToast(text) {
    Toastify({
        text: text,
        duration: 3000,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #00b09b)",
        },
        onClick: function () { } // Callback after click
    }).showToast();
}
function errorToast(text) {
    Toastify({
        text: text,
        duration: 3000,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #f06548, #f06548)",
        },
        onClick: function () { } // Callback after click
    }).showToast();
}

function getCategories(id_path = 0, is_product = 0) {
    $.ajax({
        url: window.location.href + '/get_categories',
        method: 'get',
        data: {id_path, is_product},
        dataType: 'html',
        beforeSend: function () {
            // $('button[type=submit]').prop('disabled', true);
        },
        success: function (res) {
            $(".categories-dropdown").html(res);
        },
        complete: function (res) {
            // $('button[type=submit]').prop('disabled', false);
        }
    });
}

$(document).on('submit', '.form-submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var modal_id = $(this).data('modal');
    $.ajax({
        url: url,
        method: method,
        dataType: 'json',
        async: false,
        cache: false,
        processData: false,
        contentType: false,
        // data: $(this).serialize(),
        data: new FormData(this),
        beforeSend: function () {
            $('button[type=submit]').prop('disabled', true);
        },
        success: function (res) {
            console.log(res);
            // return;
            if (res.status == 'success') {
                successToast(res.message);
                if (res.is_redirect) {
                    setTimeout(function () {
                        window.location.href = res.url;
                    }, 1000);
                } else if (res.is_table) {
                    dataTable.draw();
                }
                $("#" + modal_id).modal('hide');
            } else {
                errorToast(res.message);
            }
        },
        complete: function (res) {
            $('button[type=submit]').prop('disabled', false);
        }
    });
    return false
});

$(document).on('click', '.edit-row', function (e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    var url = $(this).data('url');
    var modal_id = $(this).data('modal');
    $.ajax({
        url: url,
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            // $('button[type=submit]').prop('disabled', true);
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                $("#" + modal_id).modal('show');
                $("#" + modal_id + " .modal-title").text(res.view_title);
                $("#" + modal_id + " #edit-btn").html('<i class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i>' + res.view_title);
                $("#" + modal_id + " #id-field").val(res.data.id);
                var form_element = res.form_element;
                for (let i = 0; i < form_element.length; i++) {
                    var ele = form_element[i];
                    if (ele.type == 'editor') {
                        var len = $("#" + modal_id + ' .editor').length;
                        if (len > 0) {
                            $("#" + modal_id + ' .editor').each(function () {
                                var id_attr = $(this).attr('id');
                                var name_attr = $(this).attr('name');
                                if (ele.name == name_attr) {
                                    CKEDITOR.instances[id_attr].setData(res.data[ele.name]);
                                }
                            })
                        } else {
                            CKEDITOR.instances['editor-field'].setData(res.data[ele.name]);
                        }
                    } else if (ele.type == 'file') {
                        $("#"+ele.name+"-field").val('');
                        $("#"+ele.name+"-preview").attr('src', res.data[ele.name]);
                    } else {
                        $(ele.type + '[name=' + ele.name + ']').val(res.data[ele.name]);
                    }
                    if ($(".categories-dropdown").length > 0 && ele.name == 'parent_id') {
                        $(".categories-dropdown").parent().hide();
                    } else if ($(".categories-dropdown").length > 0 && ele.name == 'sai_category_id') {
                        getCategories(res.data.sai_category_id, 1);
                    }                       
                }

            } else {
                errorToast(res.message);
            }
        },
        complete: function (res) {
            // $('button[type=submit]').prop('disabled', false);
        }
    });
    return false
});

$('#showModal').on('shown.bs.modal', function () {
    if ($("#view-content").length == 0 && $('.editor').length == 0) return;
    if ($('.editor').length > 0) {
        var idx = 0;
        $('.editor').each(function () {
            var id_attr = $(this).attr('id');
            var html = $("#view-content" + idx).html();
            if (html != '') {
                CKEDITOR.instances[id_attr].setData(html);
            }
            idx++;
        })
    } else if ($("#editor-field").length > 0) {

        var html = $("#view-content").html();
        CKEDITOR.instances['editor-field'].setData(html);
    }
});

$(document).on('click', '.create-btn', function () {
    var modal_id = $(this).data('modal');
    var view_title = $(this).data('modal-title');
    $("#" + modal_id).modal('show');
    $("#" + modal_id + " form").removeClass('was-validated');
    $("#" + modal_id + " .modal-title").text(view_title);
    $("#" + modal_id + " #edit-btn").html('<i class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i>' + view_title);
    $("#" + modal_id + " #id-field").val(0);
    var select_id = $("#" + modal_id + " select").val();
    if (select_id == '0') {
        $("#" + modal_id + " input,#" + modal_id + " select,#" + modal_id + " textarea,#" + modal_id + " file").val('');
        $("#" + modal_id + " select").val(0);
    } else {
        $("#" + modal_id + " input,#" + modal_id + " select,#" + modal_id + " textarea,#" + modal_id + " file").val('');
    }
    
    $("#image-preview, .image-preview").attr('src', window.location.origin+'/saiinfotech/assets/images/no-image.png');
    if ($("#" + modal_id + ' .editor').length > 0) {
        $("#" + modal_id + ' .editor').each(function () {
            var id_attr = $(this).attr('id');
            CKEDITOR.instances[id_attr].setData('');
        })
    } else if ($("#" + modal_id + " #editor-field").length > 0) {
        CKEDITOR.instances['editor-field'].setData('');
    }
    
    if ($(".categories-dropdown").length > 0) {
        $(".categories-dropdown").parent().show();
        getCategories();
    }
});

$(document).on('click', '.reply-inquirey', function () {
    var modal_id = $(this).data('modal');
    var view_title = $(this).data('modal-title');
    var id = $(this).data('id');
    $("#" + modal_id).modal('show');
    $("#" + modal_id + " form").removeClass('was-validated');
    $("#" + modal_id + " .modal-title").text(view_title);
    $("#" + modal_id + " #edit-btn").html('<i class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i>' + view_title);
    $("#" + modal_id + " #id-field").val(id);
    $("#" + modal_id + " textarea").val('');
});