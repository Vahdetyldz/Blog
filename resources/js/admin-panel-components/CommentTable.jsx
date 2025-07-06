import React, { useEffect, useState } from 'react';

const CommentTable = () => {
  const apiUrl = '/web/comments';
  const [comments, setComments] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setLoading(true);
    fetch(apiUrl)
      .then(res => res.json())
      .then(data => {
        setComments(data.data || data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Yorumlar alınamadı', err);
        setLoading(false);
      });
  }, [apiUrl]);

  const handleDelete = async (id) => {
    if (!window.confirm('Bu yorumu silmek istediğinizden emin misiniz?')) return;
    try {
      const response = await fetch(`/comments/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        credentials: 'same-origin',
      });
      if (response.ok) {
        setComments(prev => prev.filter(comment => comment.id !== id));
      } else {
        alert('Silme işlemi başarısız oldu.');
      }
    } catch (err) {
      alert('Bir hata oluştu.');
    }
  };

  if (loading) return <div>Yükleniyor...</div>;

  return (
    <div className="card shadow mb-4">
      <div className="card-header py-3">
        <h6 className="m-0 font-weight-bold text-primary">
          <strong>{comments.length}</strong> yorum bulundu.
        </h6>
      </div>
      <div className="card-body">
        <div className="table-responsive">
          <table className="table table-bordered" width="100%" cellSpacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Kullanıcı</th>
                <th>Blog Başlığı</th>
                <th>Yorum</th>
                <th>Tarih</th>
                <th>Sil</th>
              </tr>
            </thead>
            <tbody>
              {comments.map(comment => (
                <tr key={comment.id}>
                  <td>{comment.id}</td>
                  <td>{comment.user ? `${comment.user.name} ${comment.user.surname}` : comment.user_id}</td>
                  <td>{comment.blog ? comment.blog.title : comment.blog_id}</td>
                  <td>{comment.comment}</td>
                  <td>{new Date(comment.created_at).toLocaleString('tr-TR')}</td>
                  <td>
                    <button className="btn btn-sm btn-danger" onClick={() => handleDelete(comment.id)}>
                      <i className="fa fa-times"></i>
                    </button>
                  </td>
                </tr>
              ))}
              {comments.length === 0 && (
                <tr>
                  <td colSpan="6">Hiç yorum bulunamadı.</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default CommentTable;
