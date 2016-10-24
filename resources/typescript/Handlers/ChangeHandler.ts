class ChangeHandler extends BaseHandler {
    private _target:JQuery;
    private _target_cb:(event:any) => void;

    constructor(id:string, target:JQuery, target_cb:(event:any) => void) {
        super(id);

        this.target = target;
        this.target_cb = target_cb;
    }

    // This is so we can register all the handlers at once. Also this separation allows for testing
    // Note: Can't be tested in jasmine (jQuery)
    static registerHandlers() {
        let jQueryChangeHandlers: Array<ChangeHandler> = ChangeHandler.getInstances<ChangeHandler>(ChangeHandler) as Array<ChangeHandler>;

        jQueryChangeHandlers.forEach(function(value){
            value.target.on('keyup', value.target_cb);
        });
    }

    get target():JQuery {
        return this._target;
    }

    set target(value:JQuery) {
        this._target = value;
    }

    get target_cb():(event:any)=>void {
        return this._target_cb;
    }

    set target_cb(value:(event:any)=>void) {
        this._target_cb = value;
    }
}