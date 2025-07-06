import Navbar  from "../blog-page-components/Navbar";
import PageHeader from "../blog-page-components/PageHeader";
import BlogList from "../blog-page-components/BlogList";
import Footer from "../blog-page-components/Footer";

function MyBlogs() {
    return (
        <>
            <Navbar />
            <PageHeader />
            <BlogList apiUrl="/web/myblogs" editable="{true}"/>
            <Footer />
        </>
    );
}
export default MyBlogs;