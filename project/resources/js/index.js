require("./resources/App");

import axios from "axios";

axios.defaults.withCredentials = true;

document.addEventListener("DOMContentLoaded", function (event) {
    axios.get("/sanctum/csrf-cookie");
});
