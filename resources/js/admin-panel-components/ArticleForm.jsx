import React, { useState } from 'react';

const PostForm = ({ title = "Yeni Yazı", categories = [], onSubmit }) => {
  const [formData, setFormData] = useState({
    title: '',
    category: '',
    image: null,
    content: '',
  });

  const [errors, setErrors] = useState([]);

  const handleChange = (e) => {
    const { name, value, files } = e.target;
    setFormData({
      ...formData,
      [name]: files ? files[0] : value,
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    // Örnek validasyon
    const validationErrors = [];
    if (!formData.title) validationErrors.push("Başlık boş bırakılamaz.");
    if (!formData.category) validationErrors.push("Kategori seçilmelidir.");
    if (!formData.image) validationErrors.push("Görsel seçilmelidir.");
    if (!formData.content) validationErrors.push("İçerik girilmelidir.");

    if (validationErrors.length > 0) {
      setErrors(validationErrors);
      return;
    }

    setErrors([]);
    if (onSubmit) {
      onSubmit(formData);
    }
  };

  return (
    <div className="container-fluid">
      {/* Page Heading */}
      <div className="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 className="h3 mb-0 text-gray-800">{title}</h1>
        <a href="/" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
          <i className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle
        </a>
      </div>

      {/* Form Card */}
      <div className="card shadow mb-4">
        <div className="card-header py-3">
          <h6 className="m-0 font-weight-bold text-primary">{title}</h6>
        </div>
        <div className="card-body">
          {errors.length > 0 && (
            <div className="alert alert-danger">
              {errors.map((error, index) => (
                <div key={index}>{error}</div>
              ))}
            </div>
          )}

          <form onSubmit={handleSubmit} encType="multipart/form-data">
            <div className="form-group">
              <label>Yazı Başlığı</label>
              <input
                type="text"
                name="title"
                className="form-control"
                required
                value={formData.title}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label>Yazı Kategorisi</label>
              <select
                className="form-control"
                name="category"
                value={formData.category}
                onChange={handleChange}
                required
              >
                <option value="">Seçim Yapınız</option>
                {categories.map((cat, index) => (
                  <option key={index} value={cat.value}>{cat.label}</option>
                ))}
              </select>
            </div>

            <div className="form-group">
              <label>Yazı Fotoğrafı</label>
              <input
                type="file"
                name="image"
                className="form-control"
                required
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label>Yazı İçeriği</label>
              <textarea
                id="editör"
                name="content"
                className="form-control"
                rows={4}
                required
                value={formData.content}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <button type="submit" className="btn btn-primary btn-block">Yazıyı Oluştur</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default PostForm;
