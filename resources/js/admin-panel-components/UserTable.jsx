import React, { useEffect, useState } from 'react';

const UserTable = () => {
    const apiUrl = '/web/users';
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);

    // Giriş yapan kullanıcı bilgisi (ör: window.currentUser ile alınabilir)
    const currentUser = typeof window !== 'undefined' && window.currentUser ? window.currentUser : null;

    useEffect(() => {
        setLoading(true);
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                setUsers(data.data || data);
                setLoading(false);
            })
            .catch(err => {
                console.error('Kullanıcılar alınamadı', err);
                setLoading(false);
            });
    }, [apiUrl]);

    const handleMakeAdmin = async (id) => {
        if (!window.confirm('Bu kullanıcıya admin yetkisi vermek veya adminliği almak istiyor musunuz?')) return;
        try {
            const response = await fetch(`/users/${id}/make-admin`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                credentials: 'same-origin',
            });
            if (response.ok) {
                const data = await response.json();
                setUsers(prev => prev.map(user => user.id === id ? { ...user, role: data.role } : user));
            } else {
                alert('Yetki işlemi başarısız oldu.');
            }
        } catch (err) {
            alert('Bir hata oluştu.');
        }
    };

    const handleToggleActive = async (id, isActive) => {
        const confirmMsg = isActive ? 'Bu kullanıcıyı pasif yapmak istiyor musunuz?' : 'Bu kullanıcıyı aktif yapmak istiyor musunuz?';
        if (!window.confirm(confirmMsg)) return;
        try {
            const response = await fetch(`/users/${id}/toggle-active`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                credentials: 'same-origin',
            });
            if (response.ok) {
                setUsers(prev => prev.map(user => user.id === id ? { ...user, is_active: !isActive } : user));
            } else {
                alert('Aktif/Pasif işlemi başarısız oldu.');
            }
        } catch (err) {
            alert('Bir hata oluştu.');
        }
    };

    if (loading) return <div>Yükleniyor...</div>;

    return (
        <div>
            {/* Page Heading */}
            <div className="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Kullanıcılar</h1>
                <a href="/" target="_blank" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    className="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle</a>
            </div>
            <div className="card shadow mb-4">
                <div className="card-header py-3">
                    <h6 className="m-0 font-weight-bold text-primary">
                        <strong>{users.length}</strong> kullanıcı bulundu.
                    </h6>
                </div>
                <div className="card-body">
                    <div className="table-responsive">
                        <table className="table table-bordered" width="100%" cellSpacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Aktiflik</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.map(user => (
                                    <tr key={user.id}>
                                        <td>{user.id}</td>
                                        <td>{user.name}</td>
                                        <td>{user.surname}</td>
                                        <td>{user.email}</td>
                                        <td>
                                            <span className={`badge ${user.role === 'root' ? 'badge-dark' : user.role === 'admin' ? 'badge-success' : 'badge-secondary'}`}>{user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span>
                                        </td>
                                        <td>
                                            <span className={`badge ${user.is_active ? 'badge-success' : 'badge-danger'}`}>{user.is_active ? 'Aktif' : 'Pasif'}</span>
                                        </td>
                                        <td>
                                            {/* Sadece root kullanıcıya (başkası veya kendisi) hiçbir işlem yapılamaz */}
                                            {user.role === 'root' ? (
                                                user.id === currentUser?.id ? <span>-</span> : <span>-</span>
                                            ) : currentUser && currentUser.role === 'root' ? (
                                                <>
                                                    <button
                                                        className="btn btn-sm btn-warning mr-1"
                                                        onClick={() => handleMakeAdmin(user.id)}
                                                    >
                                                        {user.role === 'admin' ? 'Adminliği Al' : 'Admin Yap'}
                                                    </button>
                                                    <button
                                                        className={`btn btn-sm ${user.is_active ? 'btn-secondary' : 'btn-success'}`}
                                                        onClick={() => handleToggleActive(user.id, user.is_active)}
                                                    >
                                                        {user.is_active ? 'Pasif Yap' : 'Aktif Yap'}
                                                    </button>
                                                </>
                                            ) : currentUser && currentUser.role === 'admin' ? (
                                                <button
                                                    className={`btn btn-sm ${user.is_active ? 'btn-secondary' : 'btn-success'}`}
                                                    onClick={() => handleToggleActive(user.id, user.is_active)}
                                                >
                                                    {user.is_active ? 'Pasif Yap' : 'Aktif Yap'}
                                                </button>
                                            ) : (
                                                <span>-</span>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                                {users.length === 0 && (
                                    <tr>
                                        <td colSpan="7">Hiç kullanıcı bulunamadı.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default UserTable;
