import React, { useState } from 'react';

function MyComponent() {
  const [x, setX] = useState(0);

  return (
    <div>
      <input type="number" value={x} onChange={(e) => setX(e.target.value)} />
      {x < 10 ? "hello" : "goodbye"}
    </div>
  );
}