var __require = require("__require");
eval( __require("../dev/BaseHandler.js") );

describe("BaseHandler Tests", function(){
    it("BaseHandler gets specified id out of 4 seperate register handlers", function(){
        // Handlers
        var BaseHandler1 = new BaseHandler('testHandler1');
        var BaseHandler2 = new BaseHandler('testHandler2');
        var BaseHandler3 = new BaseHandler('testHandler3');
        var BaseHandler4 = new BaseHandler('testHandler4');

        // Handler ID To get
        var searchedId = 'testHandler3';

        // Returned BaseHandler instance base on id searched
        var returnedHandler = BaseHandler.get(searchedId);

        // Expect the returned handlers id to equal the searched id
        expect(returnedHandler.id).toEqual(searchedId);
    });
});