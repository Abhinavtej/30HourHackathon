import React, { useState } from "react";
import "./css/Domains.css";
import domainsData from "../assets/domains.js";

function Domains() {
  const [selectedDomain, setSelectedDomain] = useState("AI in Education");
  const [dialogOpen, setDialogOpen] = useState(false);
  const [selectedProblem, setSelectedProblem] = useState(null);

  const handleDomainChange = (domain) => setSelectedDomain(domain);

  const handleRowClick = (problem) => {
    setSelectedProblem(problem);
    setDialogOpen(true);
  };

  const closeDialog = () => {
    setDialogOpen(false);
    setSelectedProblem(null);
  };

  return (
    <div className="App-domains">
      <h1>Problem Statements</h1>
      <div className="domains-container">
        {/* Tabs for selecting domains */}
        <div className="tabs">
          {Object.keys(domainsData).map((domain) => (
            <button
              key={domain}
              className={`tab-button ${
                selectedDomain === domain ? "active" : ""
              }`}
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
              <tr key={item.id} onClick={() => handleRowClick(item)}>
                <td>{index + 1}</td>
                <td>{item.id}</td>
                <td>{item.title}</td>
                <td>{selectedDomain}</td>
              </tr>
            ))}
          </tbody>
        </table>

        {/* Dialog */}
        {dialogOpen && selectedProblem && (
          <div className="dialog-overlay">
            <div className="dialog-box">
              <h2>Problem Details</h2>
              <p><strong>ID:</strong> {selectedProblem.id}</p>
              <p><strong>Title:</strong> {selectedProblem.title}</p>
              <p><strong>Description:</strong> {selectedProblem.description}</p>
              <button className="close-button" onClick={closeDialog}>
                Close
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}

export default Domains;
