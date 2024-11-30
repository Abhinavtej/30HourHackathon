import React, { useState, useEffect } from 'react';
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
import Spinner from './components/Spinner';

function App() {
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 3000); // Set to false after 3 seconds
    return () => clearTimeout(timer); // Cleanup on unmount
  }, []);

  return (
    <div className="App">
      {loading ? (
        <Spinner /> // Show spinner while loading
      ) : (
        <Router>
          <Navbar />
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/campus-ambassador" element={<CA />} />
            <Route path="/domains" element={<Domains />} />
            <Route path="/guidelines" element={<Guidelines />} />
            <Route path="/contact" element={<Contact />} />
            <Route path="/agenda" element={<Agenda />} />
            <Route path="*" element={<HomePage />} />
          </Routes>
          <Footer />
        </Router>
      )}
    </div>
  );
}

export default App;
