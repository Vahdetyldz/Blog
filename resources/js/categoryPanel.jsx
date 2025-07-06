// resources/js/test.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import CategoryPanel from './admin-panel-components/CategoryPanel';

ReactDOM.createRoot(document.getElementById('categoryPanel')).render(
    <React.StrictMode>
        <BrowserRouter>
            <CategoryPanel />
        </BrowserRouter>
    </React.StrictMode>
);