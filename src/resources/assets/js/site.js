(function ($) {

    "use strict";


    $(function () {

        global.$ = require('jquery');

        $('[data-toggle="tooltip"]').tooltip();
        let options = [];
        $('.dropdown-checkboxes .dropdown-menu div').on('click', function (event) {

            //console.log('dd');
            let $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx = options.indexOf(val);
            //console.log(idx);
            if (idx > -1) {
                options.splice(idx, 1);
                setTimeout(function () {
                    $inp.prop('checked', false)
                }, 0);
            } else {
                options.push(val);
                setTimeout(function () {
                    $inp.prop('checked', true)
                }, 0);
            }

            $(event.target).blur();

            //console.log(options);
            return false;
        });
    });

    let blockElements = document.getElementById("block-elements");
    if (blockElements !== null) {
        $('.map').maphilight();

        $('.pointer').hover(
            function () {
                $(".pointer[data-number=" + $(this).data('number') + "]").addClass('hover');
                $("map area[data-number=" + $(this).data('number') + "]").mouseover();
            },
            function () {
                $(".pointer[data-number=" + $(this).data('number') + "]").removeClass('hover');
                $("map area[data-number=" + $(this).data('number') + "]").mouseout();
            }
        );
        $('map area').hover(
            function () {
                $(".pointer[data-number=" + $(this).data('number') + "]").addClass('hover');
            },
            function () {
                $(".pointer[data-number=" + $(this).data('number') + "]").removeClass('hover');
            }
        );
    }


    let pointerCreateForm = document.getElementById("pointer-create-form");
    if (pointerCreateForm !== null) {
        let moveLeft = -48,
            moveDown = -50,
            ofs = 39,
            crosshair = $("#crosshair");
        $('img.map.pointers')
            .hover(function (e) {
                $('#crosshair').show()
                    .css('top', e.pageY + moveDown)
                    .css('left', e.pageX + moveLeft)
                    .appendTo('body');
            }, function () {
                $('#crosshair').hide();
            })
            .mousemove(function (e) {
                crosshair.css('top', e.pageY).css('left', e.pageX - ofs);
                if ($('[name="element_id"]').is(':checked')) {
                    crosshair.removeClass('empty').html($('[name="element_id"]:checked').parent().parent().parent().find('.number').html());
                } else {
                    crosshair.addClass('empty').html('╳ ' + $('#block-elements').data('empty'));
                }
            })
            .click(function (event) {
                if ($('[name="element_id"]:checked').val() !== 'undefined') {
                    $('[name="x"]').val(Math.round(event.pageX - $(this).offset().left - 39, 0));
                    $('[name="y"]').val(Math.round(event.pageY - $(this).offset().top, 0));
                    submitForm($('#pointer-create-form'));
                }
            });
    }

    let shapeCreateForm = document.getElementById("shape-create-form");
    if (shapeCreateForm !== null) {
        $('a.save-shape-button')
            .click(function (event) {
                if ($('[name="element_id"]:checked').val() !== 'undefined') {
                    let count = $('[name="coords"]').val().split(",").length - 1, shape;
                    switch (count) {
                        case 0:
                        case 1:
                            shape = false;
                            break;
                        case 2:
                            shape = 'circle';
                            break;
                        case 3:
                            shape = 'rect';
                            break;
                        default:
                            shape = 'poly';
                    }
                    if (shape !== false) {
                        $('[name="shape"]').val(shape);
                        submitForm($('#shape-create-form'));
                    } else {
                        alert('Неверный контур')
                    }
                } else {
                    alert('Не выбрана деталь')
                }
            });
    }
    $(document).ready(function () {
        let containerAddresses = document.getElementById("container-addresses");
        if (containerAddresses !== null) {

            let renderAddressesList = function (data) {
                if (data.features !== undefined) {
                    containerAddresses.innerHTML = null;
                    for (let key in data.features) {
                        containerAddresses.innerHTML += data.features[key].properties.balloonContentBody;
                    }
                }
            };

            let drawAddresses = function () {

                let el = $(containerAddresses),
                    region = el.data('region'),
                    action = el.data('action');

                axios
                    .get(action + '/' + region)

                    .then((response) => {

                        $('#row-count').html(response.data.data.found);
                        renderAddressesList(response.data.data);
                        $('#loading-data').remove();

                        myMap.geoObjects.remove(objectManager);
                        objectManager.removeAll();
                        objectManager.add(response.data.data);
                        myMap.geoObjects.add(objectManager);
                        let bounds = myMap.geoObjects.getBounds();
                        myMap.setBounds(bounds, {checkZoomRange: true}).then(function () {
                            if (myMap.getZoom() > 10) myMap.setZoom(10);
                        });


                    })
                    .catch((error) => {

                    });
            };

            let myMap, objectManager;

            ymaps.ready(function () {
                myMap = new ymaps.Map('addresses-map', {
                    center: [55.76, 37.64],
                    zoom: 9,
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
                drawAddresses();

            });


            // $('.services-region-select').on('click', function (e) {
            //     drawServices($(this));
            //     e.preventDefault();
            // });

            // axios
            //     .get("/api/services/location")
            //     .then((response) => {
            //
            //         if (typeof response.data.data !== "undefined") {
            //             let location = response.data.data;
            //             if(location.countryCode !== null && location.regionCode !== null){
            //                 let code = location.countryCode + '-' + location.regionCode;
            //                 $('.services-region-select').each(function (i, region) {
            //                     if (code === $(region).data('region')) {
            //                         drawServices($(region));
            //                         //$(region).trigger('click');
            //                         return true;
            //                     }
            //                 });
            //             }
            //         }
            //         drawServices($('[data-region="RU-MOW"]'));
            //
            //     })
            //     .catch((error) => {
            //         this.status = 'Error:' + error;
            //     });
        }
    });


    let summernote = document.getElementById("summernote");
    if (summernote !== null) {
        $('.summernote').summernote({
            height: 150,
            lang: 'ru-RU',
            toolbar: [
                // [groupName, [list of button]]

                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['picture', 'link', 'table']],
                ['misc', ['undo', 'redo', 'codeview']],
            ]
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
        $('.part-cost-edit').on('click', function () {
            let part_id = $(this).data('part');
            axios
                .get("/api/boilers/" + boiler_id)
                .then((response) => {

                    calc_parts();
                })
                .catch((error) => {
                    this.status = 'Error:' + error;
                });
        });
    }

    let sortableImagesList = document.getElementById("sort-list");
    if (sortableImagesList !== null) {
        Sortable.create(sortableImagesList, {
            group: 'items',
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
                //console.log(action);
                axios
                    .put(action, {sort: result})
                    .catch((error) => {
                        console.log(error);
                    });

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

    let fastProduct = document.getElementById("fast_product_id");
    if (fastProduct !== null) {
        let fast_product_id = $('#fast_product_id');
        fast_product_id.select2({
            theme: "bootstrap4",
            ajax: {
                url: '/api/products/fast',
                dataType: 'json',
                delay: 200,
                data: function (params) {
                    return {
                        'filter[search_part]': params.term,
                        'filter[limit]': fast_product_id.data('limit'),
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
                let markup = "<img style='width:70px;' src=" + product.image + " /> &nbsp; " + product.name + ' (' + product.sku + ') - ' + product.format;
                return markup;
            },
            templateSelection: function (product) {
                return product.name;
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        fast_product_id.on('select2:select', function (e) {
            let product_id = $(this).find('option:selected').val();

            axios
                .post("/cart/" + product_id + '/add', {quantity: 1})
                .then((response) => {
                    parseData(response.data);
                })
                .catch((error) => {
                    this.status = 'Error:' + error;
                });
        });
    }
    let adminPartsFieldset = document.getElementById("admin-parts-fieldset");
    if (adminPartsFieldset !== null) {
        let boiler_search = $('#product_id'),
            parts_search = $('#parts_search');
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
                let markup = product.name + ' (' + product.sku + ')';
                return markup;
            },
            templateSelection: function (product) {
                return product.name;
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    }



    // let schemeFormExists = document.getElementById("scheme-form");
    // if (schemeFormExists !== null) {
    //     let datasheet = $('#datasheet_id');
    //     datasheet.on('change', function () {
    //         let datasheet_id = datasheet.find('option:selected').val();
    //         if (datasheet_id.length > 0) {
    //             axios
    //                 .get("/api/datasheets/" + datasheet_id + "/products")
    //                 .then((response) => {
    //                     let html = '';
    //                     $.each(response.data.data, function (index, region) {
    //                         html += '<option value="' + region.label + '">' + region.value + '</option>';
    //                     });
    //                     regions.html(html);
    //                 })
    //                 .catch((error) => {
    //                     this.status = 'Error:' + error;
    //                 });
    //         } else {
    //             regions.html('<option value="">' + empty + '</option>');
    //         }
    //         console.log(country_id);
    //     });
    // }
    let registerFormExists = document.getElementById("register-form");
    let contragentFormExists = document.getElementById("contragent-form");
    let addressFormExists = document.getElementById("address-form");
    if (registerFormExists !== null || contragentFormExists !== null || addressFormExists !== null) {
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

    let mountingSourceIdExists = document.getElementById("mounting_source_id");
    if (mountingSourceIdExists !== null) {
        mountingSourceIdExists.addEventListener('change', function (e) {
            let element = e.target.parentElement.nextElementSibling;
            if (e.target.options.selectedIndex === 4) {
                element.classList.remove('d-none');
                element.classList.add('required');
                element.firstElementChild.nextElementSibling.required = true;
            } else {
                element.classList.add('d-none');
                element.classList.remove('required');
                element.firstElementChild.nextElementSibling.required = false;
            }
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


    $(".datetimepicker")
        .datetimepicker({
            locale: 'ru',
            format: 'L',
            useCurrent: false
        });

    $("#datetimepicker_date_from")
        .on("change.datetimepicker", function (e) {
            $('#datetimepicker_date_to').datetimepicker('minDate', e.date);
        });

    $("#datetimepicker_date_to")

        .on("change.datetimepicker", function (e) {
            $('#datetimepicker_date_from').datetimepicker('maxDate', e.date);
        });


    $('body')
        .on('click', '.btn-row-delete:not(:disabled)', function (e) {
            manageButtonData($(this));
        })

        .on('change', '.dynamic-modal-form', function (e) {
            let select = $(this), option = select.find('option:selected');
            //if (option.val() === 'add-option') {}

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
                        $('.datetimepicker').datetimepicker({locale: 'ru', format: 'L', useCurrent: false});
                        _modal.modal('show')
                    }
                })
            }
        })

        .on('click', '.file-type-upload', function (e) {
            let
                _this = this,
                form = $(_this).parents('form'),

                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                type_id = form.find('[name="type_id"]').val(),
                storage = form.find('[name="storage"]').val(),
                list = $($(_this).data('list')),
                multiple = $(_this).data('multiple'),
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
                    if (multiple === 0) {
                        list.html(response.data.file);
                    } else {
                        list.append(response.data.file);
                    }
                })
                .catch((error) => {
                    form.find('.form-group').addClass('is-invalid');
                    $.each(error.response.data.errors.path, function (name, error) {
                        form.find('.invalid-feedback').html(error);
                    });
                    //console.log();
                });
            e.preventDefault();
        })
        .on('click', '.file-upload-button', function (e) {
            let
                form = $(this).parents('form'),
                fd = new FormData(),
                path = form.find('[name="path"]')[0].files[0],
                type_id = form.find('[name="type_id"]').val(),
                storage = form.find('[name="storage"]').val(),
                preview = form.data('preview'),
                action = form.attr('action');
            fd.append('path', path);
            fd.append('type_id', type_id);
            fd.append('storage', storage);
            fd.append('preview', preview);
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
        .on('click', '.add-message-button', function (e) {
            let form = $(this).parents('form');
            if ($(form) !== undefined) {
                submitForm($(form), function () {
                    form[0].reset();
                    form.find('.is-invalid').removeClass('is-invalid');
                });
            }
            e.preventDefault();
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
        .on('click', '.participant-add', function () {

            let list = $('#participants-list'),
                action = $(this).data('action');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: action,
                type: 'GET',
                dataType: 'html',
                contentType: false,
                processData: false,
                success: function (response) {
                    list.append(response);
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
            let _this = this, form = $(_this).parents('form');
            submitForm(form, function () {
                addToCartModal.find('.modal-body').html(form.data('name'));
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


    btnOk.on('click', function () {
        let form = $('#form-content');
        if (form !== undefined) {
            submitForm(form, function () {
                $(_modal).modal('hide');
            });
        }
    });

    function parseData(data, callback) {


        if ("redirect" in data) {
            document.location.href = data.redirect;
        } else if ("refresh" in data) {
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
                    console.log(identifier, view);
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

            if (callback !== undefined) {
                callback();
            }

            $('[data-toggle="popover"]').popover();
            mask_phones();
        }
    }

    function submitForm(form, callback) {
        $('[data-toggle="popover"]').popover('hide');

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',
            data: form.serializeArray() || [],
            error: function (xhr, status, error) {

                if ("errors" in xhr.responseJSON) {
                    //console.log(xhr.responseJSON.errors);
                    $("#form-content")
                        .find('.form-control')
                        .removeClass('is-invalid')
                        .next()
                        .html('');
                    let parse_name = function (name) {
                        if (~name.indexOf(".")) {
                            let names = name.split('.');
                            return names.shift() + "[" + names.join("][") + "]"
                        }
                        return name;
                    };
                    $.each(xhr.responseJSON.errors, function (name, error) {
                        let element = $('#form-content').find('[name="' + parse_name(name) + '"]');
                        element.addClass('is-invalid').next().html(error);
                    });
                }
            },
            success: function (data) {
                parseData(data, callback);
                $('.toast.newest').toast('show').removeClass('newest');
                $('#form-modal').modal('hide');
            }
        });
    }

    $('[data-toggle="popover"]').popover();
    mask_phones();
    $('.toast').toast({});
})(jQuery);
