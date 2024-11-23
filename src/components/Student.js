import React from 'react'
import './css/Student.css'

function Student() {
  return (
    <div className='App-student'>
        <h1>Student Co-Ordinators</h1>
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
                    <span>Vishnuvardhan Reddy</span>
                    <p>+91 9392700430</p>
                </div>
                <div className="student">
                    <span>Harshavardhan</span>
                    <p>+91 7569460743</p>
                </div>
                <div className="student">
                    <span>Venkatesh</span>
                    <p>+91 7207436307</p>
                </div>
                <div className="student">
                    <span>Lokesh Reddy</span>
                    <p>+91 7569162986</p>
                </div>
            </div>
            <div className="student-row">
                <div className="student">
                    <span>V Ashrith</span>
                </div>
                <div className="student">
                    <span>E Harika</span>
                </div>
                <div className="student">
                    <span>K Sathvika</span>
                </div>
                <div className="student">
                    <span>K Sumanth</span>
                </div>
                <div className="student">
                    <span>Y Vishnu Vardhan</span>
                </div>
                <div className="student">
                    <span>Varshitha Reddy</span>
                </div>
            </div>
        </div>
    </div>
  )
}

export default Student