enum ImportResponseStatuses {
    NoFile,
    Pending,
    Processing,
    Finished,
    Error
}

class ImportResponseHandler {
    private static _responseStatus: ImportResponseStatuses;
    private static _responseStatusText: string;

    static get responseStatusText():string {
        switch(this.responseStatus) {
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
    }

    static get responseStatus():ImportResponseStatuses {
        return this._responseStatus;
    }
    static set responseStatus(value:ImportResponseStatuses) {
        this._responseStatus = value;
    }

    // Note: Can't be tested in jasmine (jQuery)
    static changeResponseStatus(responseStatus: ImportResponseStatuses) {
        ImportResponseHandler.responseStatus = responseStatus;
        jQuery(".import-response-status .status").text(ImportResponseHandler.responseStatusText);
        jQuery(".import-response-status").attr("data-status", ImportResponseStatuses[responseStatus]);
    }
}