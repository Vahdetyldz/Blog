import React, { useEffect, useState } from 'react';

const Content = () => {
  const apiUrl = '/web/blogs';
  const [blogs, setBlogs] = useState([]);
  const [pagination, setPagination] = useState({});
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [perPage, setPerPage] = useState(10); // Sayfa başına blog sayısı
  const [totalBlogs, setTotalBlogs] = useState(0); // Toplam blog sayısı için yeni state

  // currentUser artık window.currentUser'dan dinamik alınacak
  const currentUser = typeof window !== 'undefined' && window.currentUser ? window.currentUser : null;

  useEffect(() => {
    setLoading(true);
    fetch(`${apiUrl}?page=${currentPage}&per_page=${perPage}`)
      .then(res => res.json())
      .then(data => {
        setBlogs(data.data || data);
        setPagination({
          current: data.current_page,
          last: data.last_page,
          next: data.next_page_url,
          prev: data.prev_page_url
        });
        setTotalBlogs(data.total || (data.data ? data.data.length : data.length)); // Toplam blog sayısını ayarla
        setLoading(false);
      })
      .catch(err => {
        console.error("Veri alınamadı", err);
        setLoading(false);
      });
  }, [apiUrl, currentPage, perPage]);

  const handleDelete = async (id) => {
    if (!window.confirm("Bu blogu silmek istediğinizden emin misin?")) return;

    try {
      const response = await fetch(`/blogs/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        credentials: 'same-origin'
      });

      if (response.ok) {
        setBlogs(prev => prev.filter(blog => blog.id !== id));
      } else {
        alert("Silme işlemi başarısız oldu.");
      }
    } catch (err) {
      alert("Bir hata oluştu.");
    }
  };

  if (loading) return <div>Yükleniyor...</div>;

  return (
    <div>
      <div className="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 className="h3 mb-0 text-gray-800">Tüm Yazılar</h1>
        <a href="" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle</a>
      </div>

      <div className="card shadow mb-4">
        <div className="card-header py-3">
          <h6 className="m-0 font-weight-bold text-primary">
            <strong>{totalBlogs}</strong> blog bulundu.
          </h6>
        </div>
        <div className="card-body">
          <div className="table-responsive">
            <table className="table table-bordered" width="100%" cellSpacing="0">
              <thead>
                <tr>
                  <th>Fotoğraf</th>
                  <th>Başlık</th>
                  <th>Kullanıcı</th>
                  <th>Kategori</th>
                  <th>Oluşturulma Tarihi</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                {blogs.map(blog => (
                  <tr key={blog.id}>
                    <td>
                      <img src={`/storage/${blog.image}`} width="200" alt="Blog" />
                    </td>
                    <td>{blog.title}</td>
                    <td>{blog.user?.name} {blog.user?.surname}</td>
                    <td>{blog.category?.name || 'Kategori Yok'}</td>
                    <td>{new Date(blog.created_at).toLocaleDateString('tr-TR')}</td>
                    <td>
                      <a
                        href={`/blog-content/${blog.id}`}
                        target="_blank"
                        className="btn btn-sm btn-success"
                        title="Görüntüle"
                        rel="noreferrer"
                      >
                        <i className="fa fa-eye"></i>
                      </a>
                      {currentUser && currentUser.role === "admin" && blog.user_id === currentUser.id && (
                        <a
                          href={`/blogs/${blog.id}/edit`}
                          className="btn btn-sm btn-primary mx-1"
                          title="Düzenle"
                        >
                          <i className="fa fa-pen"></i>
                        </a>
                      )}
                      <button
                        onClick={() => handleDelete(blog.id)}
                        className="btn btn-sm btn-danger"
                        title="Sil"
                      >
                        <i className="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                ))}
                {blogs.length === 0 && (
                  <tr>
                    <td colSpan="6">Hiç blog bulunamadı.</td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
          {pagination.last > 1 && (
            <div className="d-flex justify-content-between mt-3" style={{ gap: "10px" }}>
              <button
                className="btn btn-primary"
                style={{ opacity: pagination.current === 1 ? 0.6 : 1, cursor: pagination.current === 1 ? "not-allowed" : "pointer" }}
                onClick={() => setCurrentPage(p => Math.max(1, p - 1))}
                disabled={pagination.current === 1}
              >
                <i className="fas fa-arrow-left"></i> Önceki
              </button>
              <button
                className="btn btn-success"
                style={{ opacity: pagination.current === pagination.last ? 0.6 : 1, cursor: pagination.current === pagination.last ? "not-allowed" : "pointer" }}
                onClick={() => setCurrentPage(p => p + 1)}
                disabled={pagination.current === pagination.last}
              >
                Sonraki <i className="fas fa-arrow-right"></i>
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Content;
