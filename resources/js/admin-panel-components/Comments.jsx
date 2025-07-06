import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import Footer from './Footer';
import CommentTable from './CommentTable';

function Comments() {
    return (
        <div id="wrapper">
            <Sidebar />
            <div id="content-wrapper" className="d-flex flex-column">
                <div id="content">
                    <Topbar />
                    <div className="container-fluid">
                        <CommentTable />
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
}

export default Comments;