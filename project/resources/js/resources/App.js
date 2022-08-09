import React from "react";
import { createRoot } from "react-dom/client";
import { Provider } from "react-redux";

import store from "../state/store";
import { AuthRoute } from "./navigation";

function App() {
    return (
        <Provider store={store}>
            <AuthRoute />
        </Provider>
    );
}

export default App;

const container = document.getElementById("root");
const root = createRoot(container);

root.render(<App />);
