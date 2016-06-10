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
    Object.defineProperty(ImportResponseHandler, "responseStatusText", {
        get: function () {
            switch (this.responseStatus) {
                case ImportResponseStatuses.NoFile:
                    this._responseStatusText = "No file chosen.";
                    break;
                case ImportResponseStatuses.Pending:
                    this._responseStatusText = "File chosen, ready to run import.";
                    break;
                case ImportResponseStatuses.Processing:
                    this._responseStatusText = "File is processing...";
                    break;
                case ImportResponseStatuses.Finished:
                    this._responseStatusText = "File import has completed.";
                    break;
                case ImportResponseStatuses.Error:
                    this._responseStatusText = "There was an error with the import. Check the error status below.";
                    break;
            }
            return this._responseStatusText;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ImportResponseHandler, "responseStatus", {
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
    ImportResponseHandler.changeResponseStatus = function (responseStatus) {
        ImportResponseHandler.responseStatus = responseStatus;
        jQuery(".import-response-status .status").text(ImportResponseHandler.responseStatusText);
        jQuery(".import-response-status").attr("data-status", ImportResponseStatuses[responseStatus]);
    };
    return ImportResponseHandler;
})();
