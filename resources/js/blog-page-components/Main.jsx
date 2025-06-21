import Navbar from "./Navbar";
import PageHeader from "./PageHeader";
import MainContent from "./MainContent";
import ChatBot from "./ChatBot";
import Footer from "./Footer";
function Main() {
    return(
        <div>
            <Navbar />
            <PageHeader />
            <MainContent />
            <ChatBot />
            <Footer />
        </div>
    );
}
export default Main;