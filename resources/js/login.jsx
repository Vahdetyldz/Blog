import React from 'react';
import ReactDOM from 'react-dom/client';
import Login from './login-page-components/Login';
import { BrowserRouter } from 'react-router-dom';


ReactDOM.createRoot(document.getElementById('login')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Login />
        </BrowserRouter>
    </React.StrictMode>
);