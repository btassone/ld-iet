var BaseHandler = (function () {
    function BaseHandler(id) {
        this.id = id;
        BaseHandler.instances.push(this);
    }
    BaseHandler.get = function (id) {
        var gInstance;
        for (var _i = 0, _a = BaseHandler.instances; _i < _a.length; _i++) {
            var instance = _a[_i];
            if (instance.id == id) {
                gInstance = instance;
            }
        }
        return gInstance;
    };
    BaseHandler.remove = function (id) {
        var removed = false;
        for (var _i = 0, _a = BaseHandler.instances; _i < _a.length; _i++) {
            var instance = _a[_i];
            if (instance.id == id) {
                delete BaseHandler.instances[BaseHandler.instances.indexOf(instance)];
                if (BaseHandler.instances.indexOf(instance) == -1) {
                    removed = true;
                }
            }
        }
        return removed;
    };
    Object.defineProperty(BaseHandler.prototype, "id", {
        get: function () {
            return this._id;
        },
        set: function (value) {
            this._id = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(BaseHandler, "instances", {
        get: function () {
            return this._instances;
        },
        set: function (value) {
            this._instances = value;
        },
        enumerable: true,
        configurable: true
    });
    BaseHandler._instances = [];
    return BaseHandler;
})();
/// <reference path="BaseHandler.ts" />
var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var ClickHandler = (function (_super) {
    __extends(ClickHandler, _super);
    function ClickHandler(id, target, target_cb) {
        // Call parent class
        _super.call(this, id);
        // Set properties
        this.target = target;
        this.target_cb = target_cb;
        // Register click handler
        jQuery(this.target).on('click', this.target_cb);
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
    return ClickHandler;
})(BaseHandler);
var ImportResponseStatuses;
(function (ImportResponseStatuses) {
    ImportResponseStatuses[ImportResponseStatuses["NoFile"] = 0] = "NoFile";
    ImportResponseStatuses[ImportResponseStatuses["Pending"] = 1] = "Pending";
    ImportResponseStatuses[ImportResponseStatuses["Processing"] = 2] = "Processing";
    ImportResponseStatuses[ImportResponseStatuses["Finished"] = 3] = "Finished";
    ImportResponseStatuses[ImportResponseStatuses["Error"] = 4] = "Error";
})(ImportResponseStatuses || (ImportResponseStatuses = {}));
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
})();
/// <reference path="../typings/tsd.d.ts" />
var file_frame;
var wp;
var attachment;
var ld_iet_ajax_obj;
var Cookies = "LOL";
var Main = (function () {
    function Main() {
    }
    Main.Run = function () {
        // On document load items
        Main.Initialization();
        // Register the click handlers for the plugin
        Main.RegisterClickHandlers();
    };
    Main.Initialization = function () {
        ImportResponseHandler.change_response_status(ImportResponseStatuses.NoFile);
    };
    Main.RegisterClickHandlers = function () {
        // CSV Upload Click Handler
        Main.clickHandlers.push(new ClickHandler('CSVUploadHandler', jQuery('#ld_setting_course_csv_upload_btn'), function (event) {
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
                ImportResponseHandler.change_response_status(ImportResponseStatuses.Pending);
            });
            // Finally, open the modal
            file_frame.open();
        }));
        // Run Import Click Handler
        Main.clickHandlers.push(new ClickHandler('CSVImportHandler', jQuery('#ld_settings_course_csv_import'), function (event) {
            var csv_hidden_field = jQuery('#ld_setting_course_csv');
            var data = {
                'action': 'ld_csv_import',
                'csv_json_obj': JSON.parse(csv_hidden_field.val())
            };
            ImportResponseHandler.change_response_status(ImportResponseStatuses.Processing);
            jQuery.post(ld_iet_ajax_obj.ajax_url, data, function (response) {
                var json_parse = JSON.parse(response);
                console.log("Run Import Response: ", json_parse);
                if (json_parse.status == "Finished") {
                    ImportResponseHandler.change_response_status(ImportResponseStatuses.Finished);
                }
            });
        }));
    };
    Object.defineProperty(Main, "clickHandlers", {
        get: function () {
            return this._clickHandlers;
        },
        set: function (value) {
            this._clickHandlers = value;
        },
        enumerable: true,
        configurable: true
    });
    Main._clickHandlers = [];
    return Main;
})();
Main.Run();
