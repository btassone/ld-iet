namespace CorduroyBeach {
    export class ClickHandler {
        private _target: JQuery;
        private _target_cb: ( event: any ) => void;
        
        private static _click_handlers: Array<ClickHandler> = [];

        constructor(target: JQuery, target_cb: ( event: any ) => void) {
            // Set properties
            this.target = target;
            this.target_cb = target_cb;

            // Register click handler
            jQuery(this.target).on('click', this.target_cb);

            // Add instance to class array property for access later.
            (ClickHandler.click_handlers).push(this);
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

        static get click_handlers():Array<CorduroyBeach.ClickHandler> {
            return this._click_handlers;
        }
        static set click_handlers(value:Array<CorduroyBeach.ClickHandler>) {
            this._click_handlers = value;
        }
        
        static remove_click_handler(handler: ClickHandler) {
            for(let click_handler of ClickHandler.click_handlers) {
                if (handler == click_handler) {
                    let handler_index = ClickHandler.click_handlers.indexOf(handler);
                    console.log("INDEX: ", handler_index);
                    delete ClickHandler.click_handlers[handler_index];
                }
            }
        }
    }
}