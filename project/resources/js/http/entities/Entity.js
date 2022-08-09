import { post, postFile } from "../post";
import utils from "../../utils/Utils";
import { utils as strings } from "../../constants/strings";

class Entity {
    constructor() {
        this.errorMessage = "";
        this.errorCode = 0;
    }

    async handlePost(url, data) {
        try {
            this.errorMessage = "";
            this.errorCode = 0;
            const response = await post(url, data);

            return this.handleResponse(response);
        } catch (error) {
            console.log(error);
            this.errorMessage = error.message;
            this.errorCode = 1000;

            return null;
        }
    }

    async handlePostFile(url, data) {
        try {
            this.errorMessage = "";
            this.errorCode = 0;

            const response = await postFile(url, data);

            return this.handleResponse(response);
        } catch (error) {
            console.log(error);
            this.errorMessage = error.message;
            this.errorCode = 1000;

            return null;
        }
    }

    handleResponse(response) {
        try {
            if (!utils.isJsonString(response.data)) {
                this.errorMessage = strings.notValidJson;

                return null;
            }

            if (response.data._result !== "1") {
                this.errorMessage = response.data._error;
                this.errorCode = response.data._errorCode;

                return null;
            }

            return response.data;
        } catch (error) {
            console.log(error);
            this.errorMessage = error.message;
            this.errorCode = 1000;

            return null;
        }
    }
}

export default Entity;
