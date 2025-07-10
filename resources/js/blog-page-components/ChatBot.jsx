import React, { useState, useRef, useEffect } from "react";

function ChatBot() {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState("");
    const [messages, setMessages] = useState([]);
    const messagesEndRef = useRef(null);

    const toggleChat = () => {
        setIsOpen(!isOpen);
    };

    const sendMessage = async () => {
        const trimmedMessage = message.trim();
        if (!trimmedMessage) return;

        addMessage("Siz", trimmedMessage);
        setMessage("");

        try {
            const response = await fetch("/ask", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content"),
                },
                body: JSON.stringify({ prompt: trimmedMessage }),
            });

            const data = await response.json();
            addMessage("Bot", data.response || "Cevap alınamadı.");
        } catch (error) {
            addMessage("Bot", "Hata oluştu.");
        }
    };

    const addMessage = (sender, content) => {
        setMessages((prevMessages) => [
            ...prevMessages,
            { sender, content },
        ]);
    };

    const handleKeyDown = (e) => {
        if (e.key === "Enter") {
            sendMessage();
        }
    };

    useEffect(() => {
        if (messagesEndRef.current) {
            messagesEndRef.current.scrollIntoView({ behavior: "smooth" });
        }
    }, [messages]);

    // Modern ve şık stiller
    const styles = {
        widget: {
            position: "fixed",
            bottom: "32px",
            right: "32px",
            zIndex: 9999,
        },
        chatButton: {
            padding: "0",
            borderRadius: "50%",
            background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
            color: "white",
            border: "none",
            width: "60px",
            height: "60px",
            boxShadow: "0 4px 16px rgba(79,140,255,0.25)",
            fontSize: "2rem",
            cursor: "pointer",
            transition: "box-shadow 0.2s",
        },
        chatBox: {
            width: "500px",
            height: "500px",
            background: "rgba(255,255,255,0.98)",
            border: "1px solid #e3e7ee",
            borderRadius: "18px",
            marginTop: "10px",
            boxShadow: "0 8px 32px rgba(79,140,255,0.15)",
            display: "flex",
            flexDirection: "column",
            overflow: "hidden",
            animation: "fadeInUp 0.3s",
        },
        chatHeader: {
            background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
            color: "white",
            padding: "16px",
            fontWeight: "bold",
            fontSize: "1.1rem",
            letterSpacing: "1px",
            display: "flex",
            alignItems: "center",
            justifyContent: "space-between",
        },
        closeBtn: {
            background: "transparent",
            border: "none",
            color: "white",
            fontSize: "1.3rem",
            cursor: "pointer",
        },
        chatMessages: {
            flex: 1,
            overflowY: "auto",
            padding: "18px 12px 8px 12px",
            background: "#f7faff",
            display: "flex",
            flexDirection: "column",
            gap: "10px",
            minHeight: "0",
        },
        messageRow: {
            display: "flex",
            flexDirection: "row",
            alignItems: "flex-end",
        },
        messageBubbleUser: {
            background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
            color: "white",
            borderRadius: "16px 16px 4px 16px",
            padding: "10px 16px",
            maxWidth: "70%",
            marginLeft: "auto",
            marginRight: "0",
            fontSize: "1rem",
            boxShadow: "0 2px 8px rgba(79,140,255,0.08)",
            wordBreak: "break-word",
        },
        messageBubbleBot: {
            background: "#e3e7ee",
            color: "#222",
            borderRadius: "16px 16px 16px 4px",
            padding: "10px 16px",
            maxWidth: "70%",
            marginRight: "auto",
            marginLeft: "0",
            fontSize: "1rem",
            boxShadow: "0 2px 8px rgba(79,140,255,0.05)",
            wordBreak: "break-word",
        },
        sender: {
            fontSize: "0.8rem",
            color: "#888",
            marginBottom: "2px",
            marginLeft: "2px",
        },
        chatInputWrapper: {
            padding: "16px",
            background: "#f7faff",
            borderTop: "1px solid #e3e7ee",
            display: "flex",
            gap: "8px",
        },
        chatInput: {
            flex: 1,
            padding: "14px 18px",
            borderRadius: "24px",
            border: "1.5px solid #b3c6e0",
            outline: "none",
            fontSize: "1.08rem",
            background: "#fafdff",
            transition: "border 0.2s, box-shadow 0.2s",
            boxShadow: "0 2px 8px rgba(79,140,255,0.07)",
            marginRight: "6px",
        },
        sendBtn: {
            background: "linear-gradient(135deg, #4f8cff 0%, #235390 100%)",
            color: "white",
            border: "none",
            borderRadius: "8px",
            padding: "0 18px",
            fontSize: "1.1rem",
            cursor: "pointer",
            transition: "background 0.2s",
        },
        // Animasyon için keyframes (CSS-in-JS ile eklenemez, global eklenmeli)
    };

    // Animasyon için keyframes ekle (yalnızca bir kez eklenir)
    useEffect(() => {
        const style = document.createElement("style");
        style.innerHTML = `
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }`;
        document.head.appendChild(style);
        return () => { document.head.removeChild(style); };
    }, []);

    return (
        <div id="chat-widget" style={styles.widget}>
            <button
                onClick={toggleChat}
                style={styles.chatButton}
                aria-label={isOpen ? "Kapat" : "Sohbeti Aç"}
                title={isOpen ? "Kapat" : "Sohbeti Aç"}
            >
                {isOpen ? "✖" : "💬"}
            </button>

            {isOpen && (
                <div id="chat-box" style={styles.chatBox}>
                    <div style={styles.chatHeader}>
                        <span>Yapay Zeka Asistanı</span>
                        <button style={styles.closeBtn} onClick={toggleChat} title="Kapat">×</button>
                    </div>
                    <div id="chat-messages" style={styles.chatMessages}>
                        {messages.length === 0 && (
                            <div style={{ color: "#888", textAlign: "center", marginTop: "40px" }}>
                                Merhaba 👋<br />Sorunuzu yazıp gönderebilirsiniz.
                            </div>
                        )}
                        {messages.map((msg, index) => (
                            <div
                                key={index}
                                style={{
                                    ...styles.messageRow,
                                    justifyContent: msg.sender === "Siz" ? "flex-end" : "flex-start",
                                }}
                            >
                                <div style={msg.sender === "Siz" ? styles.messageBubbleUser : styles.messageBubbleBot}>
                                    <div style={styles.sender}>
                                        {msg.sender === "Siz" ? "Sen" : "Bot"}
                                    </div>
                                    {msg.content}
                                </div>
                            </div>
                        ))}
                        <div ref={messagesEndRef} />
                    </div>
                    <div style={styles.chatInputWrapper}>
                        <input
                            type="text"
                            id="chat-input"
                            style={styles.chatInput}
                            placeholder="Mesajınızı yazın..."
                            value={message}
                            onChange={(e) => setMessage(e.target.value)}
                            onKeyDown={handleKeyDown}
                            autoFocus
                        />
                        <button style={styles.sendBtn} onClick={sendMessage} title="Gönder">
                            ➤
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}

export default ChatBot;
