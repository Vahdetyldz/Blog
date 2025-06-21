// resources/js/test.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
//import TestApp from './admin-panel-components/AdminDashboard'; // Yeni bir bileşen oluşturacaksınız
import { BrowserRouter } from 'react-router-dom';
import AdminDashboard from './admin-panel-components/AdminDashboard';

ReactDOM.createRoot(document.getElementById('adminDashboard')).render(
    <React.StrictMode>
        <BrowserRouter>
            <AdminDashboard />
        </BrowserRouter>
    </React.StrictMode>
);