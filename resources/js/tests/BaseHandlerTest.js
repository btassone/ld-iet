var __require = require("__require");
eval( __require("../Handlers/BaseHandler.js") );

describe("BaseHandler Inherited items function correctly", function(){
    it("BaseHandler gets specified id out of 4 separate registered handlers", function(){
        // Handlers
        var BaseHandler1 = new BaseHandler('testHandler1');
        var BaseHandler2 = new BaseHandler('testHandler2');
        var BaseHandler3 = new BaseHandler('testHandler3');
        var BaseHandler4 = new BaseHandler('testHandler4');

        // Handler ID to get
        var searchedId = 'testHandler3';

        // Returned BaseHandler instance base on id searched
        var returnedHandler = BaseHandler.get(searchedId);

        // Expect the returned handlers id to equal the searched id
        expect(returnedHandler.id).toEqual(searchedId);
    });

    it("BaseHandler removes specified id out of 4 separate registered handlers", function(){
        // Handlers
        var BaseHandler1 = new BaseHandler('testHandler1');
        var BaseHandler2 = new BaseHandler('testHandler2');
        var BaseHandler3 = new BaseHandler('testHandler3');
        var BaseHandler4 = new BaseHandler('testHandler4');

        // Handler ID to remove
        var searchedId = 'testHandler3';

        // The status of the removed item, did it get removed according to the function?
        var idRemoved = BaseHandler.remove(searchedId);
        var inListOfHandlers = false;

        BaseHandler.instances.forEach(function(value){
            if(value.id == searchedId) {
                inListOfHandlers = true;
            }
        });

        // Expect the bRemoved to be true
        expect(idRemoved).toEqual(true);

        // Expect the item to not be in the list of handlers and return false
        expect(inListOfHandlers).toEqual(false);
    });
});