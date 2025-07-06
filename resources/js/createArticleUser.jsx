import React from 'react';
import ReactDOM from 'react-dom/client';
import CreateArticleUser from './blog-page-components/CreateArticleUser';
import { BrowserRouter } from "react-router-dom";

ReactDOM.createRoot(document.getElementById('createArticleUser')).render(
    <React.StrictMode>
        <BrowserRouter>
            <CreateArticleUser />
        </BrowserRouter>
    </React.StrictMode>
);