var __require = require("__require");
eval( __require("../Enums/EImportResponseStatuses.js") );
eval( __require("../Utilities/ImportResponseUtility.js") );

describe("ImportResponseUtility tests return back the correct data", function() {
    it("responseStatusText returns and sets the correct status", function(){
        var testStatusAndCorrectResponses = [
            [EImportResponseStatuses.NoFile, "No file chosen."],
            [EImportResponseStatuses.Pending, "File chosen, ready to run import."],
            [EImportResponseStatuses.Processing, "File is processing..."],
            [EImportResponseStatuses.Finished, "File import has completed."],
            [EImportResponseStatuses.Error, "There was an error with the import. Check the error status below."]
        ];

        testStatusAndCorrectResponses.forEach(function(value){
            // Set the status to the current test status
            ImportResponseUtility.responseStatus = value[0];

            // Make sure that status in the switch statement in the class matches the correct status from the test
            expect(ImportResponseUtility.responseStatusText).toEqual(value[1]);
        });
    });
});