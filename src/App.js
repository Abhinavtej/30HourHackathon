import './App.css';
import './assets/fonts/fonts.css';
import Navbar from './components/Navbar';
import HomePage from './components/HomePage';
import Footer from './components/Footer';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import CA from './components/CA';
import Domains from './components/Domains';
import Guidelines from './components/Guidelines';
import Contact from './components/Contact';
import Agenda from './components/Agenda';

function App() {
  return (
    <Router>
      <div className="App">
        <Navbar />
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/campus-ambassador" element={<CA/>} />
          <Route path="/domains" element={<Domains />} />
          <Route path="/guidelines" element={<Guidelines />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/agenda" element={<Agenda />} />
          <Route path="*" element={<HomePage />} />
        </Routes>
        <Footer />
      </div>
    </Router>
  );
}

export default App;
