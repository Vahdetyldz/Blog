import React, { useState, useEffect } from "react";

function LoginForm() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errors, setErrors] = useState([]);

    const handleSubmit = (e) => {
        e.preventDefault();

        fetch("/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ email, password }),
            credentials: "same-origin",
        })
            .then(async res => {
                const data = await res.json();
                if (res.ok && data.success) {
                    window.location.href = data.redirect || "/";
                } else if (res.status === 422) {
                    setErrors(Object.values(data.errors).flat());
                }
            })
            .catch(() => setErrors(["Sunucuya bağlanılamadı."]));
    };

    // Hataları 3 saniye sonra sil
    useEffect(() => {
        if (errors.length > 0) {
            const timeout = setTimeout(() => setErrors([]), 3000);
            return () => clearTimeout(timeout);
        }
    }, [errors]);

    return (
        <div className="container">
            {errors.length > 0 && (
                <div className="alert-container">
                    {errors.map((err, i) => (
                        <div key={i} className="alert alert-danger">
                            <strong>Hata:</strong> {err}
                        </div>
                    ))}
                </div>
            )}

            <h2>Giriş Yap</h2>
            <form onSubmit={handleSubmit}>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
                <input
                    type="password"
                    name="password"
                    placeholder="Şifre"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
                <button type="submit">Giriş Yap</button>
            </form>

            <a className="link" href="/register">Kayıt Ol</a>
        </div>
    );
}

export default LoginForm;
