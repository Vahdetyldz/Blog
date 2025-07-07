import React, { useState, useEffect, useRef } from 'react'; 

const ArticleForm = ({ title = "Yeni Yazı", initialData = null, onSubmit, isEdit = false, blogId = null }) => {
  const [categories, setCategories] = useState([]);
  const [formData, setFormData] = useState({
    title: '',
    subtitle: '',
    category_id: '',
    image: null,
    content: '',
  });
  const [previewImage, setPreviewImage] = useState(null); 
  const [errors, setErrors] = useState([]);
  const [loading, setLoading] = useState(false);
  const summernoteRef = useRef(null);

  useEffect(() => {
    if (initialData) {
      setFormData({
        title: initialData.title || '',
        subtitle: initialData.subtitle || '',
        category_id: initialData.category_id || '',
        image: null, // Güncellemede dosya input boş başlatılır, yeni dosya seçilmezse eski resim upload edilmez
        content: initialData.content || '',
      });
      setPreviewImage(initialData.image_url || null); // Mevcut resmi göster
    }
  }, [initialData]);

  useEffect(() => {
    if (summernoteRef.current && formData.content) {
      const currentContent = $(summernoteRef.current).summernote('code');
      // İçerik farklıysa güncelle
      if (currentContent !== formData.content) {
        $(summernoteRef.current).summernote('code', formData.content);
      }
    }
  }, [formData.content]);

  useEffect(() => {
    fetch("/api/categories")
      .then(res => res.json())
      .then(data => setCategories(data))
      .catch(err => console.error("Kategori verisi alınamadı", err));
  }, []);

  useEffect(() => {
    if (summernoteRef.current) {
      $(summernoteRef.current).summernote({
        height: 300,
        callbacks: {
          onChange: (contents) => {
            setFormData(f => ({ ...f, content: contents }));
          },
        },
      });
      if (formData.content) {
        $(summernoteRef.current).summernote('code', formData.content);
      }
    }

    return () => {
      if (summernoteRef.current) {
        $(summernoteRef.current).summernote('destroy');
      }
    };
  }, []);

  const handleChange = (e) => {
    const { name, value, files } = e.target;
    if (name === 'image' && files && files[0]) {
      setFormData(prev => ({
        ...prev,
        image: files[0],
      }));
      setPreviewImage(URL.createObjectURL(files[0]));
    } else {
      setFormData(prev => ({
        ...prev,
        [name]: value,
      }));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    const validationErrors = [];
    if (!formData.title) validationErrors.push("Başlık boş bırakılamaz.");
    if (!formData.subtitle) validationErrors.push("Alt başlık boş bırakılamaz.");
    if (!formData.category_id) validationErrors.push("Kategori seçilmelidir.");
    if (!formData.content) validationErrors.push("İçerik girilmelidir.");

    if (validationErrors.length > 0) {
      setErrors(validationErrors);
      return;
    }

    setErrors([]);
    setLoading(true);

    const formDataToSend = new FormData();
    formDataToSend.append('title', formData.title);
    formDataToSend.append('subtitle', formData.subtitle);
    formDataToSend.append('category_id', formData.category_id);
    formDataToSend.append('content', formData.content);

    // Sadece yeni bir dosya seçildiyse dosyayı ekle
    if (formData.image && typeof formData.image !== 'string') {
      formDataToSend.append('image', formData.image);
    }

    // API URL ve method'u durumuna göre ayarla
    const url = isEdit && blogId ? `/api/articles/${blogId}` : '/api/articles';
    const method = 'POST'; // Laravel'de update için POST kullanıyorsan öyle bırak, PUT veya PATCH ise değiştir

    fetch(url, {
      method,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      },
      body: formDataToSend,
    })
      .then(res => {
        if (!res.ok) throw new Error('Kaydetme başarısız');
        return res.json();
      })
      .then(data => {
        console.log(isEdit ? 'Makale güncellendi:' : 'Makale kaydedildi:', data);

        // Kayıt veya güncelleme sonrası ilgili blog içeriği sayfasına yönlendir
        if (data && data.id) {
          window.location.href = `/blog-content/${data.id}`;
          return; // Yönlendirme sonrası devam etme
        }

        if (!isEdit) {
          // Yeni oluşturma sonrası formu temizle
          setFormData({ title: '', subtitle: '', category_id: '', image: null, content: '' });
          setPreviewImage(null);
          if (summernoteRef.current) {
            $(summernoteRef.current).summernote('code', '');
          }
        }
        // Güncellemede istersen formu olduğu gibi bırakabilirsin

        if (typeof onSubmit === 'function') {
          onSubmit(data); // opsiyonel callback
        }
      })
      .catch(err => {
        console.error('Hata:', err);
        setErrors(['Bir hata oluştu, lütfen tekrar deneyin.']);
      })
      .finally(() => setLoading(false));
  };

  return (
    <div className="container-fluid">
      <div className="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 className="h3 mb-0 text-gray-800">{title}</h1>
        <a href="/" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" rel="noreferrer">
          <i className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle
        </a>
      </div>

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
              <label>Alt Başlık</label>
              <input
                type="text"
                name="subtitle"
                className="form-control"
                required
                value={formData.subtitle}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label>Yazı Kategorisi</label>
              <select
                className="form-control"
                name="category_id"
                value={formData.category_id}
                onChange={handleChange}
                required
              >
                <option value="">Seçim Yapınız</option>
                {categories.map((cat) => (
                  <option key={cat.id} value={cat.id}>
                    {cat.name}
                  </option>
                ))}
              </select>
            </div>

            <div className="form-group">
              <label>Yazı Fotoğrafı</label>
              <input
                type="file"
                name="image"
                className="form-control"
                onChange={handleChange}
              />

              {previewImage ? (
                <div className="mt-2">
                  <small>Seçilen görsel:</small><br />
                  <img
                    src={previewImage}
                    alt="Önizleme"
                    style={{ maxWidth: '100%', maxHeight: 300 }}
                  />
                </div>
              ) : (
                initialData?.image_url && (
                  <div className="mt-2">
                    <small>Mevcut görsel:</small><br />
                    <img
                      src={initialData.image_url}
                      alt="Mevcut görsel"
                      style={{ maxWidth: '100%', maxHeight: 300 }}
                    />
                  </div>
                )
              )}
            </div>

            <div className="form-group">
              <label>Yazı İçeriği</label>
              <div ref={summernoteRef} id="editör"></div>
            </div>

            <div className="form-group">
              <button type="submit" className="btn btn-primary btn-block" disabled={loading}>
                {loading ? 'Kaydediliyor...' : 'Kaydet'}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default ArticleForm;
