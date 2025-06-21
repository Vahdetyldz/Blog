import React from 'react';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import ArticleForm from './ArticleForm';
import Footer from './Footer';

function CreateArticle() {
  return (
    <div id="wrapper">
      <Sidebar />
      <div id="content-wrapper" className="d-flex flex-column">
        <div id="content">
          <Topbar />
          <div className="container-fluid">
            <ArticleForm />
          </div>
        </div>
        <Footer />
      </div>
    </div>
  );
}

export default CreateArticle;
