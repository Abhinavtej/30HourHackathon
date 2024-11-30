import React, { useState } from 'react';
import './css/HomePage.css';
import Title from '../assets/title.png';
import About from './About';
import Student from './Student';
import Organizers from './Organizers';
import Faq from './Faq';
import Expertise from './Expertise';
import Sponsors from './Sponsors';

function HomePage() {
  const [isLoading, setIsLoading] = useState(true);

  const handleImageLoad = () => {
    setIsLoading(false);
  };
  const handleRegisterClick = () => {
      window.location.href = "https://forms.gle/Rs2B2QtocHNqWEuT6";
  };
  return (
    <>
    <div className="App-HomePage">
      {isLoading && (
        <div className="spinner">
          <div className="loader"></div>
        </div>
      )}
      <img
        src={Title}
        width={1000}
        alt="Title"
        onLoad={handleImageLoad}
        className={isLoading ? 'hidden' : ''}
      />
      <div className="App-Register">
        <button onClick={handleRegisterClick} className="home-animated-button">
            <svg xmlns="http://www.w3.org/2000/svg" className="arr-2" viewBox="0 0 24 24">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
            <span className="text">R E G I S T E R</span>
            <svg xmlns="http://www.w3.org/2000/svg" className="arr-1" viewBox="0 0 24 24">
                <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                ></path>
            </svg>
        </button>
      </div>
    </div>
    <About />
    <Expertise />
    <Sponsors />
    <Organizers />
    <Student />
    <Faq />
    </>
  );
}

export default HomePage;
