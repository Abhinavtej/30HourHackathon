import React from 'react'
import './css/Footer.css'
import Logo from '../assets/title2.png'
import { Link } from 'react-scroll';
import { FaInstagram, FaGlobe, FaYoutube } from 'react-icons/fa';

function Footer() {
  return (
    <div className="line">
      <hr />
    <div className='App-footer'>
        <div className="App-Footer-logo">
                  <Link to="homepage" smooth={true} duration={500}>
                    <img src={Logo} alt="Logo" width={300} />
                </Link>
            <ul />
            <li>2nd Edition of <br /> Malla Reddy University's Ultimate Hackathon</li>
            <li>Organised by Department of AI & ML</li>
        </div>
        <div className="App-Footer-menu">
            <ul />
            <li>
              <FaInstagram /> 
              <a href="https://hacknirvana.openinapp.co/insta" target='blank_'><span>@hacknirvana_aimlmruh</span></a>
            </li>
            <li>
              <FaInstagram />
              <a href="https://aimlmruh.openinapp.co/insta" target='blank_'><span>@aiml_mruh</span></a>
            </li>
            <li>
              <FaGlobe />
              <a href="https://mallareddyuniversity.ac.in" target='blank_'><span>Malla Reddy University</span></a>
            </li>
            <li>
              <FaYoutube />
              <a href="https://aimlmruh.openinapp.co/yt" target='blank_'><span>AIML Mruh</span></a>
            </li>
        </div>
    </div>
  </div>
  )
}

export default Footer