function Footer() {
    return(
        <div id="wrapper">
            <div id="content-wrapper" className="d-flex flex-column">
                <footer className="sticky-footer bg-white">
                    <div className="container my-auto">
                        <div className="copyright text-center my-auto">
                            <span>Copyright &copy; Blog Sitesi Admin {new Date().getFullYear()}</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    );
}

export default Footer;
