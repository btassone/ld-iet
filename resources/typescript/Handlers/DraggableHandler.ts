class DraggableHandler extends BaseHandler {
    private _target:JQuery;
    private _options: IDraggableOptions;

    constructor(id:string, target:JQuery, options: IDraggableOptions) {
        // Call parent class
        super(id);

        // Set properties
        this.target = target;
        this.options = options;
    }

    static initializeDraggables() {
        let draggableHandlers: Array<DraggableHandler> = DraggableHandler.getInstances<DraggableHandler>(DraggableHandler) as Array<DraggableHandler>;

        draggableHandlers.forEach(function(value){

            value.target.sortable(value.options.sortableOptions);

            if (!value.options.selection) {
                value.target.disableSelection();
            }
        });
    }

    static disableDraggables() {
        let draggableHandlers: Array<DraggableHandler> = DraggableHandler.getInstances<DraggableHandler>(DraggableHandler) as Array<DraggableHandler>;

        draggableHandlers.forEach(function(value){

            value.target.sortable("disable");
            value.target.addClass("disabled");
        });
    }

    get target():JQuery {
        return this._target;
    }
    set target(value:JQuery) {
        this._target = value;
    }

    get options():IDraggableOptions {
        return this._options;
    }
    set options(value:IDraggableOptions) {
        this._options = value;
    }
}