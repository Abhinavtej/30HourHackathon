import React from 'react'
import './css/Contact.css'

function Contact() {
  return (
    <div className='App-contact'>
        <h1>Let's get in touch</h1>
        <div className="contacts">
            <div className="contact-info">
                <p>Instagram</p>
                <p>Email: email.com</p>
                <p>Location</p>
                <iframe title="Malla Reddy University Location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3803.8890264176202!2d78.44627937516894!3d17.560469433356616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb8ff8652b6823%3A0x981713dbb4b708c3!2sMalla%20Reddy%20University!5e0!3m2!1sen!2sin!4v1727342094485!5m2!1sen!2sin" width="300" height="200" allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div className="contact-form">
                <form action="">
                    <label htmlFor="name">Name:</label> <br />
                    <input type="text" name="name" /> <br />
                    <label htmlFor="email">Email:</label> <br />
                    <input type="email" name="email" /> <br />
                    <label htmlFor="message">Message:</label> <br />
                    <textarea name="message"></textarea> <br />
                    <button>Send</button>
                </form>
            </div>
        </div>
    </div>
  )
}

export default Contact