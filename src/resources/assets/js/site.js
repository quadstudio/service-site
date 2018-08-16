(function ($) {

    "use strict";
    let servicesRegionList = document.getElementById("services-region-list");
    if (servicesRegionList !== null) {

        let myMap;
        let objectManager;

        ymaps.ready(function () {
            myMap = new ymaps.Map('service-map', {
                center: [55.76, 37.64],
                zoom: 10,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            }, {
                searchControlProvider: 'yandex#search'
            });

            objectManager = new ymaps.ObjectManager({
                clusterize: false,
                gridSize: 64,
                clusterIconLayout: "default#pieChart"
            });
            myMap.geoObjects.add(objectManager);

        });

        let renderServiceList = function (data) {
            if (data.features !== undefined) {
                let containerService = document.getElementById("container-service");

                containerService.innerHTML = null;
                for (let key in data.features) {
                    containerService.innerHTML += data.features[key].properties.balloonContentBody;
                }
            }
        };

        $('.services-region-select').on('click', function (e) {
            let _this = $(this),
                region = _this.data('region'),
                action = _this.parent().data('action');
            _this.parent().children().removeClass('active');
            _this.addClass('active');
            axios
                .get(action + '/' + region)
                .then((response) => {
                    myMap.geoObjects.remove(objectManager);
                    objectManager.removeAll();
                    objectManager.add(response.data.data);
                    myMap.geoObjects.add(objectManager);
                    myMap.container.fitToViewport();
                    myMap.setBounds(myMap.geoObjects.getBounds(), {checkZoomRange: true});
                    renderServiceList(response.data.data);
                })
                .catch((error) => {

                });
            e.preventDefault();
        });

    }

    let repairAdminEditForm = document.getElementById("repair-admin-edit-form");
    if (repairAdminEditForm !== null) {
        $('.repair-error-check').on('click', function () {

            //let name = $(this).val();
            let dt = $(this).parent();
            if ($(this).is(':checked')) {
                dt.addClass('bg-danger');
                dt.addClass('text-white');
            } else {
                dt.removeClass('bg-danger');
                dt.removeClass('text-white');
            }
        });
    }

    let sortableImagesList = document.getElementById("images-list");
    if (sortableImagesList !== null) {
        Sortable.create(sortableImagesList, {
            group: 'images',
            animation: 100,
            // Changed sorting within list
            onUpdate: function (/**Event*/evt) {
                let result = [],
                    i,
                    list = evt.item.parentElement,
                    action = list.getAttribute('data-target'),
                    elements = list.children;
                for (i = 0; i < elements.length; i++) {
                    result.push(elements[i].getAttribute('data-id'));
                }
                axios
                    .put(action, {sort: result})
                    .then((response) => {

                    })
                    .catch((error) => {
                        console.log(error);
                    });
                console.log(result);
            },

        });
    }

    let analogAddForm = document.getElementById("analog-add-form");
    if (analogAddForm !== null) {
        let analog_search = $('#analog_search');
        $('#analog-add-form').find('button').click(function () {
            submitForm($(this).closest('form'));
            return false;

        });
        analog_search.select2({
            theme: "bootstrap4",
            ajax: {
                url: '/api/products/analog',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        'filter[search_part]': params.term,
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                }
            },
            minimumInputLength: 3,
            templateResult: function (product) {
                if (product.loading) return "...";
                return product.name + ' (' + product.sku + ')';
            },
            templateSelection: function (product) {
                return product.name + ' (' + product.sku + ')';
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });


    }
    let relationAddForm = document.getElementsByClassName("relation-add-form");
    if (relationAddForm !== null) {
        let relation_search = $('.relation_search');
        $('.relation-add-form').find('button').click(function () {
            submitForm($(this).closest('form'));
            return false;
        });
        relation_search.select2({
            theme: "bootstrap4",
            ajax: {
                url: '/api/products/relation',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        'filter[search_part]': params.term,
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                }
            },
            minimumInputLength: 3,
            templateResult: function (product) {
                if (product.loading) return "...";
                return product.name + ' (' + product.sku + ')';
            },
            templateSelection: function (product) {
                return product.name + ' (' + product.sku + ')';
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });


    }
    let repairFormExists = document.getElementById("repair-form");
    if (repairFormExists !== null) {
        let allow_parts = $('#allow_parts'),
            allow_work = $('#allow_work'),
            allow_road = $('#allow_road'),
            part_delete = $('.part-delete'),
            boiler_search = $('#product_id'),
            parts_search = $('#parts_search'),
            serial_success = $('#serial-success'),
            serial_error = $('#serial-error'),
            //parts_search_fieldset = $('#parts-search-fieldset'),
            parts = $('#parts'),
            //parts_count = $('.parts_count'),
            //parts_cost = $('.parts_cost'),
            selected = [],
            value;
        // serial.on('keyup change', function () {
        //     value = $(this).val();
        //     if (value.length >= 5) {
        //         button.prop("disabled", false);
        //
        //     } else {
        //         button.prop("disabled", true);
        //     }
        // });
        let success_serial_fill = function (index, value) {
            $('.serial-' + index).html(value);
            $('.serial-' + index + '-value').val(value);
        };

        allow_parts.change(function () {
            if ($(this).find('option:selected').val() === "0") {
                //parts_search_fieldset.css('display', 'none');
                parts.html('');
                $('#total-cost').html(0);
                selected = [];
            } else {
                //parts_search_fieldset.css('display', 'block');
            }

        });


        parts_search.select2({
            theme: "bootstrap4",
            ajax: {
                url: '/api/products/repair',
                dataType: 'json',
                // delay: 200,
                data: function (params) {
                    return {
                        'filter[search_part]': params.term,
                        'filter[search_product]': boiler_search.val(),
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                }
            },
            minimumInputLength: 3,
            templateResult: function (product) {
                if (product.loading) return "...";
                //return product.name;
                //if(product.enabled) return product.name;
                //let markup = product.name + ' (' + product.sku + ')';
                let markup = "<img style='width:70px;' src=" + product.image + " /> &nbsp; " + product.name + ' (' + product.sku + ')';
                return markup;
            },
            templateSelection: function (product) {
                return product.name;
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        parts_search.on('select2:select', function (e) {
            let product_id = $(this).find('option:selected').val();
            if (!selected.includes(product_id)) {
                parts_search.removeClass('is-invalid');
                selected.push(product_id);
                axios
                    .get("/api/products/" + product_id)
                    .then((response) => {
                        parts.append(response.data);
                        $('[name="parts[' + product_id + '][count]"]').focus();
                        calc_parts();
                        parts_search.val(null)
                    })
                    .catch((error) => {
                        this.status = 'Error:' + error;
                    });
            } else {
                parts_search.addClass('is-invalid');
                //alert('Такая деталь уже есть в списке');
            }

            //console.log(data.val());
        });

        boiler_search.select2({
            theme: "bootstrap4",
            ajax: {
                url: '/api/boilers',
                dataType: 'json',
                // delay: 200,
                data: function (params) {
                    return {
                        'filter[search_boiler]': params.term,
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                }
            },
            minimumInputLength: 3,
            templateResult: function (boiler) {
                if (boiler.loading) return "...";
                //return product.name;
                //if(product.enabled) return product.name;
                let markup = boiler.type + ' ' + boiler.name + ' (' + boiler.sku + ')';
                //let markup = "<img style='width:70px;' src="+product.image+" /> &nbsp; "+ product.name + ' (' + product.sku + ')';
                return markup;
            },
            templateSelection: function (boiler) {
                return boiler.name;
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        boiler_search.on('select2:select', function (e) {
            let boiler_id = $(this).find('option:selected').val();
            axios
                .get("/api/boilers/" + boiler_id)
                .then((response) => {
                    $('[name="cost_work"]').val(response.data.data.equipment.cost_work);
                    $('[name="cost_road"]').val(response.data.data.equipment.cost_road);
                    calc_parts();
                })
                .catch((error) => {
                    this.status = 'Error:' + error;
                });
            //console.log(data.val());
        });

        allow_work.on('change', function () {
            calc_parts();
        });
        allow_road.on('change', function () {
            calc_parts();
        });


        let calc_parts = function () {
            let count = 0, cost = 0;
            parts.children().each(function (i) {
                $(this).find('.parts_cost').val();
                cost += (parseInt($(this).find('.parts_cost').val()) * $(this).find('.parts_count').val());
            });
            if (allow_work.find('option:selected').val() === '1') {
                cost += parseInt($('[name="cost_work"]').val())
            }
            if (allow_road.find('option:selected').val() === '1') {
                cost += parseInt($('[name="cost_road"]').val())
            }
            $('#total-cost').html(number_format(cost));
        };

        $(document)
            .on('click', '.part-delete', (function () {
                let index = selected.indexOf($(this).data('id'));
                if (index > -1) {
                    selected.splice(index, 1);
                }
                calc_parts();
            }))
            .on('keyup mouseup', '.parts_count', (function () {
                calc_parts();
            }));

        let number_format = function (number, decimals, dec_point, thousands_sep) {	// Format a number with grouped thousands

            let i, j, kw, kd, km;

            // input sanitation & defaults
            if (isNaN(decimals = Math.abs(decimals))) {
                decimals = 0;
            }
            if (dec_point === undefined) {
                dec_point = ".";
            }
            if (thousands_sep === undefined) {
                thousands_sep = " ";
            }

            i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

            if ((j = i.length) > 3) {
                j = j % 3;
            } else {
                j = 0;
            }

            km = (j ? i.substr(0, j) + thousands_sep : "");
            kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
            //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
            kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


            return km + kw + kd;
        };


    }
    let registerFormExists = document.getElementById("register-form");
    let contragentFormExists = document.getElementById("contragent-form");
    if (registerFormExists !== null || contragentFormExists !== null) {
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

    let addToCartModal = $('#confirm-add-to-cart');
    addToCartModal.appendTo("body");

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
        .on('click', '.btn-row-delete:not(:disabled)', function (e) {
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
        .on('click', '.repair-file-upload', function (e) {
            let
                form = $(this).parents('form'),
                list = form.next(),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                type_id = form.find('[name="type_id"]').val(),
                storage = form.find('[name="storage"]').val(),
                action = form.attr('action');
            fd.append('path', path);
            fd.append('type_id', type_id);
            fd.append('storage', storage);
            axios
                .post(action, fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    form.find('.form-group').removeClass('is-invalid');
                    list.append(response.data.file);
                })
                .catch((error) => {
                    form.find('.form-group').addClass('is-invalid');
                    $.each(error.response.data.errors.path, function (name, error) {
                        form.find('.invalid-feedback').html(error);
                    });
                    console.log();
                });
            e.preventDefault();
        })
        .on('click', '.btn-delete', function (e) {
            if ($(form) !== undefined) {
                submitForm($(form), function () {
                    $(_modal).modal('hide');
                });
                //form.submit();
            }
        })
        .on('change', '#change-user-logo', function () {

            let
                form = $(this).parents('form'),
                logo = $('#user-logo'),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                storage = form.find('[name="storage"]')[0].value,
                action = form.attr('action');
            fd.append('path', path);
            fd.append('storage', storage);
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
                    logo.attr('src', response.src);
                },
            });
        })

        .on('click', '.image-upload-button', function () {
            let
                form = $(this).parents('form'),
                list = form.data('target'),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                storage = form.find('[name="storage"]')[0].value,
                action = form.attr('action');
            fd.append('path', path);
            fd.append('storage', storage);
            axios
                .post(action, fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    parseData(response.data)
                })
                .catch((error) => {
                    // form.find('.form-group').addClass('is-invalid');
                    // $.each(error.response.data.errors.path, function (name, error) {
                    //     form.find('.invalid-feedback').html(error);
                    // });
                    console.log();
                });
            //submitForm($(this).parents('form'));
        })
        .on('click', '.image-upload', function () {

            let
                form = $(this).parents('form'),
                list = form.next(),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                storage = form.find('[name="storage"]')[0].value,
                action = form.attr('action');
            fd.append('path', path);
            fd.append('storage', storage);
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
                    list.append(response.image);
                },
            });
        })
        .on('keypress', ".cart-item input[type='number']", function (e) {

            if (e.which === 13) {
                let _this = this,
                    form = $(_this).parent('form'),
                    number = form.find('input[type="number"]'),
                    quantity = parseInt(number.val());
                if (quantity < 1) {
                    quantity = 1;
                } else if (quantity > parseInt(number.attr('max'))) {
                    quantity = parseInt(number.attr('max'));
                }
                number.val(quantity);
                submitForm(form);
                e.preventDefault();
            }
        })
        .on('click', ".cart-item .qty-btn", function (e) {
            e.preventDefault();
            let _this = this,
                form = $(_this).parent('form'),
                number = form.find('input[type="number"]'),
                quantity = parseInt(number.val())
            ;
            if ($(_this).hasClass('btn-minus')) {
                if (quantity > 1) {
                    quantity--;
                }
            }
            if ($(_this).hasClass('btn-plus')) {
                if (quantity < parseInt(number.attr('max'))) {
                    quantity++;

                }
            }

            number.val(quantity);

            submitForm(form);
        })
        .on('click', ".add-to-cart", function (e) {
            e.preventDefault();
            let _this = this, form = $(_this).parent('form');
            submitForm(form, function () {
                addToCartModal.modal('show');
            });
        })
        .on('click', '.light-box-prev', function () {
            plusSlides(-1)
        })
        .on('click', '.light-box-next', function () {
            plusSlides(1)
        })
        .on('click', '.light-box-close', function () {
            closeModal($(this).data('id'))
        })
        .on('click', '.demo', function () {
            currentSlide($(this).data('id'), $(this).data('number'))
        })
        .on('click', '.hover-shadow', function () {
            openModal($(this).data('id'));
            currentSlide($(this).data('id'), $(this).data('number'))
        });

    // Open the Modal
    function openModal(id) {
        $('.light-box-' + id).show();
    }

    // Close the Modal
    function closeModal(id) {
        $('.light-box-' + id).hide();
    }

    let slideIndex = 1;
    //showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(id, n) {
        showSlides(id, slideIndex = n);
    }

    function showSlides(id, n) {
        let i;
        let slides = $('.mySlides-' + id);
        let dots = $('.light-box-' + id + ' .demo');
        let captionText = $('.light-box-' + id + ' .light-box-caption');
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }

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
    //     //console.log($(this).data('form'));
    //     if (form !== undefined) {
    //         //console.log(form);
    //         submitForm(form, function () {
    //             $(_modal).modal('hide');
    //         });
    //         //form.submit();
    //     }
    // });

    function parseData(data, callback) {

        if ("refresh" in data) {
            document.location.reload();
        } else {
            if ("remove" in data) {
                $.each(data.remove, function (index, identifier) {
                    $(identifier).remove();
                });
            }

            if ("replace" in data) {
                $.each(data.replace, function (identifier, view) {
                    $(identifier).replaceWith(view);
                });
            }

            if ("append" in data) {
                $.each(data.append, function (identifier, view) {
                    $(identifier).append(view);
                });
            }

            if ("prepend" in data) {
                $.each(data.prepend, function (identifier, view) {
                    $(identifier).prepend(view);
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

            if ("errors" in data) {
                $.each(data.errors, function (identifier, error) {
                    alert(error);
                });
            }

            if (callback !== undefined) {
                callback();
            }

            $('[data-toggle="popover"]').popover();
        }
    }

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
                parseData(data, callback);
                $('#form-modal').modal('hide')
            }
        });
    }

})(jQuery);
