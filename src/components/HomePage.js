import React, { useState } from 'react';
import './css/HomePage.css';
import Title from '../assets/title.png';

function HomePage() {
  const [isLoading, setIsLoading] = useState(true);

  const handleImageLoad = () => {
    setIsLoading(false);
  };

  return (
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
    </div>
  );
}

export default HomePage;
