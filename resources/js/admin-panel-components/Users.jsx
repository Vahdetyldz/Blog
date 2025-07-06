import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import UsersTabel from './UserTable';
import Footer from './Footer';

function Users() {
  return (
    <div id="wrapper">
      <Sidebar />
      <div id="content-wrapper" className="d-flex flex-column">
        <div id="content">
          <Topbar />
          <div className="container-fluid">
            <UsersTabel />
          </div>
        </div>
        <Footer />
      </div>
    </div>
  );
}

export default Users;