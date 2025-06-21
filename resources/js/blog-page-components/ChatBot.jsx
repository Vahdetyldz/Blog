
import React, { useState } from "react";

function ChatBot() {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState("");
    const [messages, setMessages] = useState([]);

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

    return (
        <div
            id="chat-widget"
            style={{ position: "fixed", bottom: "20px", right: "20px" }}
        >
            <button
                onClick={toggleChat}
                style={{
                    padding: "10px 15px",
                    borderRadius: "50%",
                    background: "#3490dc",
                    color: "white",
                    border: "none",
                }}
            >
                💬
            </button>

            {isOpen && (
                <div
                    id="chat-box"
                    style={{
                        width: "300px",
                        height: "400px",
                        background: "white",
                        border: "1px solid #ccc",
                        borderRadius: "8px",
                        marginTop: "10px",
                        overflow: "hidden",
                        display: "flex",
                        flexDirection: "column",
                    }}
                >
                    <div
                        id="chat-messages"
                        style={{
                            height: "340px",
                            overflowY: "auto",
                            padding: "10px",
                        }}
                    >
                        {messages.map((msg, index) => (
                            <div key={index} style={{ marginBottom: "10px" }}>
                                <strong>{msg.sender}:</strong> {msg.content}
                            </div>
                        ))}
                    </div>
                    <input
                        type="text"
                        id="chat-input"
                        style={{
                            width: "100%",
                            padding: "10px",
                            border: "none",
                            borderTop: "1px solid #ccc",
                        }}
                        placeholder="Mesajınızı yazın..."
                        value={message}
                        onChange={(e) => setMessage(e.target.value)}
                        onKeyDown={handleKeyDown}
                    />
                </div>
            )}
        </div>
    );
}

export default ChatBot;
