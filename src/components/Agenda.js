import React, { useState, useEffect } from 'react';
import './css/Agenda.css';
import events from '../assets/agenda.js';

const Agenda = () => {
  const [scrollProgress, setScrollProgress] = useState(0);
  const [activeIndex, setActiveIndex] = useState(-1);

  useEffect(() => {
    const handleScroll = () => {
      const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
      const progress = (window.scrollY / totalHeight) * 100;
      setScrollProgress(progress);

      const timelineItems = document.querySelectorAll('.timeline-item');
      let active = -1;

      timelineItems.forEach((item, index) => {
        const rect = item.getBoundingClientRect();
        const topInView = rect.top <= window.innerHeight * 0.75;
        const bottomInView = rect.bottom >= window.innerHeight * 0.25;

        if (topInView && bottomInView) {
          active = index;
        }
      });

      setActiveIndex(active);
    };

    window.addEventListener('scroll', handleScroll);
    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []);

  return (
    <div className="agenda-container">
      <div className="timeline">
        <div
          className="timeline-progress"
          style={{
            height: `${scrollProgress}%`,
          }}
        ></div>

        {events.map((event, index) =>
          event.isDayHeader ? (
            <div key={index} className="timeline-day-header">
              <h2>{event.title}</h2>
            </div>
          ) : (
            <div
              key={index}
              className={`timeline-item ${index % 2 === 0 ? 'left' : 'right'} ${
                index === activeIndex ? 'active' : ''
              }`}
            >
              {index < events.length && (
                <div
                  className="timeline-line"
                  style={{
                    width: 'calc(50% - 30px)',
                  }}
                ></div>
              )}

              <div className="timeline-item-content">
                <div className="timeline-item-details">
                  <h3>{event.title}</h3>
                  <p className="timeline-item-time">{event.time}</p>
                </div>
              </div>
            </div>
          )
        )}
      </div>
    </div>
  );
};

export default Agenda;
