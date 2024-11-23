import React, { useState } from "react";
import "./css/Domains.css";
import domainsData from "../assets/domains.js";

function Domains() {
  const [selectedDomain, setSelectedDomain] = useState("AI in Education");

  const handleDomainChange = (domain) => setSelectedDomain(domain);

  return (
    <div className='App-domains'>
        <h1>Problem Statements</h1>
        <div className="domains-container">
      {/* Tabs for selecting domains */}
      <div className="tabs">
        {Object.keys(domainsData).map((domain) => (
          <button
            key={domain}
            className={`tab-button ${selectedDomain === domain ? "active" : ""}`}
            onClick={() => handleDomainChange(domain)}
          >
            {domain.toUpperCase()}
          </button>
        ))}
      </div>

      {/* Table to display domain problems */}
      <table className="domains-table">
        <thead>
          <tr>
            <th>SNo</th>
            <th>Problem ID</th>
            <th>Problem Title</th>
            <th>Domain</th>
          </tr>
        </thead>
        <tbody>
          {domainsData[selectedDomain].map((item, index) => (
            <tr key={item.id}>
              <td>{index + 1}</td>
              <td>{item.id}</td>
              <td>{item.title}</td>
              <td>{selectedDomain}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
    </div>
  );
}

export default Domains;
