import React, { useState, useEffect } from "react";

function RegisterForm() {
    const [form, setForm] = useState({
        name: "",
        surname: "",
        email: "",
        password: "",
        password_confirmation: ""
    });

    const [errors, setErrors] = useState([]);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        fetch("/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify(form),
            credentials: "same-origin"
        })
            .then(async (res) => {
                if (res.ok) {
                    window.location.href = "/"; // Başarılıysa anasayfaya yönlendir
                } else if (res.status === 422) {
                    const data = await res.json();
                    setErrors(Object.values(data.errors).flat());
                } else {
                    setErrors(["Bilinmeyen bir hata oluştu."]);
                }
            })
            .catch(() => setErrors(["Sunucuya ulaşılamadı."]));
    };

    // Hataları 3 saniye sonra temizle
    useEffect(() => {
        if (errors.length > 0) {
            const timer = setTimeout(() => setErrors([]), 3000);
            return () => clearTimeout(timer);
        }
    }, [errors]);

    return (
        <div className="container">
            {errors.length > 0 && (
                <div className="alert-container">
                    {errors.map((error, i) => (
                        <div key={i} className="alert alert-danger">
                            <strong>Hata:</strong> {error}
                        </div>
                    ))}
                </div>
            )}

            <h2>Kayıt Ol</h2>
            <form onSubmit={handleSubmit}>
                <input
                    type="text"
                    name="name"
                    placeholder="Adınız"
                    value={form.name}
                    onChange={handleChange}
                    required
                />
                <input
                    type="text"
                    name="surname"
                    placeholder="Soyadınız"
                    value={form.surname}
                    onChange={handleChange}
                    required
                />
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value={form.email}
                    onChange={handleChange}
                    required
                />
                <input
                    type="password"
                    name="password"
                    placeholder="Şifre"
                    value={form.password}
                    onChange={handleChange}
                    required
                />
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Şifre Tekrar"
                    value={form.password_confirmation}
                    onChange={handleChange}
                    required
                />
                <button type="submit">Kayıt Ol</button>
            </form>

            <a className="link" href="/login">Giriş Yap</a>
        </div>
    );
}

export default RegisterForm;
