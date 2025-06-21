import React from 'react';
import ReactDOM from 'react-dom/client';
import MyBlogs from './my-blog-page-components/MyBlogs';
import { BrowserRouter } from 'react-router-dom';


ReactDOM.createRoot(document.getElementById('myBlogs')).render(
    <React.StrictMode>
        <BrowserRouter>
            <MyBlogs />
        </BrowserRouter>
    </React.StrictMode>
);