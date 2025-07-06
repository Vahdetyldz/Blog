// resources/js/test.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import Comments from './admin-panel-components/Comments';

ReactDOM.createRoot(document.getElementById('comments')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Comments />
        </BrowserRouter>
    </React.StrictMode>
);