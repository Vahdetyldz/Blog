import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import Footer from './Footer';
import Category from './Category';

function CategoryPanel() {
    return (
        <div id="wrapper">
            <Sidebar />
            <div id="content-wrapper" className="d-flex flex-column">
                <div id="content">
                    <Topbar />
                    <div className="container-fluid">
                        <Category />
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
}

export default CategoryPanel;