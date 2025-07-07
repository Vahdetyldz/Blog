import { useEffect, useState, useRef } from 'react';
import Chart from 'chart.js/auto';


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

  const [categories, setCategories] = useState([]);
  // Günlük istatistikler için state
  const [dailyStats, setDailyStats] = useState({ dates: [], userCounts: [], blogCounts: [] });
  const userChartRef = useRef(null);
  const blogChartRef = useRef(null);
  const userChartInstance = useRef(null);
  const blogChartInstance = useRef(null);

  useEffect(() => {
    fetch('/api/category-progress', {
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
      }
    })
      .then(res => res.json())
      .then(data => {
        setCategories(data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Kategori verileri alınamadı', err);
        setLoading(false);
      });
  }, []);

  // Günlük istatistikleri çek
  useEffect(() => {
    fetch('/api/daily-stats', {
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
      }
    })
      .then(res => res.json())
      .then(data => {
        console.log('Günlük istatistik API cevabı:', data);
        // Tüm tarihleri topla
        const allDatesSet = new Set();
        (data.blogs || []).forEach(item => allDatesSet.add(item.date));
        (data.users || []).forEach(item => allDatesSet.add(item.date));
        const allDates = Array.from(allDatesSet).sort();
        // Her tarih için user ve blog countlarını eşleştir
        const userCounts = allDates.map(date => {
          const found = (data.users || []).find(u => u.date === date);
          return found ? found.count : 0;
        });
        const blogCounts = allDates.map(date => {
          const found = (data.blogs || []).find(b => b.date === date);
          return found ? found.count : 0;
        });
        setDailyStats({ dates: allDates, userCounts, blogCounts });
      })
      .catch(err => console.error('Günlük istatistikler alınamadı', err));
  }, []);

  // Kullanıcı grafiği
  useEffect(() => {
    if (!userChartRef.current || !dailyStats || !Array.isArray(dailyStats.dates) || dailyStats.dates.length === 0) return;
    if (userChartInstance.current) userChartInstance.current.destroy();
    userChartInstance.current = new Chart(userChartRef.current, {
      type: 'line',
      data: {
        labels: dailyStats.dates,
        datasets: [
          {
            label: 'Günlük Kullanıcı Kayıtları',
            data: Array.isArray(dailyStats.userCounts) ? dailyStats.userCounts : [],
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            fill: true,
            tension: 0.4,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } },
      },
    });
  }, [dailyStats]);

  // Blog grafiği
  useEffect(() => {
    if (!blogChartRef.current || !dailyStats || !Array.isArray(dailyStats.dates) || dailyStats.dates.length === 0) return;
    if (blogChartInstance.current) blogChartInstance.current.destroy();
    blogChartInstance.current = new Chart(blogChartRef.current, {
      type: 'bar',
      data: {
        labels: dailyStats.dates,
        datasets: [
          {
            label: 'Günlük Blog İçerik Sayısı',
            data: Array.isArray(dailyStats.blogCounts) ? dailyStats.blogCounts : [],
            backgroundColor: 'rgba(28, 200, 138, 0.5)',
            borderColor: '#1cc88a',
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } },
      },
    });
  }, [dailyStats]);

  // Her kategoriye farklı renkler için renk dizisi
  const barColors = [
    "#4e73df", // mavi
    "#1cc88a", // yeşil
    "#36b9cc", // turkuaz
    "#f6c23e", // sarı
    "#e74a3b", // kırmızı
    "#858796", // gri
    "#fd7e14", // turuncu
    "#20c997", // açık yeşil
    "#6f42c1", // mor
    "#17a2b8", // mavi-yeşil
  ];

  const getBarColor = (percentage) => {
    if (percentage < 25) return 'bg-danger';
    if (percentage < 50) return 'bg-warning';
    if (percentage < 75) return 'bg-info';
    return 'bg-success';
  };

  if (loading) return <div>Yükleniyor...</div>;
    return (
        <div id="wrapper">

        {/* Content Wrapper */}
        <div id="content-wrapper" className="d-flex flex-column">

            {/* Main Content */}
            <div id="content">

                <div className="container-fluid">

                    {/* Page Heading */}
                    <div className="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 className="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="/" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle</a>
                    </div>

                    {/* Content Row */}
                    <div className="row">
                        {/* Kullanıcı Sayısı */}
              <div className="col-xl-3 col-md-6 mb-4">
                <div className="card border-left-primary shadow h-100 py-2">
                  <div className="card-body">
                    <div className="row no-gutters align-items-center">
                      <div className="col mr-2">
                        <div className="text-xs font-weight-bold text-primary text-uppercase mb-1">Kullanıcı Sayısı</div>
                        <div className="h5 mb-0 font-weight-bold text-gray-800">{stats.userCount}</div>
                      </div>
                      <div className="col-auto">
                        <i className="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Blog Sayısı */}
              <div className="col-xl-3 col-md-6 mb-4">
                <div className="card border-left-success shadow h-100 py-2">
                  <div className="card-body">
                    <div className="row no-gutters align-items-center">
                      <div className="col mr-2">
                        <div className="text-xs font-weight-bold text-success text-uppercase mb-1">Blog Sayısı</div>
                        <div className="h5 mb-0 font-weight-bold text-gray-800">{stats.blogCount}</div>
                      </div>
                      <div className="col-auto">
                        <i className="fas fa-newspaper fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Kategori Sayısı */}
              <div className="col-xl-3 col-md-6 mb-4">
                <div className="card border-left-info shadow h-100 py-2">
                  <div className="card-body">
                    <div className="row no-gutters align-items-center">
                      <div className="col mr-2">
                        <div className="text-xs font-weight-bold text-info text-uppercase mb-1">Kategori Sayısı</div>
                        <div className="h5 mb-0 font-weight-bold text-gray-800">{stats.categoryCount}</div>
                      </div>
                      <div className="col-auto">
                        <i className="fas fa-list fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Yorum Sayısı */}
              <div className="col-xl-3 col-md-6 mb-4">
                <div className="card border-left-warning shadow h-100 py-2">
                  <div className="card-body">
                    <div className="row no-gutters align-items-center">
                      <div className="col mr-2">
                        <div className="text-xs font-weight-bold text-warning text-uppercase mb-1">Yorum Sayısı</div>
                        <div className="h5 mb-0 font-weight-bold text-gray-800">{stats.commentCount}</div>
                      </div>
                      <div className="col-auto">
                        <i className="fas fa-comments fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                        
                    </div>

                    {/* Grafikler Row */}
                    <div className="row">
                      {/* Günlük Kayıt Grafiği */}
                      <div className="col-12 mb-4">
                        <div className="card shadow mb-4">
                          <div className="card-header py-3">
                            <h6 className="m-0 font-weight-bold text-primary">Günlük Kayıt Grafiği</h6>
                          </div>
                          <div className="card-body">
                            <canvas ref={userChartRef} height="100"></canvas>
                          </div>
                        </div>
                      </div>
                      {/* İçerik Grafiği */}
                      <div className="col-12 mb-4">
                        <div className="card shadow mb-4">
                          <div className="card-header py-3">
                            <h6 className="m-0 font-weight-bold text-success">İçerik Grafiği</h6>
                          </div>
                          <div className="card-body">
                            <canvas ref={blogChartRef} height="100"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* Kategori Dağılımı */}
                    <div className="row">
                      <div className="col-12 mb-4">
                        <div className="card shadow mb-4">
                          <div className="card-header py-3">
                            <h6 className="m-0 font-weight-bold text-primary">Kategori Dağılımı</h6>
                          </div>
                          <div className="card-body">
                            {categories.length === 0 && <p>Hiç kategori bulunamadı.</p>}
                            {categories.map((cat, index) => (
                              <div key={index} className="mb-3">
                                <div className="d-flex align-items-center mb-1">
                                  <span style={{ minWidth: 120 }}>{cat.name}</span>
                                  <span className="ml-auto" style={{ fontWeight: 600, minWidth: 40, textAlign: 'right' }}>{cat.percentage}%</span>
                                </div>
                                <div className="progress" style={{height: '22px'}}>
                                  <div
                                    className="progress-bar"
                                    role="progressbar"
                                    style={{
                                      width: `${cat.percentage}%`,
                                      backgroundColor: barColors[index % barColors.length],
                                      fontWeight: 600,
                                      fontSize: '15px',
                                    }}
                                    aria-valuenow={cat.percentage}
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                  ></div>
                                </div>
                              </div>
                            ))}
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* /.container-fluid */}
                </div>
            </div>
            {/* End of Main Content */}



        </div>
        {/* End of Content Wrapper */}

    </div>
    );
}

export default Dashboard;