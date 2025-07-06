import React, { useEffect, useState } from 'react';

function Dashboard() {
  const [stats, setStats] = useState({
    userCount: 0,
    blogCount: 0,
    categoryCount: 0,
    commentCount: 0,
  });

  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch('/api/dashboard-stats')
      .then(res => res.json())
      .then(data => {
        setStats(data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Dashboard verileri alınamadı:', err);
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Yükleniyor...</div>;

  return (
    <div id="wrapper">
      <div id="content-wrapper" className="d-flex flex-column">
        <div id="content">
          <div className="container-fluid">
            <div className="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 className="h3 mb-0 text-gray-800">Kontrol Paneli</h1>
              <a href="/" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle
              </a>
            </div>

            <div className="row">
              
            </div>

            {/* Diğer dashboard içeriğin buraya gelecek */}
          </div>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;
