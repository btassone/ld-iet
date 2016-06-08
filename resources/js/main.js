var CorduroyBeach;
(function (CorduroyBeach) {
    var ClickHandler = (function () {
        function ClickHandler(target, target_cb) {
            // Set properties
            this.target = target;
            this.target_cb = target_cb;
            // Register click handler
            jQuery(this.target).on('click', this.target_cb);
            // Add instance to class array property for access later.
            (ClickHandler.click_handlers).push(this);
        }
        Object.defineProperty(ClickHandler.prototype, "target", {
            get: function () {
                return this._target;
            },
            set: function (value) {
                this._target = value;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(ClickHandler.prototype, "target_cb", {
            get: function () {
                return this._target_cb;
            },
            set: function (value) {
                this._target_cb = value;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(ClickHandler, "click_handlers", {
            get: function () {
                return this._click_handlers;
            },
            set: function (value) {
                this._click_handlers = value;
            },
            enumerable: true,
            configurable: true
        });
        ClickHandler.remove_click_handler = function (handler) {
            for (var _i = 0, _a = ClickHandler.click_handlers; _i < _a.length; _i++) {
                var click_handler = _a[_i];
                if (handler == click_handler) {
                    var handler_index = ClickHandler.click_handlers.indexOf(handler);
                    console.log("INDEX: ", handler_index);
                    delete ClickHandler.click_handlers[handler_index];
                }
            }
        };
        ClickHandler._click_handlers = [];
        return ClickHandler;
    }());
    CorduroyBeach.ClickHandler = ClickHandler;
})(CorduroyBeach || (CorduroyBeach = {}));
var CorduroyBeach;
(function (CorduroyBeach) {
    (function (ImportResponseStatuses) {
        ImportResponseStatuses[ImportResponseStatuses["NoFile"] = 0] = "NoFile";
        ImportResponseStatuses[ImportResponseStatuses["Pending"] = 1] = "Pending";
        ImportResponseStatuses[ImportResponseStatuses["Processing"] = 2] = "Processing";
        ImportResponseStatuses[ImportResponseStatuses["Finished"] = 3] = "Finished";
        ImportResponseStatuses[ImportResponseStatuses["Error"] = 4] = "Error";
    })(CorduroyBeach.ImportResponseStatuses || (CorduroyBeach.ImportResponseStatuses = {}));
    var ImportResponseStatuses = CorduroyBeach.ImportResponseStatuses;
    var ImportResponseHandler = (function () {
        function ImportResponseHandler() {
        }
        Object.defineProperty(ImportResponseHandler, "response_status_text", {
            get: function () {
                switch (this.response_status) {
                    case ImportResponseStatuses.NoFile:
                        this._response_status_text = "No file chosen.";
                        break;
                    case ImportResponseStatuses.Pending:
                        this._response_status_text = "File chosen, ready to run import.";
                        break;
                    case ImportResponseStatuses.Processing:
                        this._response_status_text = "File is processing...";
                        break;
                    case ImportResponseStatuses.Finished:
                        this._response_status_text = "File import has completed.";
                        break;
                    case ImportResponseStatuses.Error:
                        this._response_status_text = "There was an error with the import. Check the error status below.";
                        break;
                }
                return this._response_status_text;
            },
            set: function (value) {
                this._response_status_text = value;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(ImportResponseHandler, "response_status", {
            get: function () {
                return this._response_status;
            },
            set: function (value) {
                this._response_status = value;
            },
            enumerable: true,
            configurable: true
        });
        ImportResponseHandler.change_response_status = function (response_status) {
            ImportResponseHandler.response_status = response_status;
            jQuery(".import-response-status .status").text(ImportResponseHandler.response_status_text);
            jQuery(".import-response-status").attr("data-status", ImportResponseStatuses[response_status]);
        };
        return ImportResponseHandler;
    }());
    CorduroyBeach.ImportResponseHandler = ImportResponseHandler;
})(CorduroyBeach || (CorduroyBeach = {}));
/// <reference path="../typings/tsd.d.ts" />
var file_frame;
var wp;
var attachment;
var ld_iet_ajax_obj;
var CorduroyBeach;
(function (CorduroyBeach) {
    CorduroyBeach.ImportResponseHandler.change_response_status(CorduroyBeach.ImportResponseStatuses.NoFile);
    // CSV Upload Click Handler
    new CorduroyBeach.ClickHandler(jQuery('#ld_setting_course_csv_upload_btn'), function (event) {
        var calling_btn = jQuery('#ld_setting_course_csv_upload_btn');
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
            var uploaded_info_box = jQuery(".uploaded-csv-information");
            var run_import_btn = jQuery("#ld_settings_course_csv_import");
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();
            jQuery("#" + calling_btn.attr('data-txt-field')).val(JSON.stringify(attachment));
            uploaded_info_box.html("<strong>ID:</strong> " + attachment.id + "\n" +
                "<strong>Title:</strong> " + attachment.title + "\n" +
                "<strong>Filename:</strong> " + attachment.filename + "\n" +
                "<strong>URL:</strong> " + attachment.url + "\n" +
                "<strong>Link:</strong> <a href='" + attachment.link + "' target='_blank'>" + attachment.link + "</a>" + "\n" +
                "<strong>Type:</strong> " + attachment.type + "\n" +
                "<strong>Subtype:</strong> " + attachment.subtype + "\n" +
                "<strong>File Size:</strong> " + attachment.filesizeHumanReadable);
            if (!uploaded_info_box.hasClass("block")) {
                uploaded_info_box.addClass("block");
            }
            // Remove the disabled attribute
            run_import_btn.removeAttr('disabled');
            CorduroyBeach.ImportResponseHandler.change_response_status(CorduroyBeach.ImportResponseStatuses.Pending);
        });
        // Finally, open the modal
        file_frame.open();
    });
    new CorduroyBeach.ClickHandler(jQuery('#ld_settings_course_csv_import'), function (event) {
        var csv_hidden_field = jQuery('#ld_setting_course_csv');
        var data = {
            'action': 'ld_csv_import',
            'csv_json_obj': JSON.parse(csv_hidden_field.val())
        };
        CorduroyBeach.ImportResponseHandler.change_response_status(CorduroyBeach.ImportResponseStatuses.Processing);
        jQuery.post(ld_iet_ajax_obj.ajax_url, data, function (response) {
            var json_parse = JSON.parse(response);
            console.log("Run Import Response: ", json_parse);
            if (json_parse.status == "Finished") {
                CorduroyBeach.ImportResponseHandler.change_response_status(CorduroyBeach.ImportResponseStatuses.Finished);
            }
        });
    });
})(CorduroyBeach || (CorduroyBeach = {}));
