import React from 'react'
import './css/Footer.css'
import Logo from '../assets/title2.png'
import { Link } from 'react-scroll';

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
                    <li><Link to="about" smooth={true} duration={500} offset={-150}>About</Link></li>
                    <li><Link to="guidelines" smooth={true} duration={500} offset={-150}>Guidelines</Link></li>
                    <li><Link to="domains" smooth={true} duration={500} offset={-150}>Domains</Link></li>
                    <li><Link to="contact" smooth={true} duration={500} offset={-150}>Contact</Link></li>
        </div>
    </div>
  </div>
  )
}

export default Footer