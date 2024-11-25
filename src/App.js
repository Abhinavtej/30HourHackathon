import './App.css';
import './assets/fonts/fonts.css';
import Navbar from './components/Navbar';
import HomePage from './components/HomePage';
import About from './components/About';
import Guidelines from './components/Guidelines';
import Domains from './components/Domains';
import Organizers from './components/Organizers';
import Student from './components/Student';
import Contact from './components/Contact';
import Footer from './components/Footer';
import Faq from './components/Faq';
import CA from './components/CA';


function App() {
  return (
    <div className="App">
        <Navbar />
        <div className="homepage"><HomePage /></div>
        <div className="about"><About /></div>
        <div className="ca"><CA/></div>
        <div className="guidelines"><Guidelines /></div>
        <div className="domains"><Domains /></div>
        <Organizers />
        <div className="contact"><Student /></div>
        <Contact />
        <div className="faq"><Faq /></div>
        <Footer />
    </div>
  );
}

export default App;
