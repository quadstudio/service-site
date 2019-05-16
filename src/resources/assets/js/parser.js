class Parser {
    parse(data, callback) {
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
        }
    }
}

export default Parser;