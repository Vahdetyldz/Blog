import React, { useState } from "react";
import Navbar from "./Navbar";
import PageHeader from "./PageHeader";
import MainContent from "./MainContent";
import ChatBot from "./ChatBot";
import Footer from "./Footer";
import CategoryFilter from "./CategoryFilter";

function Main() {
    const [selectedCategory, setSelectedCategory] = useState(0);
    return(
        <div>
            <Navbar />
            <PageHeader />
            <CategoryFilter onCategorySelect={setSelectedCategory} />
            <MainContent selectedCategory={selectedCategory} />
            <ChatBot />
            <Footer />
        </div>
    );
}
export default Main;