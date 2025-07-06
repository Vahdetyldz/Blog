import React from 'react';
import ReactDOM from 'react-dom/client';
import Users from './admin-panel-components/Users';
import { BrowserRouter } from "react-router-dom";

ReactDOM.createRoot(document.getElementById('users')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Users />
        </BrowserRouter>
    </React.StrictMode>
);