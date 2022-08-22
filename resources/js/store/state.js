import {
    Storage
} from "./../../js/helpers/storage";

const user = Storage.get("user");

export default {
    user: user || null,
    departments: [],
    employmentStatuses: [],
};
