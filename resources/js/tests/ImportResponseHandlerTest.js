var __require = require("__require");
eval( __require("../dev/Handlers/ImportResponseHandler.js") );

describe("ImportResponseHandler tests return back the correct data", function() {
    it("responseStatusText returns and sets the correct status", function(){
        var testStatusAndCorrectResponses = [
            [ImportResponseStatuses.NoFile, "No file chosen."],
            [ImportResponseStatuses.Pending, "File chosen, ready to run import."],
            [ImportResponseStatuses.Processing, "File is processing..."],
            [ImportResponseStatuses.Finished, "File import has completed."],
            [ImportResponseStatuses.Error, "There was an error with the import. Check the error status below."]
        ];

        testStatusAndCorrectResponses.forEach(function(value){
            // Set the status to the current test status
            ImportResponseHandler.responseStatus = value[0];

            // Make sure that status in the switch statement in the class matches the correct status from the test
            expect(ImportResponseHandler.responseStatusText).toEqual(value[1]);
        });
    });
});