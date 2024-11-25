import React from 'react'
import mru from '../assets/mru.png'
import './css/About.css'

function About() {
  return (
    <div className='App-about'>
        <h1>About US</h1>
        <div className="App-about-container">
          <img src={mru} width={100} alt="" />
          <p>Malla Reddy University, Hyderabad (MRUH) is the only Private University under green field category established in the year 2020 As per Telangana State Private Universities Act No.13 of 2020 and G.O.Ms.No.14, Higher Education (UE) Department dt. 15.6.2020 was approved by the Government of Telangana State. Our focus is to address the emerging needs of Industry and Society.</p>
        </div>
        <div className="App-about-container">
          <p>Hack-Nirvana is a premier 30-hour National Level Hackathon organized by the Department of Artificial Intelligence & Machine Learning at Malla Reddy University. Returning with its 2nd edition, Hack-Nirvana is designed to ignite the spark of innovation and empower tech enthusiasts, students, and developers to showcase their talent, creativity, and problem-solving skills.</p>
        </div>
      </div>
  )
}

export default About