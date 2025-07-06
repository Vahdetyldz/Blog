import React, { useEffect, useState } from 'react';
import ArticleForm from '../admin-panel-components/ArticleForm';
import { useParams } from 'react-router-dom';

function Edit() {
  const { id } = useParams();
  const [initialData, setInitialData] = useState(null);
  const [categories, setCategories] = useState([]);

  useEffect(() => {
    fetch(`/api/blogs/${id}`)
    .then(res => res.json())
    .then(data => {
      console.log('Blog verisi:', data); // Kontrol için
      setInitialData(data);
    });

    fetch('/api/categories')
      .then(res => res.json())
      .then(data => setCategories(data));
  }, [id]);

  const handleUpdate = (updatedFormData) => {
    const formData = new FormData();
    formData.append('title', updatedFormData.title);
    formData.append('subtitle', updatedFormData.subtitle);
    formData.append('category_id', updatedFormData.category_id);
    formData.append('content', updatedFormData.content);

    if (updatedFormData.image) {
      formData.append('image', updatedFormData.image);
    }

    fetch(`/api/blogs/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData
    })
      .then(res => res.json())
      .then(() => window.location.href = '/myblogs')
      .catch(err => console.error('Güncelleme Hatası:', err));
  };

  if (!initialData) return <div>Yükleniyor...</div>;

  return (
    <ArticleForm
      title="Yazıyı Güncelle"
      categories={categories}
      initialData={initialData}
      onSubmit={handleUpdate}
      isEdit={true}
      blogId={id}
    />
  );
}

export default Edit;
