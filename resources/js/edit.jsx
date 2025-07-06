import React from 'react';
import ReactDOM from 'react-dom/client';
import Edit from './edit-page-components/Edit';
import { BrowserRouter, Routes, Route } from 'react-router-dom';


ReactDOM.createRoot(document.getElementById('edit')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Routes>
                <Route path="/blogs/:id/edit" element={<Edit />} />
            </Routes>           
        </BrowserRouter>
    </React.StrictMode>
);