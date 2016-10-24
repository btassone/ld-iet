class GeneralUtility {
    static post(path, parameters): void {
        let form = jQuery("<form></form>");

        form.attr("method", "post");
        form.attr("action", path);

        jQuery.each(parameters, (key:any, value:any) => {
            let field = jQuery("<input></input>");

            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);

            form.append(field);
        });

        jQuery(document.body).append(form);
        form.submit();
    }
}