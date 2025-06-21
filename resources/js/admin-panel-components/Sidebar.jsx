import React from 'react';

function Sidebar() {
  // Aktif link durumunu React Router veya state ile yönetebilirsiniz.
  // Şimdilik statik yapıldı.

  return (
    <ul className="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a className="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div className="sidebar-brand-text">Blog Sitesi Admin</div>
      </a>
      <hr className="sidebar-divider my-0" />
      <li className="nav-item active">
        <a className="nav-link" href="dashboard">
          <i className="fas fa-fw fa-tachometer-alt"></i>
          <span>Panel</span>
        </a>
      </li>
      <hr className="sidebar-divider" />
      <div className="sidebar-heading">İçerik Yönetimi</div>
      <li className="nav-item">
        <a
          className="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseTwo"
          aria-expanded="true"
          aria-controls="collapseTwo"
        >
          <i className="fas fa-fw fa-edit"></i>
          <span>Yazılar</span>
        </a>
        <div className="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div className="bg-white py-2 collapse-inner rounded">
            <h6 className="collapse-header">Yazı İşlemleri:</h6>
            <a className="collapse-item" href="/yazilar">
              Tüm Yazılar
            </a>
            <a className="collapse-item" href="/yazilar/create">
              Yazı Oluştur
            </a>
          </div>
        </div>
      </li>
      <li className="nav-item">
        <a className="nav-link" href="/kategoriler">
          <i className="fas fa-fw fa-list"></i>
          <span>Kategoriler</span>
        </a>
      </li>
      <li className="nav-item">
        <a
          className="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapsePage"
          aria-expanded="true"
          aria-controls="collapsePage"
        >
          <i className="fas fa-fw fa-folder"></i>
          <span>Sayfalar</span>
        </a>
        <div className="collapse" id="collapsePage" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div className="bg-white py-2 collapse-inner rounded">
            <h6 className="collapse-header">Sayfa İşlemleri:</h6>
            <a className="collapse-item" href="/sayfalar">
              Tüm Sayfalar
            </a>
            <a className="collapse-item" href="/sayfalar/create">
              Sayfa Oluştur
            </a>
          </div>
        </div>
      </li>
      <hr className="sidebar-divider" />
      <div className="text-center d-none d-md-inline">
        <button className="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
  );
}

export default Sidebar;
