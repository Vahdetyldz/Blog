import React, { useEffect, useState } from "react";

function CategoryFilter({ onCategorySelect }) {
    const [categories, setCategories] = useState([]);
    const [selected, setSelected] = useState(0);

    useEffect(() => {
        fetch("/api/categories")
            .then(res => res.json())
            .then(data => setCategories(data));
    }, []);

    const handleSelect = (catId) => {
        setSelected(catId);
        onCategorySelect(catId);
    };

    return (
        <div style={{ display: "flex", justifyContent: "center", gap: 12, margin: "24px 0" }}>
            <button
                onClick={() => handleSelect(0)}
                style={{
                    fontWeight: selected === 0 ? "bold" : "normal",
                    background: selected === 0 ? "linear-gradient(135deg, #4f8cff 0%, #235390 100%)" : "#f5f5f5",
                    color: selected === 0 ? "#fff" : "#333",
                    border: "none",
                    borderRadius: "20px",
                    padding: "8px 22px",
                    fontSize: "1rem",
                    boxShadow: selected === 0 ? "0 2px 8px rgba(79,140,255,0.10)" : "none",
                    transition: "all 0.2s"
                }}
            >
                Tümü
            </button>
            {categories.map(cat => (
                <button
                    key={cat.id}
                    onClick={() => handleSelect(cat.id)}
                    style={{
                        fontWeight: selected === cat.id ? "bold" : "normal",
                        background: selected === cat.id ? "linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)" : "#f5f5f5",
                        color: selected === cat.id ? "#fff" : "#333",
                        border: "none",
                        borderRadius: "20px",
                        padding: "8px 22px",
                        fontSize: "1rem",
                        boxShadow: selected === cat.id ? "0 2px 8px rgba(67,233,123,0.10)" : "none",
                        transition: "all 0.2s"
                    }}
                >
                    {cat.name}
                </button>
            ))}
        </div>
    );
}

export default CategoryFilter;
