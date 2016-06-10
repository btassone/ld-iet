class BaseHandler {
    private _id:string;

    private static _instances:Array<BaseHandler> = [];

    constructor(id:string) {
        this.id = id;

        BaseHandler.instances.push(this);
    }

    static get(id:string):BaseHandler {
        let gInstance:BaseHandler;

        for (let instance of BaseHandler.instances) {
            if (instance.id == id) {
                gInstance = instance;
            }
        }

        return gInstance;
    }

    static remove(id:string):boolean {
        let removed:boolean = false;

        for (let instance of BaseHandler.instances) {
            if (instance.id == id) {
                delete BaseHandler.instances[BaseHandler.instances.indexOf(instance)];

                if (BaseHandler.instances.indexOf(instance) == -1) {
                    removed = true;
                }
            }
        }

        return removed;
    }

    get id():string {
        return this._id;
    }

    set id(value:string) {
        this._id = value;
    }

    static get instances():Array<BaseHandler> {
        return this._instances;
    }

    static set instances(value:Array<BaseHandler>) {
        this._instances = value;
    }
}