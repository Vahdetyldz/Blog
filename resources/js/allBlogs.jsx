import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import AllBlogs from './admin-panel-components/AllBlogs';

ReactDOM.createRoot(document.getElementById('allBlogs')).render(
    <React.StrictMode>
        <BrowserRouter>
            <AllBlogs />
        </BrowserRouter>
    </React.StrictMode>
);