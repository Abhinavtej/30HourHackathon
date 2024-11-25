const domainsData = {
  "AI in Education": [
    { id: "HN-ED01", title: "AI-Driven Adaptive Learning System", description: "Create a system that uses AI to adapt course content and difficulty based on the learner’s performance, offering personalized lessons, quizzes, and feedback." },
    { id: "HN-ED02", title: "Automated Student Assessment and Feedback System", description: "Build a platform that leverages AI for automatic grading and provides personalized feedback, helping instructors save time and giving students quicker evaluations." },
    { id: "HN-ED03", title: "AI-Powered Tutoring System", description: "Develop an AI-based tutoring assistant that can help students with homework by providing explanations, answering questions, and offering practice problems." },
    { id: "HN-ED04", title: "Intelligent Career Guidance System", description: "Build an AI tool that analyzes students' skills, interests, and academic performance to suggest potential career paths and recommend courses for skill development." },
    { id: "HN-ED05", title: "AI-Based Virtual Classroom Assistant", description: "Design a virtual assistant that can facilitate live classes, answer student queries, and automate administrative tasks, enhancing both teaching and learning experiences." },
    { id: "HN-ED06", title: "AI-Powered Language Learning Assistant", description: "Develop an AI-based assistant for language learners, offering real-time translation, vocabulary suggestions, and personalized learning paths based on the user's proficiency." },
    { id: "HN-ED07", title: "AI-Driven Classroom Engagement System", description: "Create a system that uses AI to monitor student engagement levels during online and in-person classes, providing feedback to instructors on student participation." }
  ],
  "Fintech": [
    { id: "HN-FT01", title: "Digital Identity Verification and Fraud Prevention System", description: "Implement a secure digital identity verification system powered by AI and blockchain to prevent fraud in financial services and ensure the integrity of transactions." },
    { id: "HN-FT02", title: "AI-driven Personal Financial Assistant", description: "Develop an AI-driven assistant that helps individuals manage personal finances, offering budgeting tools, investment recommendations, and real-time spending analysis." },
    { id: "HN-FT03", title: "Blockchain-based Cross-Border Payment System", description: "Create a decentralized payment system using blockchain technology that allows secure and instant cross-border payments with lower transaction fees." },
    { id: "HN-FT04", title: "Personalized Investment Portfolio Management", description: "Develop a tool that uses AI to analyze financial data and create customized investment portfolios for users based on their risk preferences, financial goals, and market trends." },
    { id: "HN-FT05", title: "Smart Contract-based Loan and Credit System", description: "Build a system that utilizes smart contracts to automate the lending process, ensuring transparency, reducing paperwork, and improving loan approval speed." },
    { id: "HN-FT06", title: "AI-Powered Risk Management System", description: "Develop an AI system that analyzes financial markets to detect potential risks, helping businesses and individuals make informed decisions on risk mitigation strategies." },
    { id: "HN-FT07", title: "Blockchain for Transparent Charity Donations", description: "Create a blockchain-based platform to ensure transparency in charity donations, allowing donors to track how funds are being utilized in real-time." }
  ],
  "Healthcare": [
    { id: "HN-HC01", title: "Queuing Models in OPDs/Availability of Beds", description: "Implement a system based on queuing theory to optimize patient flow in outpatient departments (OPDs) and hospital bed allocation, improving efficiency and reducing waiting times." },
    { id: "HN-HC02", title: "Online Testing and Monitoring of Quality of Medicines", description: "Create a system for testing and monitoring the quality of medicines online, ensuring compliance with regulatory standards and detecting counterfeit drugs." },
    { id: "HN-HC03", title: "Health Data Information & Management System", description: "Develop a platform that allows healthcare providers to securely store and manage patient health records, facilitating easy access, sharing, and analysis." },
    { id: "HN-HC04", title: "Drug Inventory and Supply Chain Tracking System", description: "Implement an AI-powered system to monitor drug inventory levels, track supply chain movements, and predict shortages, reducing wastage and ensuring timely restocking." },
    { id: "HN-HC05", title: "AYUSH Startup Registration Portal", description: "Create a comprehensive registration portal for AYUSH startups, offering features like document submission, licensing information, and compliance tracking." },
    { id: "HN-HC06", title: "AI-Powered Diagnostic Assistant", description: "Develop an AI-based diagnostic assistant that helps doctors interpret medical test results, providing potential diagnoses and treatment options based on historical data." },
    { id: "HN-HC07", title: "Telemedicine and Remote Patient Monitoring System", description: "Create a telemedicine platform with remote patient monitoring capabilities, enabling doctors to assess patients' health from a distance using real-time data from wearable devices." }
  ],
  "Smart Agriculture": [
    { id: "HN-AG01", title: "AI-Driven Crop Disease Prediction and Management System", description: "Develop an AI-powered system that analyzes crop images and environmental data to detect diseases early, providing farmers with actionable insights and treatment recommendations via a web app." },
    { id: "HN-AG02", title: "Real-Time AI-Powered Autonomous Weed Management System", description: "Create an AI-driven solution that autonomously identifies and eliminates weeds in crop fields using image recognition and robotics." },
    { id: "HN-AG03", title: "AI-Powered Precision Irrigation System", description: "Build a system that uses weather forecasting, soil moisture data, and AI to optimize irrigation schedules and water usage for crops, reducing waste and improving yields." },
    { id: "HN-AG04", title: "Deep Learning for Predicting and Mitigating the Impact of Extreme Weather Events", description: "Design a deep learning system to predict extreme weather events such as droughts and floods, helping farmers take preventive actions to mitigate their effects on crops." },
    { id: "HN-AG05", title: "AI-Enhanced Autonomous Harvesting and Post-Harvest Handling System", description: "Develop an AI-powered robotic system for harvesting crops and handling post-harvest processes like sorting, packing, and transportation, improving efficiency and reducing labor costs." },
    { id: "HN-AG06", title: "AI-Driven Pest Control System", description: "Create an AI-based system that detects and manages pest infestations in crops, using image recognition and environmental data to recommend targeted pest control measures." },
    { id: "HN-AG07", title: "AI-Powered Crop Yield Prediction System", description: "Develop an AI tool that predicts crop yields based on factors like weather, soil conditions, and historical data, helping farmers plan and optimize their harvests." }
  ],
  "Smart Automation": [
    { id: "HN-SA01", title: "Intelligent Traffic Management System", description: "Develop an AI-powered system that analyzes traffic data to optimize traffic flow, reduce congestion, and improve road safety." },
    { id: "HN-SA02", title: "AI-Based Smart Parking Solution", description: "Create a system that uses AI to manage parking spaces, directing drivers to available spots in real-time and reducing the time spent looking for parking." },
    { id: "HN-SA03", title: "Automated Warehouse Management System", description: "Implement an AI-based system for managing warehouse inventory, automating tasks such as sorting, packaging, and tracking goods to improve efficiency and reduce errors." },
    { id: "HN-SA04", title: "AI-Powered Smart Home Automation System", description: "Design a system that integrates AI with IoT devices to automate home functions such as lighting, temperature control, and security, optimizing energy use and enhancing user comfort." },
    { id: "HN-SA05", title: "Robotic Process Automation (RPA) for Business Processes", description: "Build a platform that uses RPA to automate routine business tasks such as data entry, invoicing, and customer support, improving efficiency and reducing human error." },
    { id: "HN-SA06", title: "AI-Powered Predictive Maintenance System", description: "Develop a system that uses AI to predict when machinery will need maintenance, reducing downtime and preventing costly repairs in industrial settings." },
    { id: "HN-SA07", title: "AI-Based Energy Management System", description: "Create a system that uses AI to optimize energy consumption in buildings and factories, reducing energy costs and minimizing environmental impact." }
  ]
};

export default domainsData;
