import React from 'react'
import './css/Student.css'

function Student() {
  return (
    <div className='App-student'>
        <h1>Student Co-Ordinators</h1>
        <div className="App-student-container">
        <div className="students">
            <div className="student-row">
                <div className="student">
                    <span>Abhinavtej Reddy</span>
                    <p>+91 9346095136</p>
                </div>
                <div className="student">
                    <span>SK Fareed Baba</span>
                    <p>+91 6281688513</p>
                </div>
                <div className="student">
                    <span>V Ashrith</span>
                    <p>+91 9392700430</p>
                </div>
            </div>
            <div className="student-row">
                <div className="student">
                    <span>E Harika</span>
                </div>
                <div className="student">
                    <span>Sai Pranay</span>
                </div>
                <div className="student">
                    <span>Michael Benedict</span>
                </div>
                <div className="student">
                    <span>P Meghana</span>
                </div>
                <div className="student">
                    <span>B Sai Thanmai</span>
                </div>
            </div>
            <div className="student-row">
                <div className="student">
                    <span>Y Vishnu Vardhan</span>
                </div>
                <div className="student">
                    <span>J Thirumal</span>
                </div>
                <div className="student">
                    <span>Venkatesh</span>
                </div>
                <div className="student">
                    <span>Divya Rana</span>
                </div>
                <div className="student">
                    <span>Tanisha Bamothra</span>
                </div>
            </div>
        </div>
        </div>
    </div>
  )
}

export default Student