import React from 'react';
import ReactDOM from 'react-dom/client';
import Register from './register-page-components/Register';
import { BrowserRouter } from 'react-router-dom';


ReactDOM.createRoot(document.getElementById('register')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Register />
        </BrowserRouter>
    </React.StrictMode>
);