import {
    Storage
} from "./../../js/helpers/storage";
export default {
    LOGIN(state, user) {
        Storage.set("user", user);
        state.user = user;
    },
    LOGOUT(state) {
        Storage.remove("user");
        state.user = null;
    },
    INITIALIZE(state, data) {
        state.departments = data.departments;
        state.employmentStatuses = data.employmentStatuses;
    },
};
