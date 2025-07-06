import React, { useEffect, useState } from "react";
import { format } from "date-fns";
import { tr } from "date-fns/locale";

function BlogList({ apiUrl, editable = false }) {
    const [blogs, setBlogs] = useState([]);
    const [pagination, setPagination] = useState({});
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);

    useEffect(() => {
        setLoading(true);
        fetch(`${apiUrl}?page=${currentPage}`)
            .then(res => res.json())
            .then(data => {
                setBlogs(data.data || data);
                setPagination({
                    current: data.current_page,
                    last: data.last_page,
                    next: data.next_page_url,
                    prev: data.prev_page_url
                });
                setLoading(false);
            })
            .catch(err => {
                console.error("Veri alınamadı", err);
                setLoading(false);
            });
    }, [apiUrl, currentPage]);

    const handleDelete = (id) => {
        if (!window.confirm("Bu blogu silmek istediğine emin misin?")) return;

        fetch(`/blogs/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            credentials: "same-origin"
        })
            .then(res => {
                if (res.ok) {
                    setBlogs(prev => prev.filter(blog => blog.id !== id));
                } else {
                    alert("Silme işlemi başarısız oldu.");
                }
            })
            .catch(() => alert("Bir hata oluştu."));
    };

    if (loading) return <div>Yükleniyor...</div>;

    return (
        <div className="container px-4 px-lg-5">
            <div className="row gx-4 gx-lg-5 justify-content-center">
                <div className="col-md-10 col-lg-8 col-xl-7">
                    {blogs.map(blog => (
                        <div className="post-preview" key={blog.id}>
                            <a href={`/blog-content/${blog.id}`}>
                                <h2 className="post-title">{blog.title}</h2>
                                <h3 className="post-subtitle">{blog.subtitle}</h3>
                            </a>
                            <p className="post-meta">
                                {blog.user?.name} {blog.user?.surname} tarafından{" "}
                                {format(new Date(blog.created_at), "d MMMM yyyy", { locale: tr })} tarihinde paylaşıldı.
                            </p>

                            {editable && (
                                <div className="mb-3" style={{ display: "flex", gap: "10px" }}>
                                    <a
                                        href={`/blogs/${blog.id}/edit`}
                                        className="btn btn-sm"
                                        style={{
                                            background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
                                            color: "#fff",
                                            border: "none",
                                            borderRadius: "8px",
                                            padding: "8px 22px",
                                            fontWeight: 600,
                                            boxShadow: "0 2px 8px rgba(79,140,255,0.10)",
                                            transition: "background 0.2s, box-shadow 0.2s",
                                        }}
                                        onMouseOver={e => e.currentTarget.style.background = "#235390"}
                                        onMouseOut={e => e.currentTarget.style.background = "linear-gradient(135deg, #4f8cff 0%, #235390 100%)"}
                                    >
                                        <i className="fas fa-edit"></i> Güncelle
                                    </a>
                                    <button
                                        onClick={() => handleDelete(blog.id)}
                                        className="btn btn-sm"
                                        style={{
                                            background: "linear-gradient(135deg, #ff5e62 0%, #ff9966 100%)",
                                            color: "#fff",
                                            border: "none",
                                            borderRadius: "8px",
                                            padding: "8px 22px",
                                            fontWeight: 600,
                                            boxShadow: "0 2px 8px rgba(255,94,98,0.10)",
                                            transition: "background 0.2s, box-shadow 0.2s",
                                        }}
                                        onMouseOver={e => e.currentTarget.style.background = "#ff5e62"}
                                        onMouseOut={e => e.currentTarget.style.background = "linear-gradient(135deg, #ff5e62 0%, #ff9966 100%)"}
                                    >
                                        <i className="fas fa-trash-alt"></i> Sil
                                    </button>
                                </div>
                            )}

                            <hr className="my-4" />
                        </div>
                    ))}

                    {pagination.last > 1 && (
                        <div className="d-flex justify-content-between mb-4" style={{ gap: "10px" }}>
                            <button
                                className="btn"
                                style={{
                                    background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
                                    color: "#fff",
                                    border: "none",
                                    borderRadius: "8px",
                                    padding: "10px 32px",
                                    fontWeight: 600,
                                    boxShadow: "0 2px 8px rgba(79,140,255,0.10)",
                                    transition: "background 0.2s, box-shadow 0.2s",
                                    opacity: pagination.current === 1 ? 0.6 : 1,
                                    cursor: pagination.current === 1 ? "not-allowed" : "pointer"
                                }}
                                onClick={() => setCurrentPage(p => Math.max(1, p - 1))}
                                disabled={pagination.current === 1}
                                onMouseOver={e => { if (pagination.current !== 1) e.currentTarget.style.background = "#235390"; }}
                                onMouseOut={e => { if (pagination.current !== 1) e.currentTarget.style.background = "linear-gradient(135deg, #4f8cff 0%, #235390 100%)"; }}
                            >
                                <i className="fas fa-arrow-left"></i> Önceki
                            </button>
                            <button
                                className="btn"
                                style={{
                                    background: "linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)",
                                    color: "#fff",
                                    border: "none",
                                    borderRadius: "8px",
                                    padding: "10px 32px",
                                    fontWeight: 600,
                                    boxShadow: "0 2px 8px rgba(67,233,123,0.10)",
                                    transition: "background 0.2s, box-shadow 0.2s",
                                    opacity: pagination.current === pagination.last ? 0.6 : 1,
                                    cursor: pagination.current === pagination.last ? "not-allowed" : "pointer"
                                }}
                                onClick={() => setCurrentPage(p => p + 1)}
                                disabled={pagination.current === pagination.last}
                                onMouseOver={e => { if (pagination.current !== pagination.last) e.currentTarget.style.background = "#43e97b"; }}
                                onMouseOut={e => { if (pagination.current !== pagination.last) e.currentTarget.style.background = "linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)"; }}
                            >
                                Sonraki <i className="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

export default BlogList;
