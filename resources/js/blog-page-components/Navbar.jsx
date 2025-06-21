import React, { useEffect, useState } from 'react';

function Navbar() {
    const [user, setUser] = useState(null);

    useEffect(() => {
        fetch('/user-info')
            .then(res => res.json())
            .then(data => {
                if (data && data.id) {
                setUser(data); // Giriş yapılmış
                } else {
                setUser(null); // Giriş yapılmamış
                }
            });
    }, []);

    return (
        <nav className="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div className="container px-4 px-lg-5">
                <a className="navbar-brand" href="/">ANA SAYFA</a>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                    Menu
                    <i className="fas fa-bars"></i>
                </button>
                <div className="collapse navbar-collapse" id="navbarResponsive">
                    <ul className="navbar-nav ms-auto py-4 py-lg-0">
                        <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/">Ana Sayfa</a></li>

                        {user ? (
                            <>
                                <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/create-blog">Blog Oluştur</a></li>
                                <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/blog-my-blogs">Bloglarım</a></li>
                                <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/logout">Çıkış Yap</a></li>
                            </>
                        ) : (
                            <>
                                <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/login">Giriş Yap</a></li>
                                <li className="nav-item"><a className="nav-link px-lg-3 py-3 py-lg-4" href="/register">Kayıt Ol</a></li>
                            </>
                        )}
                    </ul>
                </div>
            </div>
        </nav>
    );
}

export default Navbar;
