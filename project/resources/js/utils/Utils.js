var CryptoJS = require("crypto-js");

function isValidEmail(value) {
    const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(String(value).toLowerCase());
}

function validateEmail(value, setEmailError) {
    if (value === "" || isValidEmail(value)) setEmailError("");
    else setEmailError("Invalid Email");
}

function validatePassword(value, setPasswordError) {
    if (value.length < 9) setPasswordError("Password must be 9 characters");
    else setPasswordError("");
}

function isJsonString(str) {
    try {
        str = JSON.stringify(str);
        str = str
            .replace(/\\n/g, "\\n")
            .replace(/\\'/g, "\\'")
            .replace(/\\"/g, '\\"')
            .replace(/\\&/g, "\\&")
            .replace(/\\r/g, "\\r")
            .replace(/\\t/g, "\\t")
            .replace(/\\b/g, "\\b")
            .replace(/\\f/g, "\\f");
        str = str.replace(/[\u0000-\u0019]+/g, "");
        JSON.parse(str);
    } catch (e) {
        console.log(error);
        return false;
    }
    return true;
}

function clearLS() {
    localStorage.removeItem("email");
    localStorage.removeItem("user");
}

//get localStorage variable
const getLSVariable = (key) => {
    try {
        const text = localStorage.getItem(key);

        if (!text) return null;

        const bytes = CryptoJS.AES.decrypt(text, "api_resource");
        const value = bytes.toString(CryptoJS.enc.Utf8);

        return value;
    } catch (error) {
        console.log(error);
        return null;
    }
};

const setLSVariable = (key, value) => {
    try {
        const text = CryptoJS.AES.encrypt(value, "api_resource").toString();

        localStorage.setItem(key, text);
    } catch (error) {
        console.log(error);
    }
};

const getLSUser = () => {
    let user = getLSVariable("user");

    if (!user) {
        clearLS();

        return null;
    }

    try {
        user = JSON.parse(user);
    } catch {
        console.log(error);
        clearLS();

        return null;
    }

    return user;
};

const addCommas = (num) =>
    num?.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

const removeNonNumeric = (num) => num?.toString().replace(/[^0-9]/g, "");

const digitInputChange = (setValue, field, event) => {
    setValue(field, addCommas(removeNonNumeric(event.target.value)));
};

const utils = {
    isValidEmail,
    validateEmail,
    validatePassword,
    isJsonString,
    getLSVariable,
    setLSVariable,
    getLSUser,
    clearLS,
    digitInputChange,
    addCommas,
    removeNonNumeric,
};

export default utils;
