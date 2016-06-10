class ImportResponseUtility {
    private static _responseStatus:EImportResponseStatuses;
    private static _responseStatusText:string;

    static get responseStatusText():string {
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
            case EImportResponseStatuses.Finished:
                this._responseStatusText = "File import has completed.";
                break;
            case EImportResponseStatuses.Error:
                this._responseStatusText = "There was an error with the import. Check the error status below.";
                break;
        }
        return this._responseStatusText;
    }

    static get responseStatus():EImportResponseStatuses {
        return this._responseStatus;
    }
    static set responseStatus(value:EImportResponseStatuses) {
        this._responseStatus = value;
    }

    // Note: Can't be tested in jasmine (jQuery)
    static changeResponseStatus(responseStatus:EImportResponseStatuses) {
        ImportResponseUtility.responseStatus = responseStatus;
        jQuery(".import-response-status .status").text(ImportResponseUtility.responseStatusText);
        jQuery(".import-response-status").attr("data-status", EImportResponseStatuses[responseStatus]);
    }
}