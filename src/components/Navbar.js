import React, { useEffect } from 'react';
import Logo from '../assets/logo.png';
import './css/Navbar.css';
import { Link } from 'react-scroll';

function Navbar() {
    useEffect(() => {
        const handleScroll = () => {
            const header = document.querySelector(".App-header");
            if (header) {
                header.style.backgroundColor = window.scrollY > 0 ? "rgba(50, 50, 55, 0.5)" : "transparent";
                header.style.backdropFilter = window.scrollY > 0 ? "saturate(180%) blur(10px)" : "none";
                header.style.WebkitBackdropFilter = window.scrollY > 0 ? "blur(10px)" : "none";
            }
        };

        window.addEventListener("scroll", handleScroll);

        return () => {
            window.removeEventListener("scroll", handleScroll);
        };
    }, []);

    const handleRegisterClick = () => {
        window.location.href = "https://forms.gle/VHSxmETtVPs8BMp58";
      };

    return (
        <div className="App-header">
            <div className="App-logo">
                <Link to="homepage" smooth={true} duration={500}>
                    <img src={Logo} alt="Logo" width={200} />
                </Link>
            </div>
            <div className="App-menu">
                <ul />
                    <li><Link to="about" smooth={true} duration={500} offset={-150}>About</Link></li>
                    <li><Link to="guidelines" smooth={true} duration={500} offset={-150}>Guidelines</Link></li>
                    <li><Link to="domains" smooth={true} duration={500} offset={-150}>Domains</Link></li>
                    <li><Link to="contact" smooth={true} duration={500} offset={-150}>Contact</Link></li>
            </div>
            <div className="App-Register">
                <button onClick={handleRegisterClick} class="animated-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="arr-2" viewBox="0 0 24 24">
                    <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                    ></path>
                </svg>
                <span class="text">R E G I S T E R</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="arr-1" viewBox="0 0 24 24">
                    <path
                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"
                    ></path>
                </svg>
                </button>
            </div>
        </div>
    );
}

export default Navbar;
