// resources/js/test-components/TestApp.jsx
import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import Footer from './Footer';
import Dashboard from './Dashboard';

function AdminDashboard() {
    return (
        <div id="wrapper">
            <Sidebar />
            <div id="content-wrapper" className="d-flex flex-column">
                <div id="content">
                    <Topbar />
                    <div className="container-fluid">
                        <Dashboard />
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
}

export default AdminDashboard;

