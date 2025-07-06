import React, { useState, useEffect } from 'react';

const CategoryPanel = () => {
  const [categoryName, setCategoryName] = useState('');
  const [categories, setCategories] = useState([]);
  const [errors, setErrors] = useState([]);

  // Kategorileri yükle
  useEffect(() => {
    fetch('/api/categories') // Laravel'den JSON dönen bir API
      .then(res => res.json())
      .then(data => setCategories(data))
      .catch(err => console.error("Kategori verileri alınamadı", err));
  }, []);

  // Form gönderme
  const handleSubmit = (e) => {
    e.preventDefault();
    setErrors([]);

    fetch('/api/categories/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify({ name: categoryName }),
    })
      .then(res => {
        if (!res.ok) {
          return res.json().then(data => {
            if (data.errors) setErrors(Object.values(data.errors).flat());
            throw new Error('Kategori ekleme başarısız');
          });
        }
        return res.json();
      })
      .then(data => {
        setCategories([...categories, data]); // Yeni kategoriyi listeye ekle
        setCategoryName('');
      })
      .catch(err => console.error('Hata:', err.message));
  };

  return (
    <div>
      <div className="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 className="h3 mb-0 text-gray-800">Kategoriler</h1>
      <a href="" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
      className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle</a>
    </div>
    <div className="row">
      {/* Yeni kategori formu */}
      <div className="col-md-4">
        <div className="card shadow mb-4">
          <div className="card-header py-3">
            <h6 className="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
          </div>
          <div className="card-body">
            {errors.length > 0 && (
              <div className="alert alert-danger">
                {errors.map((error, idx) => <div key={idx}>{error}</div>)}
              </div>
            )}
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label>Kategori Adı</label>
                <input
                  type="text"
                  className="form-control"
                  name="category"
                  value={categoryName}
                  onChange={(e) => setCategoryName(e.target.value)}
                  required
                />
              </div>
              <div className="form-group mt-3">
                <button type="submit" className="btn btn-primary btn-block">Ekle</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      {/* Kategori listesi */}
      <div className="col-md-4">
        <div className="card shadow mb-8">
          <div className="card-header py-3">
            <h6 className="m-0 font-weight-bold text-primary">Kategori Listesi</h6>
          </div>
          <div className="card-body">
            <div className="table-responsive">
              <table className="table table-bordered" width="100%" cellSpacing="0">
                <thead>
                  <tr>
                    <th>Kategori Adı</th>
                    <th>Makale Sayısı</th>
                  </tr>
                </thead>
                <tbody>
                  {categories.map((category) => (
                    <tr key={category.id}>
                      <td>{category.name}</td>
                      <td>{category.blogs_count || 0}</td>
                    </tr>
                  ))}
                  {categories.length === 0 && (
                    <tr>
                      <td colSpan="2">Kategori bulunamadı.</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    
  );
};

export default CategoryPanel;
