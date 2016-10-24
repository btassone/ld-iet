/// <reference path="../typings/tsd.d.ts" />

let file_frame:any;
let wp:any;
let attachment:any;
let ld_iet_ajax_obj:any;
let ldOutput:any;

class Main {

    // Note: Can't be tested in jasmine (jQuery)
    static Run() {
        // On document load items
        Main.Initialization();

        // Register the click handlers for the plugin
        Main.RegisterClickHandlers();
    }

    // Note: Can't be tested in jasmine (jQuery)
    static Initialization() {
        ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.NoFile);
    }

    // Note: Can't be tested in jasmine (jQuery)
    static RegisterClickHandlers() {

        let CSVUpload: any = function(event) {
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

                /*
                 * ======= Important Logic Bit =======
                 * Instance of when being clever doesn't help you when you come back to look at the project.
                 *
                 * This is the hidden field ld_settings_course_csv name jQuery("#" + calling_btn.attr('data-txt-field'))
                 * This is where the uploaded csv attachment is being stringified into the hidden field for the impport
                 * part later.
                 */
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

                ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.Pending);
            });

            // Finally, open the modal
            file_frame.open();
        };
        let CSVPreviewAndImport: any = function(event) {
            let csv_hidden_field:JQuery = jQuery('#ld_setting_course_csv');
            let data:{ action: string, csv_json_obj: JSON} = {
                'action': '',
                'csv_json_obj': JSON.parse(csv_hidden_field.val())
            };
            let importButton: JQuery = jQuery("#ld_settings_course_csv_import");

            ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.Processing);

            if(importButton.attr("value") == "Run Import Preview") {
                // Disable the handlers
                DraggableHandler.disableDraggables();

                data.action = 'ld_csv_preview';

                jQuery.post(ld_iet_ajax_obj.ajax_url, data, (response:any) => {
                    let json_parse = JSON.parse(response);
                    console.log("Run Import Response: ", json_parse);

                    let mainContainer: JQuery = jQuery(".ld-main-container");
                    mainContainer.removeClass("no-panel");

                    let importPreviewContainer: JQuery = jQuery(".ld-preview-output-container");
                    let columnNames: Array<string> = [];
                    let massagedData: any = [];

                    importButton.attr("value", "Run Import");

                    jQuery(".column-pattern .ui-state-default").each(function(index, value){
                        columnNames.push(jQuery(value).attr('data-name').split("_").join(" "));
                    });

                    // TODO: This is where I left off
                    json_parse.csv_data.forEach(function(csvOutput, item_index) {
                        let tempArr: any = [];
                        let recordContainer: HTMLDivElement = document.createElement("div");
                        recordContainer.classList.add("ld-preview-output-item-container");

                        csvOutput.forEach(function(csvOutputField, index) {
                            let columnItemLabel: HTMLLabelElement = document.createElement("label");
                            let columnItemValue: HTMLSpanElement = document.createElement("span");
                            let recordRowItem: HTMLDivElement = document.createElement("div");

                            columnItemLabel.innerText = columnNames[index] + ": ";
                            columnItemValue.innerText = csvOutputField == "" ? 'none' : csvOutputField;

                            recordRowItem.classList.add("ld-preview-output-record-row-item");
                            recordRowItem.appendChild(columnItemLabel);
                            recordRowItem.appendChild(columnItemValue);

                            recordContainer.appendChild(recordRowItem);

                            tempArr.push([columnNames[index], csvOutputField]);
                        });

                        recordContainer.setAttribute("data-item-num", item_index + 1);

                        if(item_index == 0) {
                            recordContainer.setAttribute("data-visible", "visible");
                        } else {
                            recordContainer.setAttribute("data-visible", "hidden");
                        }

                        massagedData.push(tempArr);
                        importPreviewContainer.append(recordContainer);
                    });

                    // TODO: Re-enable
                    if(json_parse.status == "Preview") {
                        ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.InPreview);
                    }
                });
            }

            if(importButton.attr("value") == "Run Import") {
                data.action = 'ld_csv_import';

                jQuery.post(ld_iet_ajax_obj.ajax_url, data, (response:any) => {
                    let json_parse = JSON.parse(response);
                    console.log("Run Import Response: ", json_parse);

                    if(json_parse.status == "Finished") {
                        ImportResponseUtility.changeResponseStatus(EImportResponseStatuses.Finished);
                    }

                    GeneralUtility.post('admin.php?page=ld-settings-page&tab=quiz_import', {
                        'created_id': JSON.stringify(json_parse.created_id)
                    });
                });
            }
        };

        let CSVColumnAccordion: any = function(event) {
            jQuery(event.toElement)
                .toggleClass("active")
                .parent(".csv-upload-information-accordion-wrap")
                .children(".csv-upload-information-accordion-content")
                .slideToggle(300);
        };

        let CSVColumnItemCloseFn: any = function(event) {

            function switchColumns(e: any, col: string): JQuery {
                let column: JQuery = jQuery(e.currentTarget).parent();
                let copy = column.first().clone();

                jQuery(copy).appendTo(col);
                column.remove();

                return copy;
            }

            let copy: JQuery;

            if(!jQuery(".column-pattern").hasClass("disabled")) {
                if(jQuery(event.currentTarget).parents(".column-pattern").length > 0) {
                    copy = switchColumns(event, ".disabled-column-pattern");
                } else {
                    copy = switchColumns(event, ".column-pattern");
                }

                copy.children(".csv-pat-close").on('click', CSVColumnItemCloseFn);

                event.toElement = copy;
                CSVColumnPatternStopFn(copy);
            }
        };
        let CSVColumnPatternStartFn: any = function(event) {
            jQuery(event.toElement).css("background", "green");

            this.startEvent = event;
        };
        let CSVColumnPatternStopFn: any = function(event) {
            var newOrder = [];
            var strNewOrder = "";

            var disabledItems = [];
            var strDisabledItems = "";

            // Iterate over each item and add it to the new order array
            jQuery(".column-pattern .ui-state-default").each(function(index, value){
                newOrder.push(jQuery(value).attr('data-name'));
            });

            strNewOrder = JSON.stringify(newOrder);

            jQuery(".disabled-column-pattern .ui-state-default").each(function(index, value){
                disabledItems.push(jQuery(value).attr('data-name'));
            });

            strDisabledItems = JSON.stringify(disabledItems);

            // Stringify the array and assign the value to the hidden field to be saved
            jQuery("#ld_settings_course_csv_pattern").val(strNewOrder);
            jQuery("#ld_settings_course_csv_pattern_disabled").val(strDisabledItems);

            var b = jQuery("#MainViewWrap").serialize();

            jQuery('.saving-notification').css("display", "block");

            jQuery.post('options.php', b).done(function(){
                jQuery(event.toElement).css("background", "#0085ba");
                jQuery('.saving-notification').children().each(function(index, item){
                    if(jQuery(item).hasClass("in-process")) {
                        jQuery(item).css("display", "none");
                    }

                    if(jQuery(item).hasClass("saved")) {
                        jQuery(item).css("display", "block");

                        setTimeout(function(){
                            jQuery(item).css("display", "none");
                            jQuery(item).parent().css("display", "none");
                            jQuery(item).parent().children(".in-process").css("display", "block");
                        }, 3000);
                    }
                });
            }).fail(function(){
                jQuery(event.toElement).css("background", "red");
            });
        };

        let PreviewState: any = function(state: EPreviewStates) {
            let rows:JQuery = jQuery(".ld-preview-output-item-container");
            let input:JQuery = jQuery("#ld-preview-item-input");
            let courseNum:JQuery = jQuery("#course-num");
            let inputVal: number = parseInt(input.val());
            let visibleEl:JQuery = null;
            let chosenEl:JQuery = null;

            if(inputVal) {
                switch (state) {
                    case EPreviewStates.Previous:
                        if(inputVal - 1 > 0) {
                            rows.each((index: number, elem: Element) => {
                                let rowVal: number = parseInt(elem.getAttribute("data-item-num"));
                                let rowVisibility: string = elem.getAttribute("data-visible");

                                if( rowVal == (inputVal - 1) ) {
                                    chosenEl = jQuery(elem);
                                }

                                if(rowVisibility == "visible") {
                                    visibleEl = jQuery(elem);
                                }
                            });

                            visibleEl.attr("data-visible", "hidden");
                            chosenEl.attr("data-visible", "visible");

                            input.val(inputVal - 1);
                            courseNum.text(inputVal - 1);
                        }
                        break;
                    case EPreviewStates.Change:
                        if(inputVal > 0 && inputVal <= rows.length) {
                            rows.each((index: number, elem: Element) => {
                                if(jQuery(elem).attr("data-visible") == "visible"){
                                    visibleEl = jQuery(elem);
                                }
                            });

                            chosenEl = jQuery(rows[inputVal-1]);

                            visibleEl.attr("data-visible", "hidden");
                            chosenEl.attr("data-visible", "visible");

                            courseNum.text(inputVal);
                        }
                        break;
                    case EPreviewStates.Next:
                        if(inputVal + 1 <= rows.length) {
                            rows.each((index: number, elem: Element) => {
                                let rowVal: number = parseInt(elem.getAttribute("data-item-num"));
                                let rowVisibility: string = elem.getAttribute("data-visible");

                                if( rowVal == (inputVal + 1) ) {
                                    chosenEl = jQuery(elem);
                                }

                                if(rowVisibility == "visible") {
                                    visibleEl = jQuery(elem);
                                }
                            });

                            visibleEl.attr("data-visible", "hidden");
                            chosenEl.attr("data-visible", "visible");

                            input.val(inputVal + 1);
                            courseNum.text(inputVal + 1);
                        }
                        break;
                }
            }
        };

        new ClickHandler('CSVUpload', jQuery('#ld_setting_course_csv_upload_btn'), CSVUpload);
        new ClickHandler('CSVPreviewAndImport', jQuery('#ld_settings_course_csv_import'), CSVPreviewAndImport);
        new ClickHandler('CSVColumnAccordion', jQuery('.csv-upload-information-accordion-title'), CSVColumnAccordion);
        new ClickHandler('CSVColumnItemClose', jQuery('.csv-pat-close'), CSVColumnItemCloseFn);

        new ClickHandler('PreviewPrevious', jQuery("#ld-course-preview-prev"), () => { PreviewState(EPreviewStates.Previous); });
        new ClickHandler('PreviewNext', jQuery("#ld-course-preview-next"), () => { PreviewState(EPreviewStates.Next); });
        new ChangeHandler('PreviewChange', jQuery("#ld-preview-item-input"), () => { PreviewState(EPreviewStates.Change); });

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
        ChangeHandler.registerHandlers();
        DraggableHandler.registerHandlers();
    }
}

Main.Run();