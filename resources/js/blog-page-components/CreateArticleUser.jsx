import ArticleForm from '../admin-panel-components/ArticleForm';
import Footer from './Footer';
import Navbar from './Navbar';

function CreateArticleUser() {
    const handleCreate = (data) => {
        window.location.href = '/blog-my-blogs';
    };

    return (
        <div id="wrapper">
            <div id="content-wrapper" className="d-flex flex-column">
                <div id="content">
                    <Navbar />
                    <div className="container-fluid">
                        <ArticleForm
                            title="Yeni Yazı"
                            onSubmit={handleCreate}
                        />
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
}

export default CreateArticleUser;