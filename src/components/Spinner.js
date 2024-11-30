import React from "react";
import "./css/Spinner.css";
import logo from "../assets/mru.png"; 

const Spinner = () => (
  <div className="spinner-container">
    <img src={logo} alt="Logo" className="blinking-logo" />
  </div>
);

export default Spinner;
