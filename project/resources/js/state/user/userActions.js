import { USERS_API_URLS as API_URLS } from "../../constants";
import { post } from "../../http";
import { handleError } from "../globalActions";
import utils from "../../utils/Utils";
import { utils as strings } from "../../constants/strings";

export const FETCH_LOGIN_REQUEST_ACTION = "FETCH_LOGIN_REQUEST_ACTION";
export const FETCH_LOGIN_SUCCESS_ACTION = "FETCH_LOGIN_SUCCESS_ACTION";
export const FETCH_LOGIN_FAILURE_ACTION = "FETCH_LOGIN_FAILURE_ACTION";

export const FETCH_AUTH_USER_REQUEST_ACTION = "FETCH_AUTH_USER_REQUEST_ACTION";
export const FETCH_AUTH_USER_SUCCESS_ACTION = "FETCH_AUTH_USER_SUCCESS_ACTION";
export const FETCH_AUTH_USER_FAILURE_ACTION = "FETCH_AUTH_USER_FAILURE_ACTION";

export const FETCH_LOGOUT_REQUEST_ACTION = "FETCH_LOGOUT_REQUEST_ACTION";

export const CLEAR_LOGIN_REQUEST_ACTION = "CLEAR_LOGIN_REQUEST_ACTION";

export const fetchLoginAction =
    (email, password, type) => async (dispatch, getState) => {
        dispatch({ type: FETCH_LOGIN_REQUEST_ACTION });

        try {
            const response = await post(API_URLS.LOGIN, {
                email: email,
                password,
            });

            if (!utils.isJsonString(response.data)) {
                dispatch({
                    type: FETCH_LOGIN_FAILURE_ACTION,
                    payload: strings.notValidJson,
                });

                return;
            }

            if (response.data._result === "1") {
                utils.setLSVariable("user", JSON.stringify(response.data.user));

                dispatch({
                    type: FETCH_LOGIN_SUCCESS_ACTION,
                    payload: {
                        user: localStorage.getItem("user"),
                    },
                });
            } else {
                handleError(response.data, dispatch);
                dispatch({
                    type: FETCH_LOGIN_FAILURE_ACTION,
                    payload: response.data._error,
                });
            }
        } catch (error) {
            console.log(error);
            dispatch({
                type: FETCH_LOGIN_FAILURE_ACTION,
                payload: error.message,
            });
        }
    };

export const fetchAuthUserAction = () => async (dispatch, getState) => {
    dispatch({ type: FETCH_AUTH_USER_REQUEST_ACTION });

    try {
        const response = await post(API_URLS.FETCH_AUTH_USER);

        if (!utils.isJsonString(response.data)) {
            dispatch({
                type: FETCH_AUTH_USER_FAILURE_ACTION,
            });

            return;
        }

        if (response.data._result === "1") {
            utils.setLSVariable("user", JSON.stringify(response.data.user));

            dispatch({
                type: FETCH_AUTH_USER_SUCCESS_ACTION,
                payload: {
                    user: localStorage.getItem("user"),
                },
            });
        } else {
            dispatch({
                type: FETCH_AUTH_USER_FAILURE_ACTION,
            });
        }
    } catch (error) {
        console.log(error);
        dispatch({
            type: FETCH_AUTH_USER_FAILURE_ACTION,
        });
    }
};

export const fetchLogoutAction = () => async (dispatch, getState) => {
    try {
        utils.clearLS();

        await post(API_URLS.LOGOUT);
    } catch (error) {
        console.log(error);
    }

    dispatch({
        type: FETCH_LOGOUT_REQUEST_ACTION,
    });
};

export const clearLogoutAction = () => async (dispatch, getState) => {
    try {
        utils.clearLS();
    } catch (error) {
        console.log(error);
    }

    dispatch({
        type: CLEAR_LOGIN_REQUEST_ACTION,
    });
};
