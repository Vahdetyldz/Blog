import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import Footer from './Footer';
import Content from './Content';

function AllBlogs() {
    return (
        <div id="wrapper">
            <Sidebar />
            <div id="content-wrapper" className="d-flex flex-column">
                <div id="content">
                    <Topbar />
                    <div className="container-fluid">
                        <Content />
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
}

export default AllBlogs;