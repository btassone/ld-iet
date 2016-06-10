/// <reference path="../typings/tsd.d.ts" />

let file_frame:any;
let wp:any;
let attachment:any;
let ld_iet_ajax_obj:any;

class Main {
    private static _clickHandlers: Array<ClickHandler> = [];

    static Run() {
        // On document load items
        Main.Initialization();

        // Register the click handlers for the plugin
        Main.RegisterClickHandlers();
    }
    static Initialization() {
        ImportResponseHandler.change_response_status(ImportResponseStatuses.NoFile);
    }

    static RegisterClickHandlers() {
        // CSV Upload Click Handler
        Main.clickHandlers.push(new ClickHandler(
            'CSVUploadHandler',
            jQuery('#ld_setting_course_csv_upload_btn'),
            (event:any) => {

                let calling_btn = jQuery('#ld_setting_course_csv_upload_btn');

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    frame: 'select',
                    button: {
                        text: "Add Course CSV File"
                    },
                    multiple: false,
                    library: {
                        type: ['text/csv']
                    }
                });

                // When an image is selected, run a callback.
                file_frame.on('select', function () {
                    let uploaded_info_box:JQuery = jQuery(".uploaded-csv-information");
                    let run_import_btn:JQuery = jQuery("#ld_settings_course_csv_import");

                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();

                    jQuery("#" + calling_btn.attr('data-txt-field')).val(JSON.stringify(attachment));
                    uploaded_info_box.html(
                        "<strong>ID:</strong> " + attachment.id + "\n" +
                        "<strong>Title:</strong> " + attachment.title + "\n" +
                        "<strong>Filename:</strong> " + attachment.filename + "\n" +
                        "<strong>URL:</strong> " + attachment.url + "\n" +
                        "<strong>Link:</strong> <a href='" + attachment.link + "' target='_blank'>" + attachment.link + "</a>" + "\n" +
                        "<strong>Type:</strong> " + attachment.type + "\n" +
                        "<strong>Subtype:</strong> " + attachment.subtype + "\n" +
                        "<strong>File Size:</strong> " + attachment.filesizeHumanReadable
                    );

                    if (!uploaded_info_box.hasClass("block")) {
                        uploaded_info_box.addClass("block");
                    }

                    // Remove the disabled attribute
                    run_import_btn.removeAttr('disabled');

                    ImportResponseHandler.change_response_status(ImportResponseStatuses.Pending);
                });

                // Finally, open the modal
                file_frame.open();
            }
        ));

        // Run Import Click Handler
        Main.clickHandlers.push(new ClickHandler(
            'CSVImportHandler',
            jQuery('#ld_settings_course_csv_import'),
            (event:any) => {
                let csv_hidden_field:JQuery = jQuery('#ld_setting_course_csv');
                let data:{} = {
                    'action': 'ld_csv_import',
                    'csv_json_obj': JSON.parse(csv_hidden_field.val())
                };

                ImportResponseHandler.change_response_status(ImportResponseStatuses.Processing);

                jQuery.post(ld_iet_ajax_obj.ajax_url, data, (response:any) => {
                    let json_parse = JSON.parse(response);
                    console.log("Run Import Response: ", json_parse);

                    if(json_parse.status == "Finished") {
                        ImportResponseHandler.change_response_status(ImportResponseStatuses.Finished);
                    }
                });
            }
        ));
    }

    static get clickHandlers():Array<ClickHandler> {
        return this._clickHandlers;
    }
    static set clickHandlers(value:Array<ClickHandler>) {
        this._clickHandlers = value;
    }
}

Main.Run();