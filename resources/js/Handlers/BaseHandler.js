var BaseHandler = (function () {
    function BaseHandler(id) {
        this.id = id;
        BaseHandler.instances.push(this);
    }
    BaseHandler.get = function (id) {
        var gInstance;
        for (var _i = 0, _a = BaseHandler.instances; _i < _a.length; _i++) {
            var instance = _a[_i];
            if (instance.id == id) {
                gInstance = instance;
            }
        }
        return gInstance;
    };
    // Ugly hack, THANKS TYPESCRIPT
    // TODO: Find out if there are better ways to do this
    BaseHandler.isType = function (value, key) {
        return value instanceof key;
    };
    // Ugly hack, THANKS TYPESCRIPT
    // TODO: Find out if there are better ways to do this
    BaseHandler.getInstances = function (key) {
        var retInstances = [];
        this.instances.forEach(function (value) {
            if (BaseHandler.isType(value, key)) {
                retInstances.push(value);
            }
        });
        return retInstances;
    };
    BaseHandler.remove = function (id) {
        var removed = false;
        for (var _i = 0, _a = BaseHandler.instances; _i < _a.length; _i++) {
            var instance = _a[_i];
            if (instance.id == id) {
                delete BaseHandler.instances[BaseHandler.instances.indexOf(instance)];
                if (BaseHandler.instances.indexOf(instance) == -1) {
                    removed = true;
                }
            }
        }
        return removed;
    };
    Object.defineProperty(BaseHandler.prototype, "id", {
        get: function () {
            return this._id;
        },
        set: function (value) {
            this._id = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(BaseHandler, "instances", {
        get: function () {
            return this._instances;
        },
        set: function (value) {
            this._instances = value;
        },
        enumerable: true,
        configurable: true
    });
    BaseHandler._instances = [];
    return BaseHandler;
}());
