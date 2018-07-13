(function ($) {

    "use strict";

    let registerFormExists = document.getElementById("register-form");
    if (registerFormExists !== null) {
        $('.country-select ').on('change', function () {
            let country = $(this),
                country_id = country.find('option:selected').val(),
                regions = $(country.data('regions')),
                empty = country.data('empty');
            if (country_id.length > 0) {
                axios
                    .get("/api/regions/" + country_id)
                    .then((response) => {
                        let html = '';
                        $.each(response.data.data, function (index, region) {
                            html += '<option value="' + region.label + '">' + region.value + '</option>';
                        });
                        regions.html(html);
                    })
                    .catch((error) => {
                        this.status = 'Error:' + error;
                    });
            } else {
                regions.html('<option value="">' + empty + '</option>');
            }
            console.log(country_id);
        });

    }

    let _modal = $('#form-modal'),
        btnOk = _modal.find('.btn-ok'),
        btnDelete = _modal.find('.btn-delete'),
        form;

    let manageButtonData = function (element) {
        let label = element.data('label'),
            btnOk = element.data('btnOk'),
            message = element.data('message'),
            btnDelete = element.data('btnDelete'),
            btnCancel = element.data('btnCancel');
        form = element.data('form');
        if (message !== undefined) {
            _modal.find('.modal-body').html(message);
        }
        if (label !== undefined) {
            _modal.find('.modal-title').html(label);
        }
        if (btnOk !== undefined) {
            _modal.find('.btn-ok').html(btnOk);
        } else {
            _modal.find('.btn-ok').hide();
        }
        if (btnCancel !== undefined) {
            _modal.find('.btn-cancel').html(btnCancel);
        } else {
            _modal.find('.btn-cancel').hide();
        }
        if (btnDelete !== undefined) {
            _modal.find('.btn-delete').html(btnDelete);
        } else {
            _modal.find('.btn-delete').hide();
        }
    };

    $('body')
        .on('click', '.btn-row-delete', function (e) {
            manageButtonData($(this));
        })
        .on('change', '.dynamic-modal-form', function (e) {
            let select = $(this), option = select.find('option:selected');
            if (option.val() === 'load') {
                select.val('');
                let action = select.data('formAction');
                $.ajax({
                    type: 'GET',
                    url: action,
                    data: [],
                    success: function (data) {
                        _modal.find('.modal-body').html(data);
                        manageButtonData(select);
                        _modal.modal('show')
                    }
                });
            }
        })
        .on('click', '.repair-file-upload', function () {
            let
                form = $(this).parents('form'),
                list = form.next(),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                type_id = form.find('[name="type_id"]').val(),
                action = form.attr('action');
            fd.append('path', path);
            fd.append('type_id', type_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: action,
                type: 'POST',
                data: fd,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    list.append(response.file);
                },
            });
        })
        .on('click', '.btn-delete', function (e) {
            if ($(form) !== undefined) {
                submitForm($(form), function () {
                    $(_modal).modal('hide');
                });
                //form.submit();
            }
        });

    $('[data-toggle="popover"]').popover();

    btnOk.on('click', function () {
        let form = $('#form-content');
        if (form !== undefined) {
            submitForm(form, function () {
                $(_modal).modal('hide');
            });
        }
    });

    // btnDelete.on('click', function () {
    //     let form = $($(this).data('form'));
    //     console.log($(this).data('form'));
    //     if (form !== undefined) {
    //         console.log(form);
    //         submitForm(form, function () {
    //             $(_modal).modal('hide');
    //         });
    //         //form.submit();
    //     }
    // });

    function submitForm(form, callback) {
        $('[data-toggle="popover"]').popover('hide');
        // console.log(form.attr('method'));
        // console.log(form.attr('action'));
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',
            data: form.serializeArray() || [],
            error: function (xhr, status, error) {
                if ("errors" in xhr.responseJSON) {
                    $("#form-content")
                        .find('.form-control')
                        .removeClass('is-invalid')
                        .next()
                        .html('');
                    $.each(xhr.responseJSON.errors, function (name, error) {
                        let element = $('#form-content').find('[name="' + name + '"]');
                        element.addClass('is-invalid').next().html(error);
                    });
                }
            },
            success: function (data) {

                //$("#form-content").html('').attr('action', '');
                if ("refresh" in data) {
                    document.location.reload();
                } else {
                    if ("remove" in data) {
                        $.each(data.remove, function (index, identifier) {
                            //console.log(identifier);
                            $(identifier).remove();
                        });
                    }

                    if ("replace" in data) {
                        $.each(data.replace, function (identifier, view) {
                            $(identifier).replaceWith(view);
                        });
                    }

                    if ("update" in data) {
                        $.each(data.update, function (identifier, view) {
                            $(identifier).html(view);
                        });
                    }

                    if ("attr" in data) {
                        $.each(data.attr, function (identifier, attributes) {
                            $.each(attributes, function (attribute, value) {
                                $(identifier).attr(attribute, value);
                            });
                        });
                    }

                    if (callback !== undefined) {
                        callback();
                    }

                    $('[data-toggle="popover"]').popover();
                }

            }
        });
    }

})(jQuery);
