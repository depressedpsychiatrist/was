class StorageClass {
    constructor() {
        this.key =
            "OSLSda3IcCmy0ztF6s40hlXzBoNUWbM9kxjZjP5yQTWR3xnukXjiucQ7KgzPgsAW";
    }

    get(name) {
        return JSON.parse(localStorage.getItem(this.key + name));
    }

    set(name, item) {
        localStorage.setItem(this.key + name, JSON.stringify(item));
    }

    remove(name) {
        localStorage.removeItem(this.key + name);
    }
}

const Storage = new StorageClass();

export {
    Storage
};
