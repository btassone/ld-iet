/// <reference path="../typings/tsd.d.ts" />
var file_frame;
var wp;
var attachment;
var ld_iet_ajax_obj;
var ldOutput;
var Main = (function () {
    function Main() {
    }
    // Note: Can't be tested in jasmine (jQuery)
    Main.Run = function () {
        // On document load items
        Main.Initialization();
        // Register the click handlers for the plugin
        Main.RegisterClickHandlers();
        try {
            if (ldOutput.debug == true) {
                console.log("Works");
            }
        }
        catch (e) {
            console.log("Caught Error");
        }
        // if(typeof(ldOutput.debug) != "undefined" && ldOutput.debug == true) {
        //     console.log("Works");
        // }
    };
    // Note: Can't be tested in jasmine (jQuery)
    Main.Initialization = function () {
        ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.NoFile);
    };
    // Note: Can't be tested in jasmine (jQuery)
    Main.RegisterClickHandlers = function () {
        var CSVColumnItemCloseFn = function (event) {
            function switchColumns(e, col) {
                var column = jQuery(e.currentTarget).parent();
                var copy = column.first().clone();
                jQuery(copy).appendTo(col);
                column.remove();
                return copy;
            }
            var copy;
            if (jQuery(event.currentTarget).parents(".column-pattern").length > 0) {
                copy = switchColumns(event, ".disabled-column-pattern");
            }
            else {
                copy = switchColumns(event, ".column-pattern");
            }
            copy.children(".csv-pat-close").on('click', CSVColumnItemCloseFn);
            event.toElement = copy;
            CSVColumnPatternStopFn(copy);
        };
        var CSVColumnPatternStartFn = function (event) {
            jQuery(event.toElement).css("background", "green");
            this.startEvent = event;
        };
        var CSVColumnPatternStopFn = function (event) {
            var newOrder = [];
            var strNewOrder = "";
            var disabledItems = [];
            var strDisabledItems = "";
            // Iterate over each item and add it to the new order array
            jQuery(".column-pattern .ui-state-default").each(function (index, value) {
                newOrder.push(jQuery(value).attr('data-name'));
            });
            strNewOrder = JSON.stringify(newOrder);
            jQuery(".disabled-column-pattern .ui-state-default").each(function (index, value) {
                disabledItems.push(jQuery(value).attr('data-name'));
            });
            strDisabledItems = JSON.stringify(disabledItems);
            // Stringify the array and assign the value to the hidden field to be saved
            jQuery("#ld_settings_course_csv_pattern").val(strNewOrder);
            jQuery("#ld_settings_course_csv_pattern_disabled").val(strDisabledItems);
            var b = jQuery("#MainViewWrap").serialize();
            jQuery('.saving-notification').css("display", "block");
            jQuery.post('options.php', b).done(function () {
                jQuery(event.toElement).css("background", "#0085ba");
                jQuery('.saving-notification').children().each(function (index, item) {
                    if (jQuery(item).hasClass("in-process")) {
                        jQuery(item).css("display", "none");
                    }
                    if (jQuery(item).hasClass("saved")) {
                        jQuery(item).css("display", "block");
                        setTimeout(function () {
                            jQuery(item).css("display", "none");
                            jQuery(item).parent().css("display", "none");
                            jQuery(item).parent().children(".in-process").css("display", "block");
                        }, 3000);
                    }
                });
            }).fail(function () {
                jQuery(event.toElement).css("background", "red");
            });
        };
        // CSV Upload Click Handler
        new ClickHandler('CSVUploadHandler', jQuery('#ld_setting_course_csv_upload_btn'), function (event) {
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
                ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.Pending);
            });
            // Finally, open the modal
            file_frame.open();
        });
        // Run Import Click Handler
        new ClickHandler('CSVImportHandler', jQuery('#ld_settings_course_csv_import'), function (event) {
            var csv_hidden_field = jQuery('#ld_setting_course_csv');
            var data = {
                'action': 'ld_csv_import',
                'csv_json_obj': JSON.parse(csv_hidden_field.val())
            };
            ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.Processing);
            jQuery.post(ld_iet_ajax_obj.ajax_url, data, function (response) {
                var json_parse = JSON.parse(response);
                console.log("Run Import Response: ", json_parse);
                var mainContainer = jQuery(".ld-main-container");
                mainContainer.removeClass("no-panel");
                var importButton = jQuery("#ld_settings_course_csv_import");
                importButton.attr("value", "Run Import");
                var importPreviewContainer = jQuery(".ld-preview-output-container");
                var columnNames = [];
                var massagedData = [];
                jQuery(".column-pattern .ui-state-default").each(function (index, value) {
                    columnNames.push(jQuery(value).attr('data-name').split("_").join(" "));
                });
                // TODO: This is where I left off
                json_parse.csv_data.forEach(function (csvOutput) {
                    var tempArr = [];
                    var recordContainer = document.createElement("div");
                    recordContainer.classList.add("ld-preview-output-item-container");
                    csvOutput.forEach(function (csvOutputField, index) {
                        var columnItemLabel = document.createElement("label");
                        var columnItemValue = document.createElement("span");
                        var recordRowItem = document.createElement("div");
                        columnItemLabel.innerText = columnNames[index] + ": ";
                        columnItemValue.innerText = csvOutputField;
                        recordRowItem.classList.add("ld-preview-output-record-row-item");
                        recordRowItem.appendChild(columnItemLabel);
                        recordRowItem.appendChild(columnItemValue);
                        recordContainer.appendChild(recordRowItem);
                        tempArr.push([columnNames[index], csvOutputField]);
                    });
                    massagedData.push(tempArr);
                    importPreviewContainer.append(recordContainer);
                });
                // TODO: Re-enable
                if (json_parse.status == "Finished") {
                    ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.InPreview);
                }
            });
        });
        new ClickHandler('CSVColumnAccordion', jQuery('.csv-upload-information-accordion-title'), function (event) {
            jQuery(event.toElement)
                .toggleClass("active")
                .parent(".csv-upload-information-accordion-wrap")
                .children(".csv-upload-information-accordion-content")
                .slideToggle(300);
        });
        new ClickHandler('CSVColumnItemClose', jQuery('.csv-pat-close'), CSVColumnItemCloseFn);
        new DraggableHandler('csv-column-pattern', jQuery('.column-pattern'), {
            selection: false,
            sortableOptions: {
                startEvent: {},
                start: CSVColumnPatternStartFn,
                stop: CSVColumnPatternStopFn
            }
        });
        // Registers all the click handlers to click events using jQuery
        ClickHandler.registerHandlers();
        DraggableHandler.initializeDraggables();
    };
    return Main;
}());
Main.Run();
