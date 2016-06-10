enum ImportResponseStatuses {
    NoFile,
    Pending,
    Processing,
    Finished,
    Error
}

class ImportResponseHandler {
    private static _response_status: ImportResponseStatuses;
    private static _response_status_text: string;

    static get response_status_text():string {
        switch(this.response_status) {
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
    }
    static set response_status_text(value:string) {
        this._response_status_text = value;
    }

    static get response_status():ImportResponseStatuses {
        return this._response_status;
    }
    static set response_status(value:ImportResponseStatuses) {
        this._response_status = value;
    }

    static change_response_status(response_status: ImportResponseStatuses) {
        ImportResponseHandler.response_status = response_status;
        jQuery(".import-response-status .status").text(ImportResponseHandler.response_status_text);
        jQuery(".import-response-status").attr("data-status", ImportResponseStatuses[response_status]);
    }
}