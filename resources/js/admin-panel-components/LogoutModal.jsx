import React, { useRef } from "react";

function LogoutModal({ onLogout }) {
    const modalRef = useRef();

    // Bootstrap 5 modal aç/kapat için
    const openModal = () => {
        if (window.bootstrap) {
            const modal = new window.bootstrap.Modal(modalRef.current);
            modal.show();
        }
    };

    return (
        <>
            <button className="btn btn-link" onClick={openModal}>
                Çıkış Yap
            </button>
            <div
                className="modal fade"
                id="logoutModal"
                tabIndex="-1"
                aria-labelledby="logoutModalLabel"
                aria-hidden="true"
                ref={modalRef}
            >
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="logoutModalLabel">
                                Çıkış yapmak istediğinden emin misin?
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                                style={{
                                    filter: "invert(0)",
                                    background: "none",
                                    fontSize: 24,
                                    opacity: 1,
                                }}
                            >
                                <span
                                    aria-hidden="true"
                                    style={{ fontSize: 28, color: "#333" }}
                                >
                                    &times;
                                </span>
                            </button>
                        </div>
                        <div className="modal-body">
                            Oturumu sonlandırmak için aşağıdan "Çıkış yap"ı seçin.
                        </div>
                        <div className="modal-footer">
                            <button
                                className="btn btn-secondary"
                                type="button"
                                data-bs-dismiss="modal"
                            >
                                İptal
                            </button>
                            <a
                                className="btn btn-primary"
                                href="/logout"
                                onClick={onLogout}
                            >
                                Çıkış yap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default LogoutModal;