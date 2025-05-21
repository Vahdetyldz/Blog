import React from 'react';
import ReactDOM from 'react-dom/client';
import MyComponent from './MyComponent';

ReactDOM.createRoot(document.getElementById('app')).render(
    <React.StrictMode>
        <MyComponent />
    </React.StrictMode>
);