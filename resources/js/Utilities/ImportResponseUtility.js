var ImportResponseUtility = (function () {
    function ImportResponseUtility() {
    }
    Object.defineProperty(ImportResponseUtility, "responseStatusText", {
        get: function () {
            switch (this.responseStatus) {
                case EImportResponseStatuses.NoFile:
                    this._responseStatusText = "No file chosen.";
                    break;
                case EImportResponseStatuses.Pending:
                    this._responseStatusText = "File chosen, ready to run import.";
                    break;
                case EImportResponseStatuses.Processing:
                    this._responseStatusText = "File is processing...";
                    break;
                case EImportResponseStatuses.InPreview:
                    this._responseStatusText = "Import is in preview.";
                    break;
                case EImportResponseStatuses.Importing:
                    this._responseStatusText = "CSV has been finalized and is importing.";
                    break;
                case EImportResponseStatuses.Finished:
                    this._responseStatusText = "File import has completed.";
                    break;
                case EImportResponseStatuses.Error:
                    this._responseStatusText = "There was an error with the import. Check the error status below.";
                    break;
            }
            return this._responseStatusText;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ImportResponseUtility, "responseStatus", {
        get: function () {
            return this._responseStatus;
        },
        set: function (value) {
            this._responseStatus = value;
        },
        enumerable: true,
        configurable: true
    });
    // Note: Can't be tested in jasmine (jQuery)
    ImportResponseUtility.changeResponseStatus = function (responseStatus) {
        ImportResponseUtility.responseStatus = responseStatus;
        jQuery(".import-response-status .status").text(ImportResponseUtility.responseStatusText);
        jQuery(".import-response-status").attr("data-status", EImportResponseStatuses[responseStatus]);
    };
    return ImportResponseUtility;
}());
