import React from 'react'
import './css/Contact.css'

function Contact() {
    const [result, setResult] = React.useState("");

    const onSubmit = async (event) => {
        event.preventDefault();
        setResult("Sending....");
        const formData = new FormData(event.target);

        formData.append("access_key", "92e2a1fa-2156-4fa6-9562-0bf03f2d26a1");

        const response = await fetch("https://api.web3forms.com/submit", {
        method: "POST",
        body: formData
        });

        const data = await response.json();

        if (data.success) {
        setResult("Form Submitted Successfully");
        event.target.reset();
        } else {
        console.log("Error", data);
        setResult(data.message);
        }
    };
  return (
    <div className='App-contact'>
        <h1>Let's get in touch</h1>
        <div className="App-contact-container">
        <div className="contacts">
            <div className="contact-info">
                <p>Instagram: <a href="https://hacknirvana.openinapp.co/insta" target='blank_'>@hacknirvana_aimlmruh</a></p>
                <p>Email: nispmruh@mallareddyuniversity.ac.in</p>
                <p>Location:</p>
                <iframe title="Malla Reddy University Location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3803.8890264176202!2d78.44627937516894!3d17.560469433356616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb8ff8652b6823%3A0x981713dbb4b708c3!2sMalla%20Reddy%20University!5e0!3m2!1sen!2sin!4v1727342094485!5m2!1sen!2sin" width="300" height="200" allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div className="contact-form">
                <form onSubmit={onSubmit}>
                    <label htmlFor="name">Name:</label> <br />
                    <input type="text" name="name" required /> <br />
                    <label htmlFor="email">Email:</label> <br />
                    <input type="email" name="email" required /> <br />
                    <label htmlFor="message">Message:</label> <br />
                    <textarea name="message" required></textarea> <br />
                    <button>Send</button>
                </form>
                <span>{result}</span>
            </div>
        </div>
        </div>
    </div>
  )
}

export default Contact