/// <reference path="BaseHandler.ts" />

class ClickHandler extends BaseHandler {
    private _target: JQuery;
    private _target_cb: ( event: any ) => void;

    constructor(id: string, target: JQuery, target_cb: ( event: any ) => void) {
        // Call parent class
        super(id);

        // Set properties
        this.target = target;
        this.target_cb = target_cb;

        // Register click handler
        jQuery(this.target).on('click', this.target_cb);
    }

    get target(): JQuery {
        return this._target;
    }
    set target(value: JQuery) {
        this._target = value;
    }

    get target_cb():(event:any)=>void {
        return this._target_cb;
    }
    set target_cb(value:(event:any)=>void) {
        this._target_cb = value;
    }
}