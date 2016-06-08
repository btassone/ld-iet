namespace CorduroyBeach {
    export class ClickHandler {
        private _target: JQuery;
        private _target_cb: ( event: any ) => void;

        constructor(target: JQuery, target_cb: ( event: any ) => void) {
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
}