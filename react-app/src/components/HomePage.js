import React from 'react'
import './css/HomePage.css'
import Title from '../assets/title.png'
import Dept from '../assets/dept.png'

function HomePage() {
  return (
    <div className='App-HomePage'>
      <img src={Dept} width={1000} alt="Department" /> <br />
      <img src={Title} width={1000} alt="Title" />
    </div>
  )
}

export default HomePage