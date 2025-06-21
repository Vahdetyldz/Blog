import React from 'react';
import ReactDOM from 'react-dom/client';
import CreateArticle from './admin-panel-components/CreateArticle';
import { BrowserRouter } from "react-router-dom";

ReactDOM.createRoot(document.getElementById('createArticle')).render(
    <React.StrictMode>
        <BrowserRouter>
            <CreateArticle />
        </BrowserRouter>
    </React.StrictMode>
);