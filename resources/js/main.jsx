import React from 'react';
import ReactDOM from 'react-dom/client';
import Main from './blog-page-components/Main';
import { BrowserRouter } from 'react-router-dom';


ReactDOM.createRoot(document.getElementById('main')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Main />
        </BrowserRouter>
    </React.StrictMode>
);