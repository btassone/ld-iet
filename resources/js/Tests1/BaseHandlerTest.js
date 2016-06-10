var __require = require("__require");
eval( __require("../Handlers/BaseHandler.js") );
eval( __require("../Handlers/DraggableHandler.js") );
eval( __require("../Handlers/ClickHandler.js") );

describe("BaseHandler Inherited items function correctly", function(){
    it("gets specified id out of 4 separate registered handlers", function(){
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

    it("removes specified id out of 4 separate registered handlers", function(){
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

    it("isType correctly evaluates the type", function(){
        var dh = new DraggableHandler([], [], []);
        var jqch = new ClickHandler([], []);

        var dhResult;
        var jqchResult;

        dhResult = DraggableHandler.isType(dh, DraggableHandler);
        jqchResult = ClickHandler.isType(jqch, ClickHandler);

        expect(dhResult).toEqual(true);
        expect(jqchResult).toEqual(true);
    });

    it("getInstances correctly returns the desired instances", function() {
        var dh1 = new DraggableHandler([], [], []);
        var dh2 = new DraggableHandler([], [], []);
        var dh3 = new DraggableHandler([], [], []);
        var jqch = new ClickHandler([], []);
        var jqch2 = new ClickHandler([], []);

        var dhInstances = DraggableHandler.getInstances(DraggableHandler);
        var jqchInstances = ClickHandler.getInstances(ClickHandler);

        dhInstances.forEach(function(value){
            var result = DraggableHandler.isType(value, DraggableHandler);

            expect(result).toEqual(true);
        });

        jqchInstances.forEach(function(value){
            var result = ClickHandler.isType(value, ClickHandler);

            expect(result).toEqual(true);
        });
    });
});