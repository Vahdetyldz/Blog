import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import Content from './blog-page-components/Content';

ReactDOM.createRoot(document.getElementById('chatbot')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Content />
        </BrowserRouter>
    </React.StrictMode>
);