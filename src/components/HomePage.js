import React from 'react'
import './css/HomePage.css'
import Title from '../assets/title.png'

function HomePage() {
  return (
    <div className='App-HomePage'>
      <img src={Title} width={1000} alt="Title" />
    </div>
  )
}

export default HomePage