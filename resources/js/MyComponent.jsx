import React, { useState, useEffect, useRef } from 'react';

export default function MyComponent() {
  // State'ler
  const [title, setTitle] = useState('');
  const [category, setCategory] = useState('');
  const [image, setImage] = useState(null);
  const [content, setContent] = useState('');

  // Summernote editörünü kullanabilmek için ref
  const editorRef = useRef(null);

  useEffect(() => {
    // jQuery ve Summernote'nin sayfa yüklendiğinde çalışması için
    if (window.$ && window.$.fn.summernote) {
      window.$(editorRef.current).summernote({
        height: 300,
        callbacks: {
          onChange: (contents) => {
            setContent(contents);
          },
        },
      });
    }

    // Cleanup: component unmount olduğunda Summernote'yi kaldır
    return () => {
      if (window.$ && window.$.fn.summernote) {
        window.$(editorRef.current).summernote('destroy');
      }
    };
  }, []);

  // Form submit handler
  const handleSubmit = (e) => {
    e.preventDefault();

    // Burada form verisini Laravel backend'e gönderebilirsin.
    // Örneğin fetch ile veya axios ile POST isteği atabilirsin.

    // Örnek alert:
    alert('Form gönderildi!\n' + `Başlık: ${title}\nKategori: ${category}\nİçerik uzunluğu: ${content.length}`);
  };

  return (
    <div className="container-fluid">
      <div className="card shadow mb-4">
        <div className="card-header py-3">
          <h6 className="m-0 font-weight-bold text-primary">Yazı Oluştur</h6>
        </div>
        <div className="card-body">
          <form onSubmit={handleSubmit} encType="multipart/form-data">
            <div className="form-group">
              <label htmlFor="title">Yazı Başlığı</label>
              <input
                type="text"
                id="title"
                name="title"
                className="form-control"
                required
                value={title}
                onChange={(e) => setTitle(e.target.value)}
              />
            </div>

            <div className="form-group">
              <label htmlFor="category">Yazı Kategorisi</label>
              <select
                id="category"
                name="category"
                className="form-control"
                required
                value={category}
                onChange={(e) => setCategory(e.target.value)}
              >
                <option value="">Seçim Yapınız</option>
                {/* Kategoriler dinamik ise buraya map ile eklenebilir */}
                <option value="kategori1">Kategori 1</option>
                <option value="kategori2">Kategori 2</option>
              </select>
            </div>

            <div className="form-group">
              <label htmlFor="image">Yazı Fotoğrafı</label>
              <input
                type="file"
                id="image"
                name="image"
                className="form-control"
                required
                onChange={(e) => setImage(e.target.files[0])}
              />
            </div>

            <div className="form-group">
              <label htmlFor="editor">Yazı İçeriği</label>
              {/* Summernote textarea */}
              <textarea
                id="editor"
                name="content"
                className="form-control"
                rows="4"
                required
                ref={editorRef}
              />
            </div>

            <div className="form-group">
              <button type="submit" className="btn btn-primary btn-block">
                Yazıyı Oluştur
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}
