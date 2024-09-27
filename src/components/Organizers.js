import React from 'react';
import './css/Organizers.css';
import ChiefPatron from '../assets/organizers/mallareddy.png';
import Secretary from '../assets/organizers/mahenderreddy.png';
import President from '../assets/organizers/bhadrareddy.webp';
import VC from '../assets/organizers/vskreddy.png';
import Registrar from '../assets/organizers/anjaneyulu.png';
import DeanAIML from '../assets/organizers/deanaiml.png';
import II_Incharge from '../assets/organizers/giftajerith.png';
import III_Incharge from '../assets/organizers/sivaranjani.png';
import IV_Incharge from '../assets/organizers/sujitdas.png';

function Organizers() {
  return (
    <div className='App-organizers'>
        <h1>Organizing Body</h1>
        <div className="organizers-data">

                <div className="chief-patron">
                    <h2>Chief Patron</h2>
                    <img src={ChiefPatron} className='organizers-image' alt="Sri Ch. Malla Reddy - Chief Patron" />
                    <p>Sri Ch. Malla Reddy</p>
                    <p>Founder Chairman, MRGI</p>
                </div>
            {/* Chief Patron */}
            <div className="organizers-row">
                {/* Patrons */}
                <div className="title-span">
                    <h2>Patrons</h2>
                    <div className="patrons">
                        <div className="patron">
                            <img src={Secretary} className='organizers-image' alt="Sri Ch. Mahender Reddy - Secretary" />
                            <p>Sri Ch. Mahender Reddy</p>
                            <p>Secretary</p>
                        </div>
                        <div className="patron">
                            <img src={President} className='organizers-image' alt="Dr. Bhadra Reddy - President" />
                            <p>Dr. Bhadra Reddy</p>
                            <p>President</p>
                        </div>
                        <div className="patron">
                            <img src={VC} className='organizers-image' alt="Dr. VSK Reddy - Vice Chancellor" />
                            <p>Dr. VSK Reddy</p>
                            <p>Vice Chancellor</p>
                        </div>
                        <div className="patron">
                            <img src={Registrar} className='organizers-image' alt="Dr. M. Anjaneyulu - Registrar" />
                            <p>Dr. M. Anjaneyulu</p>
                            <p>Registrar</p>
                        </div>
                    </div>
                </div>
                <div className="convenor">
                    <h2>Convenor</h2>
                    <img src={DeanAIML} className='organizers-image' alt="Dr. S. S. Patnaik - Director, NIT Rourkela" />
                    <p>Dr. Thayyaba Khatoon</p>
                    <p>Dean AI&ML</p>
                </div>
            </div>

            {/* Convenor and Co-Convenors */}
            <div className="organizers-row">
                <div className="title-span">
                    <h2>Co-Convenors</h2>
                    <div className="co-convenors">
                        <div className="co-convenor">
                            <img src={II_Incharge} className='organizers-image' alt="Dr. S. S. Patnaik - Co-Convenor" />
                            <p>Dr. Gifta Jerith</p>
                            <p>2nd Year Incharge</p>
                        </div>
                        <div className="co-convenor">
                            <img src={III_Incharge} className='organizers-image' alt="Dr. S. S. Patnaik - Co-Convenor" />
                            <p>Dr. A. SivaRanjani</p>
                            <p>3rd Year Incharge</p>
                        </div>
                        <div className="co-convenor">
                            <img src={IV_Incharge} className='organizers-image' alt="Dr. S. S. Patnaik - Co-Convenor" />
                            <p>Dr. Sujit Das</p>
                            <p>4th Year Incharge</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  );
}

export default Organizers;
