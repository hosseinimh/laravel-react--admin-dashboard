import { USERS_API_URLS as API_URLS } from "../../constants";
import utils from "../../utils/Utils";
import Entity from "./Entity";

export class User extends Entity {
    constructor() {
        super();
    }

    async getPagination(email, name, family, page = 1) {
        return await this.handlePost(API_URLS.FETCH_USERS, {
            email: email,
            name: name,
            family: family,
            page: page,
        });
    }

    async get(id) {
        return await this.handlePost(API_URLS.FETCH_USER + "/" + id);
    }

    async update(id, name, family) {
        return await this.handlePost(API_URLS.UPDATE_USER + "/" + id, {
            name: name,
            family: family,
        });
    }

    async changePassword(id, newPassword, confirmPassword) {
        return await this.handlePost(API_URLS.CHANGE_PASSWORD + "/" + id, {
            new_password: newPassword,
            new_password_confirmation: confirmPassword,
        });
    }

    logOut() {
        utils.clearLS();
    }
}
