import React, { useState } from 'react';
import ReactQuill from 'react-quill';

const ArticleForm = () => {
    const [title, setTitle] = useState('');
    const [category, setCategory] = useState('');
    const [image, setImage] = useState(null);
    const [content, setContent] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('title', title);
        formData.append('category', category);
        formData.append('image', image);
        formData.append('content', content);

        // Laravel API'ye form gönderimi
        fetch('/api/articles', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                console.log('Başarılı:', data);
                alert('Yazı oluşturuldu!');
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Bir hata oluştu.');
            });
    };

    return (
        <div className="container mx-auto p-4">
            <div className="flex justify-between items-center mb-4">
                <h1 className="text-2xl font-semibold text-gray-800">Yazı Oluştur</h1>
                <a href="#" className="hidden sm:inline bg-blue-600 text-white px-4 py-2 rounded shadow">
                    <i className="fas fa-globe mr-2"></i> Siteyi Görüntüle
                </a>
            </div>
            <div className="bg-white shadow rounded p-6">
                <h6 className="text-lg font-semibold text-blue-600 mb-4">Yazı Oluştur</h6>
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label className="block text-gray-700 mb-2">Yazı Başlığı</label>
                        <input
                            type="text"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            className="w-full border rounded p-2"
                            required
                        />
                    </div>
                    <div className="mb-4">
                        <label className="block text-gray-700 mb-2">Yazı Kategorisi</label>
                        <select
                            value={category}
                            onChange={(e) => setCategory(e.target.value)}
                            className="w-full border rounded p-2"
                            required
                        >
                            <option value="">Seçim Yapınız</option>
                            {/* Kategoriler API'den çekilebilir */}
                        </select>
                    </div>
                    <div className="mb-4">
                        <label className="block text-gray-700 mb-2">Yazı Fotoğrafı</label>
                        <input
                            type="file"
                            onChange={(e) => setImage(e.target.files[0])}
                            className="w-full border rounded p-2"
                            required
                        />
                    </div>
                    <div className="mb-4">
                        <label className="block text-gray-700 mb-2">Yazı İçeriği</label>
                        <ReactQuill
                            value={content}
                            onChange={setContent}
                            className="h-64"
                        />
                    </div>
                    <div className="mt-12">
                        <button
                            type="submit"
                            className="w-full bg-blue-600 text-white py-2 rounded"
                        >
                            Yazıyı Oluştur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ArticleForm;