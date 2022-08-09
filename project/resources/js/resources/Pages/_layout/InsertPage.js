import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";

import {
    setPageAction,
    setLoadingAction,
} from "../../../state/layout/layoutActions";
import {
    setMessageAction,
    setRenderMessageAction,
    clearMessageAction,
} from "../../../state/message/messageActions";
import { clearLogoutAction } from "../../../state/user/userActions";
import { AlertMessage, AlertState } from "../../components";
import utils from "../../../utils/Utils";
import { basePath, MESSAGE_CODES, MESSAGE_TYPES } from "../../../constants";

const InsertPage = ({ children, page, errors = null }) => {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    let messageState = useSelector((state) => state.messageReducer);
    const [globalMessage, setGlobalMessage] = useState(null);

    useEffect(() => {
        if (messageState?.messageCode === MESSAGE_CODES.USER_NOT_AUTHORIZED) {
            dispatch(clearLogoutAction());
            navigate(`${basePath}/users/login`);
        }
    }, [messageState]);

    useEffect(() => {
        if (typeof errors === "object" && errors) {
            const hasKeys = !!Object.keys(errors).length;

            if (hasKeys) {
                dispatch(
                    setMessageAction(
                        errors[Object.keys(errors)[0]].message,
                        MESSAGE_TYPES.ERROR,
                        MESSAGE_CODES.FORM_INPUT_INVALID,
                        true,
                        Object.keys(errors)[0]
                    )
                );
            }
        }
    }, [errors]);

    useEffect(() => {
        window.scrollTo(0, 0);

        if (!utils.getLSUser()) {
            dispatch(clearLogoutAction());
            navigate(`${basePath}/users/login`);

            return;
        }

        dispatch(setPageAction(page));
        dispatch(setRenderMessageAction());
        dispatch(setLoadingAction(false));

        if (messageState?.messageField || messageState?.messageRender) {
            dispatch(clearMessageAction());
        }

        let gMessage = localStorage.getItem("globalMessage");

        if (gMessage) {
            try {
                setGlobalMessage(JSON.parse(gMessage));
            } catch {
                console.log(error);
            }
            localStorage.removeItem("globalMessage");
        }
    }, []);

    return (
        <div className="body flex-grow-1 px-3">
            <div className="container-lg">
                {globalMessage && (
                    <AlertMessage
                        message={globalMessage?.message}
                        messageType={
                            globalMessage?.type === 0
                                ? MESSAGE_TYPES.ERROR
                                : MESSAGE_TYPES.SUCCESS
                        }
                    />
                )}
                <AlertState />
                {children}
            </div>
        </div>
    );
};

export default InsertPage;
