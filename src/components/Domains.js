import React from 'react'
import './css/Domains.css'
import postsData from '../assets/domains.js'

function Domains() {
  const renderProductCards = () => {
    return postsData.slice(0, 5).map(post => (
      <div className="card" id="card" key={post.id} style={{ width: "19rem", marginRight: "1rem", marginBottom: "1rem" }}>
          <div className="card-contents">
            <p style={{textAlign: 'center', fontWeight: 'bold', fontSize: '1.5em'}}>{post.title}</p>
          </div>
      </div>
    ));
  };
  return (
    <div className='App-domains'>
        <h1>Domains</h1>
        <div className="cards">
          {renderProductCards()}
        </div>
    </div>
  )
}

export default Domains