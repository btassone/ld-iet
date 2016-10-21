var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var DraggableHandler = (function (_super) {
    __extends(DraggableHandler, _super);
    function DraggableHandler(id, target, options) {
        // Call parent class
        _super.call(this, id);
        // Set properties
        this.target = target;
        this.options = options;
    }
    DraggableHandler.initializeDraggables = function () {
        var draggableHandlers = DraggableHandler.getInstances(DraggableHandler);
        draggableHandlers.forEach(function (value) {
            value.target.sortable(value.options.sortableOptions);
            if (!value.options.selection) {
                value.target.disableSelection();
            }
        });
    };
    Object.defineProperty(DraggableHandler.prototype, "target", {
        get: function () {
            return this._target;
        },
        set: function (value) {
            this._target = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(DraggableHandler.prototype, "options", {
        get: function () {
            return this._options;
        },
        set: function (value) {
            this._options = value;
        },
        enumerable: true,
        configurable: true
    });
    return DraggableHandler;
}(BaseHandler));
