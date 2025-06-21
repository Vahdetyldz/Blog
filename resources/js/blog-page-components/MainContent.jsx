import React, { useEffect, useState } from "react";
import { format } from "date-fns";
import { tr } from "date-fns/locale";

function MainContent() {
    const [blogs, setBlogs] = useState([]);
    const [pagination, setPagination] = useState({});
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);

    useEffect(() => {
        setLoading(true);
        fetch(`/web/blogs?page=${currentPage}`)
            .then(res => res.json())
            .then(data => {
                setBlogs(data.data); // data içinde bloglar
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
    }, [currentPage]);

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
                                <a href={`/blog-content/${blog.id}`}>
                                    {blog.user?.name} {blog.user?.surname}
                                </a>{" "}
                                tarafından{" "}
                                {format(new Date(blog.created_at), "d MMMM yyyy", { locale: tr })}{" "}
                                tarihinde paylaşıldı.
                            </p>
                            <hr className="my-4" />
                        </div>
                    ))}

                    {/* Pagination Butonları */}
                    <div className="d-flex justify-content-between mb-4">
                        <button
                            className="btn btn-primary"
                            onClick={() => setCurrentPage(p => Math.max(1, p - 1))}
                            disabled={pagination.current === 1}
                        >
                            Önceki
                        </button>
                        <button
                            className="btn btn-primary"
                            onClick={() => setCurrentPage(p => p + 1)}
                            disabled={pagination.current === pagination.last}
                        >
                            Sonraki
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default MainContent;

