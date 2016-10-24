var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var ChangeHandler = (function (_super) {
    __extends(ChangeHandler, _super);
    function ChangeHandler(id, target, target_cb) {
        _super.call(this, id);
        this.target = target;
        this.target_cb = target_cb;
    }
    // This is so we can register all the handlers at once. Also this separation allows for testing
    // Note: Can't be tested in jasmine (jQuery)
    ChangeHandler.registerHandlers = function () {
        var jQueryChangeHandlers = ChangeHandler.getInstances(ChangeHandler);
        jQueryChangeHandlers.forEach(function (value) {
            console.log(value.target);
            value.target.on('keyup', value.target_cb);
        });
    };
    Object.defineProperty(ChangeHandler.prototype, "target", {
        get: function () {
            return this._target;
        },
        set: function (value) {
            this._target = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ChangeHandler.prototype, "target_cb", {
        get: function () {
            return this._target_cb;
        },
        set: function (value) {
            this._target_cb = value;
        },
        enumerable: true,
        configurable: true
    });
    return ChangeHandler;
}(BaseHandler));
