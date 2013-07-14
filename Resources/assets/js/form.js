/**
 * jQuery function to decorate forms with fancy widgets.
 *
 * All options are optional. Default values are shown here.
 *
 * $("form").formDecorate({
 *     decorate_datetime: true
 * });
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
jQuery.fn.formDecorate = function () {

    /**
     * Converts an array of strings to lower.
     *
     * @return array
     */
    function arrayToLower(array)
    {
        return array.map(function (val) {
            return val.toLowerCase();
        });
    };

    /**
     * Decorates fields of type date and time.
     */
    function decorateDatetime($form)
    {
        $form.find('input.ui-widget-date').each(function (i, e) {
            var $e = $(e);

            var locale = $e.attr('data-date-locale') || 'en';
            var locale = locale.replace('_', '-');
            var format = $e.attr('data-date-format') || null;
            var options = {};

            if (undefined !== $.datepicker.regional[locale]) {
                options = $.datepicker.regional[locale];
            } else {
                if (locale.length > 2) {
                    locale = locale.substring(0, 2).toLowerCase();
                }

                if (undefined !== $.datepicker.regional[locale]) {
                    options = $.datepicker.regional[locale];
                } else {
                    for (key in $.datepicker.regional) {
                        if (key.indexOf(locale) === 0) {
                            options = $.datepicker.regional[key];
                        }
                    }
                }
            }

            options['dateFormat'] = format;
            $e.datepicker(options);
            $e.parent().find("a.btn").click(function () {
                $e.datepicker("show");
            });
        });
    };

    var $form = $(this[0]);
    var options = $.merge({
        decorate_datetime: true
    }, arguments[0] || {});

    if (options.decorate_datetime) {
        decorateDatetime($form);
    }
}

$(function() {
    $("form").formDecorate();
});
