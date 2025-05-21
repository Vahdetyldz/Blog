import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import ArticleForm from './ArticleForm';

const App = () => {
    return (
        <div className="flex">
            <Sidebar />
            <div className="flex-1">
                <Topbar />
                <ArticleForm />
            </div>
        </div>
    );
};

export default App;