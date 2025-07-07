import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import Footer from './Footer';
import Dashboard from './Dashboard';
import LogoutModal from './LogoutModal';

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
                <LogoutModal onLogout={() => console.log('Çıkış yapıldı')} />
                <Footer />
            </div>
        </div>
    );
}

export default AdminDashboard;

