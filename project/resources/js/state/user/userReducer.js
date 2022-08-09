import utils from "../../utils/Utils";
import * as userActions from "./userActions";

const primaryState = {
    isAuthenticated: false,
    user: null,
    loading: false,
    error: null,
};

const initialState = {
    isAuthenticated: !!utils.getLSUser(),
    user: utils.getLSUser() ? localStorage.getItem("user") : null,
    loading: false,
    error: null,
};

const userReducer = (state = initialState, { type, payload }) => {
    switch (type) {
        case userActions.FETCH_LOGIN_REQUEST_ACTION:
            return { ...state, loading: true, error: null };
        case userActions.FETCH_LOGIN_SUCCESS_ACTION:
            return {
                ...state,
                isAuthenticated: true,
                user: payload.user,
                loading: false,
                error: null,
            };
        case userActions.FETCH_LOGIN_FAILURE_ACTION:
            return {
                ...state,
                isAuthenticated: false,
                loading: false,
                error: payload,
            };
        case userActions.FETCH_AUTH_USER_REQUEST_ACTION:
            return { ...state, loading: true, error: null };
        case userActions.FETCH_AUTH_USER_SUCCESS_ACTION:
            return {
                ...state,
                isAuthenticated: true,
                user: payload.user,
                loading: false,
                error: null,
            };
        case userActions.FETCH_AUTH_USER_FAILURE_ACTION:
            return {
                ...state,
                isAuthenticated: true,
                loading: false,
                error: null,
            };
        case userActions.FETCH_LOGOUT_REQUEST_ACTION:
            return { ...primaryState };
        case userActions.CLEAR_LOGIN_REQUEST_ACTION:
            return { ...primaryState };
        default:
            return state;
    }
};

export default userReducer;
