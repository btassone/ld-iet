var GeneralUtility = (function () {
    function GeneralUtility() {
    }
    GeneralUtility.post = function (path, parameters) {
        var form = jQuery("<form></form>");
        form.attr("method", "post");
        form.attr("action", path);
        jQuery.each(parameters, function (key, value) {
            var field = jQuery("<input></input>");
            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);
            form.append(field);
        });
        console.log(form);
        jQuery(document.body).append(form);
        form.submit();
    };
    return GeneralUtility;
}());
