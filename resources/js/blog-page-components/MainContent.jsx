import BlogList from "./BlogList";

function MainContent({ selectedCategory }) {
    let apiUrl = "/web/blogs";
    if (selectedCategory && selectedCategory !== 0) {
        apiUrl += `?category_id=${selectedCategory}`;
    }
    return <BlogList apiUrl={apiUrl} />;
}

export default MainContent;

