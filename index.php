<?php require_once 'includes/config.php'; ?>
<!doctype html>
<html lang="en">

<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>THIGAZH 2K26 | Erode Sengunthar Engineering College</title>
 <!-- Fonts -->
 <link rel="preconnect" href="https://fonts.googleapis.com" />
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
 <link
 href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Montserrat:wght@400;600;800;900&family=Orbitron:wght@500;700;900&display=swap"
 rel="stylesheet" />
 <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
 <!-- Overlay Effects -->
 <div class="halftone-overlay"></div>
 <div class="vignette-overlay"></div>
 <div class="spider-web-overlay"></div>
 <canvas id="particle-canvas"></canvas>

 <!-- Spider-Verse Navigation Animation Canvas -->
 <svg id="nav-web-canvas" class="nav-web-canvas" xmlns="http://www.w3.org/2000/svg"></svg>

 <header class="navbar">
 <div class="nav-logo-container" style="position: relative; display: inline-block">
 <!-- Replace 'logo.png' with your actual image path -->
 <img src="assets/images/logo.png" alt="THIGAZH Logo" class="nav-logo-img" />
 </div>
 <div class="hamburger" id="hamburger">
 <span></span>
 <span></span>
 <span></span>
 </div>
 <nav id="nav-menu">
 <ul>
 <li><a href="#hero">Home</a></li>
 <li><a href="#about">About</a></li>
  <li><a href="#services">Services</a></li>
 <li><a href="#events">Events</a></li>
 <li><a href="#pricing">Passes</a></li>
  <li><a href="#location">Location</a></li>
 <li>
 <a href="#registration" class="highlight-register-nav">Register</a>
 </li>
 </ul>
 </nav>
 </header>

 <main>
 <!-- Hero Section -->
 <section id="hero" class="hero-section">
 <video id="spiderman-vid" autoplay loop muted playsinline>
 <source src="assets/spider-man-marvel-rivals.1920x1080.mp4" type="video/mp4">
 </video>
 <!-- Hero Web Decorators -->
 <!-- Classic Top Center Spider Web -->
 <div class="hero-top-web-container">
 <svg class="top-center-web" viewBox="0 0 500 250" xmlns="http://www.w3.org/2000/svg">
 <g stroke="rgba(255, 255, 255, 0.4)" stroke-width="1.5" fill="none" stroke-linecap="round">
 <!-- Radial threads -->
 <path d="M250,-20 L250,230" />
 <path d="M250,-20 L150,220" />
 <path d="M250,-20 L350,220" />
 <path d="M250,-20 L60,180" />
 <path d="M250,-20 L440,180" />
 <path d="M250,-20 L0,110" />
 <path d="M250,-20 L500,110" />

 <!-- Spiral threads -->
 <path d="M250,30 Q200,35 180,28 Q120,15 80,-10" />
 <path d="M250,30 Q300,35 320,28 Q380,15 420,-10" />

 <path d="M250,70 Q190,80 155,65 Q95,45 35,-5" />
 <path d="M250,70 Q310,80 345,65 Q405,45 465,-5" />

 <path d="M250,120 Q180,135 125,110 Q70,80 0,30" />
 <path d="M250,120 Q320,135 375,110 Q430,80 500,30" />

 <path d="M250,170 Q170,190 105,155 Q45,120 -15,70" />
 <path d="M250,170 Q330,190 395,155 Q455,120 515,70" />
 </g>
 </svg>
 </div>

 <svg class="cyber-web corner-web top-left" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 0 L200 0 L0 200 Z M0 50 Q50 50 50 0 M0 100 Q100 100 100 0 M0 150 Q150 150 150 0" fill="none"
 stroke-width="2" />
 <line x1="0" y1="0" x2="160" y2="40" stroke-width="1" />
 <line x1="0" y1="0" x2="40" y2="160" stroke-width="1" />
 </svg>
 <svg class="cyber-web corner-web bottom-right" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path
 d="M200 200 L0 200 L200 0 Z M200 150 Q150 150 150 200 M200 100 Q100 100 100 200 M200 50 Q50 50 50 200"
 fill="none" stroke-width="2" />
 <line x1="200" y1="200" x2="40" y2="160" stroke-width="1" />
 <line x1="200" y1="200" x2="160" y2="40" stroke-width="1" />
 </svg>

 <div class="hero-content">
 <div class="spider-thread-container">
 <div class="descending-drop">
 <div class="swinging-pendulum">
 <div class="web-thread"></div>
 <!-- Changes here -->
 <h1 class="hero-title metallic-red-text fiery-glow" data-text="THIGAZH 2K26">
 THIGAZH 2K26
 </h1>
 </div>
 </div>
 </div>
 <h2 class="hero-subtitle">
 <span class="white-glow">Organized by the</span> <span class="highlight">School of Computing</span>
 </h2>
 <h3 class="hero-college">Erode Sengunthar Engineering College</h3>
 <div class="hero-date-box">
 <div class="hero-month">APRIL</div>
 <div class="hero-days">01 - 02</div>
 </div>
 <div class="hero-actions">
 <a href="#events" class="btn primary-btn g-btn">EXPLORE EVENTS</a>
 <a href="#registration" class="btn secondary-btn g-btn">REGISTER NOW</a>
 </div>
 </div>
 </section>

 <!-- Web Section Divider -->
 <div class="section-divider">
 <svg class="cyber-web divider-web" viewBox="0 0 1000 50" preserveAspectRatio="none"
 xmlns="http://www.w3.org/2000/svg">
 <path d="M0 25 Q250 0 500 25 T1000 25 M0 0 L1000 0 M0 50 L1000 50" fill="none" stroke-width="1.5"
 opacity="0.3" />
 <line x1="250" y1="0" x2="250" y2="50" stroke-width="1" opacity="0.2" />
 <line x1="500" y1="0" x2="500" y2="50" stroke-width="1" opacity="0.2" />
 <line x1="750" y1="0" x2="750" y2="50" stroke-width="1" opacity="0.2" />
 </svg>
 </div>

 <!-- About Section -->
 <section id="about" class="about-section spider-section">
 <svg class="bg-web bg-web-left" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 0 L200 0 L0 200 Z M0 50 Q50 50 50 0 M0 100 Q100 100 100 0 M0 150 Q150 150 150 0" fill="none"
 stroke-width="2" />
 <line x1="0" y1="0" x2="160" y2="40" stroke-width="1" />
 <line x1="0" y1="0" x2="40" y2="160" stroke-width="1" />
 </svg>
 <svg class="bg-web bg-web-right bg-web-red" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path
 d="M200 200 L0 200 L200 0 Z M200 150 Q150 150 150 200 M200 100 Q100 100 100 200 M200 50 Q50 50 50 200"
 fill="none" stroke-width="2" />
 <line x1="200" y1="200" x2="40" y2="160" stroke-width="1" />
 <line x1="200" y1="200" x2="160" y2="40" stroke-width="1" />
 </svg>
 <div class="container comic-panel">
 <h2 class="section-title" data-text="ABOUT THE EVENT">
 ABOUT THE EVENT
 </h2>

 <div class="about-intro">
 <p class="about-text">
 <strong>THIGAZH 2K26</strong> is a dynamic technical event
 organized under the
 <strong>School of Computing at Erode Sengunthar Engineering
 College</strong>.
 </p>
 <p class="about-text">
 The event is conducted in collaboration with four premier
 departments:
 </p>
 <ul class="dept-list">
 <li>
 <span>&#9658;</span> Computer Science and Engineering (CSE)
 </li>
 <li><span>&#9658;</span> Information Technology (IT)</li>
 <li>
 <span>&#9658;</span> Artificial Intelligence and Data Science
 (AIDS)
 </li>
 <li><span>&#9658;</span> M.Tech Computer Science and Engineering</li>
 </ul>
 <p class="about-text">
 These departments collaboratively conduct technical events as part
 of THIGAZH 2K26, bringing together innovation, coding excellence,
 and creativity.
 </p>
 </div>
 </div>
 </section>


  <!-- Services Section -->
  <section id="services" class="services-section spider-section">
    <svg class="bg-web bg-web-right bg-web-red" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
      <path d="M200 200 L0 200 L200 0 Z M200 150 Q150 150 150 200 M200 100 Q100 100 100 200 M200 50 Q50 50 50 200"
        fill="none" stroke-width="2" />
      <line x1="200" y1="200" x2="40" y2="160" stroke-width="1" />
      <line x1="200" y1="200" x2="160" y2="40" stroke-width="1" />
    </svg>
    <h2 class="section-title glitch" data-text="SERVICES">SERVICES</h2>
    <div class="container services-container">
      <!-- Left: Service Items -->
      <div class="services-list">

        <div class="service-item">
          <div class="service-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <div class="service-text">
            <h3>Certificates</h3>
            <p>All participants will receive a participation certificate. Winners will be awarded cash prizes and exciting prizes.</p>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
              <line x1="9" y1="7" x2="15" y2="7"/>
              <line x1="9" y1="11" x2="15" y2="11"/>
              <line x1="9" y1="15" x2="12" y2="15"/>
            </svg>
          </div>
          <div class="service-text">
            <h3>Registration</h3>
            <p>Online registration will close on March 30th. Spot registration will be available for all events.</p>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
              <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
              <line x1="6" y1="1" x2="6" y2="4"/>
              <line x1="10" y1="1" x2="10" y2="4"/>
              <line x1="14" y1="1" x2="14" y2="4"/>
            </svg>
          </div>
          <div class="service-text">
            <h3>Food will be Provided</h3>
            <p>Refreshment and lunch will be provided for all participants throughout the event.</p>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="3" width="15" height="13" rx="2"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
          <div class="service-text">
            <h3>Transport Facility</h3>
            <p>Transport facilities are arranged for participants at Perundurai Bus Stand from 8 o'clock onwards. Our students will welcome you.</p>
          </div>
        </div>

      </div>
      <!-- Right: College Image -->
      <div class="services-image">
        <img src="assets/images/college.jpg" alt="Erode Sengunthar Engineering College Entrance" class="college-img" />
      </div>
    </div>
  </section>

 <!-- Prize Pool Section -->
 <section id="prize-pool" class="prize-section spider-section">
 <svg class="bg-web bg-web-center" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <circle cx="100" cy="100" r="80" fill="none" stroke-width="1.5" stroke-dasharray="8 8" />
 <circle cx="100" cy="100" r="40" fill="none" stroke-width="1" />
 <circle cx="100" cy="100" r="120" fill="none" stroke-width="1.5" stroke-dasharray="4 12" />
 <path d="M100 -20 L100 220 M-20 100 L220 100 M15 15 L185 185 M15 185 L185 15" fill="none"
 stroke-width="1.5" />
 </svg>
 <div class="container text-center">
 <h2 class="section-title glitch" data-text="TOTAL PRIZE POOL">
 TOTAL PRIZE POOL
 </h2>
 <div class="prize-amount glitch-heavy" data-text="₹75K">
 ₹75K
 </div>
 <p class="prize-subtext">
 Compete in teams of 1 to 4 members to claim ultimate glory.
 </p>
 </div>
 </section>

 <!-- Event Structure Section -->
 <section id="structure" class="structure-section spider-section">
 <svg class="bg-web bg-web-left bg-web-red" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 0 L200 0 L0 200 Z M0 50 Q50 50 50 0 M0 100 Q100 100 100 0 M0 150 Q150 150 150 0" fill="none"
 stroke-width="2" />
 <line x1="0" y1="0" x2="160" y2="40" stroke-width="1" />
 <line x1="0" y1="0" x2="40" y2="160" stroke-width="1" />
 </svg>
 <h2 class="section-title glitch" data-text="EVENT SCHEDULE">
 EVENT SCHEDULE
 </h2>
 <div class="container grid-container">
 <div class="comic-card structure-card day-1">
 <h3>DAY 1</h3>
 <p class="desc">
 Two premier technical events conducted by departments under the
 School of Computing.
 </p>
 <ul class="schedule-list">
 <li><span>Console Craft</span></li>
 <li><span>AI-Verse</span></li>
 </ul>
 </div>
 <div class="comic-card structure-card day-2">
 <h3>DAY 2</h3>
 <p class="desc">
 Three premier technical events conducted by departments under the
 School of Computing.
 </p>
 <ul class="schedule-list">
 <li><span>CODE BŸTE</span></li>
 <li><span>QUANTA</span></li>
 <li><span>SPIDER VAULT</span></li>
 </ul>
 </div>
 </div>
 </section>

 <!-- Events Section -->
 <section id="events" class="events-section spider-section">
 <svg class="bg-web bg-web-right" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path
 d="M200 200 L0 200 L200 0 Z M200 150 Q150 150 150 200 M200 100 Q100 100 100 200 M200 50 Q50 50 50 200"
 fill="none" stroke-width="2" />
 <line x1="200" y1="200" x2="40" y2="160" stroke-width="1" />
 <line x1="200" y1="200" x2="160" y2="40" stroke-width="1" />
 </svg>
 <h2 class="section-title glitch" data-text="TECHNICAL BATTLES">
 TECHNICAL BATTLES
 </h2>
 <div class="container grid-container">

 <!-- Event Card 1: Console Craft -->
 <div class="comic-card event-card" onclick="openModal('modal-consolecraft')">
 <div class="card-content">
 <h3>Console Craft</h3>
 <p class="desc">
 Build functional console-based applications that showcase logic, structure, and problem-solving creativity.
 </p>
 <button class="btn secondary-btn">Explore</button>
 </div>
 </div>

 <!-- Event Card 2: AI-Verse -->
 <div class="comic-card event-card" onclick="openModal('modal-aiverse')">
 <div class="card-content">
 <h3>AI-Verse</h3>
 <p class="desc">
 Design intelligent AI-driven solutions to tackle real-world challenges using machine learning concepts.
 </p>
 <button class="btn secondary-btn">Explore</button>
 </div>
 </div>


 <!-- Event Card 3: CODE BŸTE -->
 <div class="comic-card event-card" onclick="openModal('modal-codebyte')">
 <div class="card-content">
 <h3>CODE BŸTE</h3>
 <p class="desc">
 A high-stakes competitive coding event assessing logical thinking, efficiency, and debugging skills.
 </p>
 <button class="btn secondary-btn">Explore</button>
 </div>
 </div>

 <!-- Event Card 4: QUANTA -->
 <div class="comic-card event-card" onclick="openModal('modal-quanta')">
 <div class="card-content">
 <h3>QUANTA</h3>
 <p class="desc">
 A mind-bending technical quiz spanning algorithms, data structures, AI, and emerging technologies.
 </p>
 <button class="btn secondary-btn">Explore</button>
 </div>
 </div>

 <!-- Event Card 5: SPIDER VAULT -->
 <div class="comic-card event-card" onclick="openModal('modal-spidervault')">
 <div class="card-content">
 <h3>SPIDER VAULT</h3>
 <p class="desc">
 Crack the code, reverse-engineer hidden logic, and escape the Spider Vault in this thrilling challenge.
 </p>
 <button class="btn secondary-btn">Explore</button>
 </div>
 </div>
 </div>
 </section>

 <!-- Web Section Divider -->
 <div class="section-divider">
 <svg class="cyber-web divider-web" viewBox="0 0 1000 50" preserveAspectRatio="none"
 xmlns="http://www.w3.org/2000/svg">
 <path d="M0 25 Q250 50 500 25 T1000 25 M0 0 L1000 0 M0 50 L1000 50" fill="none" stroke-width="1.5"
 opacity="0.3" />
 <line x1="250" y1="0" x2="250" y2="50" stroke-width="1" opacity="0.2" />
 <line x1="500" y1="0" x2="500" y2="50" stroke-width="1" opacity="0.2" />
 <line x1="750" y1="0" x2="750" y2="50" stroke-width="1" opacity="0.2" />
 </svg>
 </div>

 <!-- Events Section ends here. Removed Gallery. -->

 <!-- Pricing Section -->
 <section id="pricing" class="pricing-section spider-section">
 <svg class="bg-web bg-web-center" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <circle cx="100" cy="100" r="80" fill="none" stroke-width="1.5" stroke-dasharray="8 8" />
 <circle cx="100" cy="100" r="40" fill="none" stroke-width="1" />
 <path d="M100 -20 L100 220 M-20 100 L220 100 M15 15 L185 185 M15 185 L185 15" fill="none"
 stroke-width="1.5" />
 </svg>
 <h2 class="section-title glitch" data-text="GET YOUR PASS">
 GET YOUR PASS
 </h2>
 <div class="container flex-container">
 <!-- Pass 1 -->
 <div class="comic-card pass-card standard-pass">
 <h3>ROYAL PASS</h3>
 <div class="animated-price">
 ₹250 <span class="per-head">/head</span>
 </div>
 <div class="price" style="font-size: 1.2rem; margin-bottom: 1rem">
 1 EVENT
 </div>
 <p>Access to ANY single event of your choice.</p>
 <a href="#registration" class="btn secondary-btn" onclick="selectPass('royal')">Select Royal</a>
 </div>

 <!-- Pass 2 -->
 <div class="comic-card pass-card royal-pass premium-glow">
 <h3>ELITE PASS</h3>
 <div class="animated-price elite-animated-price">
 ₹400 <span class="per-head">/head</span>
 </div>
 <div class="price" style="font-size: 1.2rem; margin-bottom: 1rem">
 2 EVENTS
 </div>
 <p>Access to ONE event on Day 1 and ONE event on Day 2.</p>
 <a href="#registration" class="btn primary-btn g-btn" onclick="selectPass('elite')">Select Elite</a>
 </div>
 </div>
 </section>

 <!-- Registration Section -->
 <section id="registration" class="registration-section spider-section">
 <svg class="bg-web bg-web-left bg-web-red" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 0 L200 0 L0 200 Z M0 50 Q50 50 50 0 M0 100 Q100 100 100 0 M0 150 Q150 150 150 0" fill="none"
 stroke-width="2" />
 <line x1="0" y1="0" x2="160" y2="40" stroke-width="1" />
 <line x1="0" y1="0" x2="40" y2="160" stroke-width="1" />
 </svg>
 <svg class="bg-web bg-web-right" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <path
 d="M200 200 L0 200 L200 0 Z M200 150 Q150 150 150 200 M200 100 Q100 100 100 200 M200 50 Q50 50 50 200"
 fill="none" stroke-width="2" />
 <line x1="200" y1="200" x2="40" y2="160" stroke-width="1" />
 <line x1="200" y1="200" x2="160" y2="40" stroke-width="1" />
 </svg>
 <h2 class="section-title" data-text="SQUAD REGISTRATION">
 SQUAD REGISTRATION
 </h2>
 <div class="container form-container comic-panel">
 <form id="regForm" action="register.php" method="POST">
 <div class="input-group">
 <label for="team_name">Team Name</label>
 <input type="text" id="team_name" name="team_name" required placeholder="e.g. Web-Slingers" />
 </div>

 <div class="input-group">
 <label for="college">College Name</label>
 <input type="text" id="college" name="college" required
 placeholder="Erode Sengunthar Engineering College" />
 </div>

 <div class="input-group">
 <label for="department">Department</label>
 <input type="text" id="department" name="department" required placeholder="e.g. CSE" />
 </div>

 <h3 class="form-subtitle">Team Members (1-4 Members)</h3>

 <div class="input-group">
 <label for="leader_name">Team Leader Name (Required)</label>
 <input type="text" id="leader_name" name="leader_name" required />
 </div>

 <div class="input-group grid-2">
 <div>
 <label for="member2">Member 2 Name (Optional)</label>
 <input type="text" id="member2" name="member2" />
 </div>
 <div>
 <label for="member2_phone">Member 2 Phone (Optional)</label>
 <input type="tel" id="member2_phone" name="member2_phone" />
 </div>
 </div>

 <div class="input-group grid-2">
 <div>
 <label for="member3">Member 3 Name (Optional)</label>
 <input type="text" id="member3" name="member3" />
 </div>
 <div>
 <label for="member4">Member 4 Name (Optional)</label>
 <input type="text" id="member4" name="member4" />
 </div>
 </div>

 <h3 class="form-subtitle">Contact Details (Leader)</h3>
 <div class="input-group grid-2">
 <div>
 <label for="phone">Phone Number</label>
 <input type="tel" id="phone" name="phone" required />
 </div>
 <div>
 <label for="email">Email Address</label>
 <input type="email" id="email" name="email" required />
 </div>
 </div>

 <h3 class="form-subtitle">Accommodation Options</h3>
 <div class="comic-panel" style="
 padding: 1.5rem;
 margin-bottom: 2rem;
 border-color: var(--metallic-silver);
 box-shadow: 4px 4px 0px #555;
 ">
 <p style="
 color: var(--text-light);
 font-size: 1rem;
 margin-bottom: 0.5rem;
 ">
 <strong>Need a place to stay?</strong>
 </p>
 <p style="
 color: var(--text-muted);
 font-size: 0.9rem;
 line-height: 1.5;
 ">
 Accommodation is available for long-distance participants.
 Please note that accommodation charges apply separately and are
 not included in the event registration fee. Prices will be
 disclosed upon arrival at the college.
 </p>
 </div>

 <div class="input-group">
 <label for="pass_type">Select Pass Type</label>
 <select id="pass_type" name="pass_type" required onchange="updateEventSelects()">
 <option value="">-- Select Pass --</option>
 <option value="royal">Royal Pass (1 Event)</option>
 <option value="elite">
 Elite Pass (2 Events - One from each day)
 </option>
 </select>
 </div>

 <div id="events-selection-area">
 <!-- Populated by JS -->
 </div>

 <div class="live-total-box comic-panel" style="
 padding: 1.5rem;
 margin: 2rem 0;
 border-color: var(--neon-red);
 text-align: center;
 ">
 <h3 style="
 color: var(--text-light);
 font-size: 1.1rem;
 margin-bottom: 0.5rem;
 font-family: var(--font-ui);
 ">
 Total Amount to Pay
 </h3>
 <div id="live-total" style="
 font-size: 2.8rem;
 color: var(--neon-red);
 font-family: var(--font-heading);
 text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
 ">
 ₹0
 </div>
 </div>

 <button type="submit" class="btn submit-btn primary-btn g-btn">
 Proceed to Payment
 </button>
 <div id="form-msg"></div>
 </form>
 </div>
 </section>

  <!-- Location Section -->
  <section id="location" class="location-section spider-section">
    <svg class="bg-web bg-web-left bg-web-red" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 0 L200 0 L0 200 Z M0 50 Q50 50 50 0 M0 100 Q100 100 100 0 M0 150 Q150 150 150 0" fill="none"
        stroke-width="2" />
      <line x1="0" y1="0" x2="160" y2="40" stroke-width="1" />
      <line x1="0" y1="0" x2="40" y2="160" stroke-width="1" />
    </svg>
    <h2 class="section-title glitch" data-text="FIND US">FIND US</h2>
    <div class="container location-container">
      <div class="location-info">
        <h3 class="location-college-name">Erode Sengunthar Engineering College</h3>
        <p class="location-address">Thudupathi, Perundurai, Erode &mdash; 638057</p>
        <p class="location-address">Tamil Nadu, India</p>
        <div class="location-details">
          <div class="location-detail-item">
            <svg class="loc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>Near Perundurai Bus Stand (~5 km)</span>
          </div>
          <div class="location-detail-item">
            <svg class="loc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="1" y="3" width="15" height="13" rx="2"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
            <span>Transport arranged from Perundurai Bus Stand</span>
          </div>
        </div>
      </div>
      <div class="location-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3912.296622868653!2d77.54792207502607!3d11.313016388870212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba9132f4f89e445%3A0x81f682bd38f8a702!2sErode%20Sengunthar%20Engineering%20College!5e0!3m2!1sen!2sin!4v1773234503822!5m2!1sen!2sin"
          width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Erode Sengunthar Engineering College Map">
        </iframe>
      </div>
    </div>
  </section>

 </main>

 <footer class="main-footer">
 <div class="footer-container">
 <div class="footer-college-info">
 <h3 class="footer-title">Erode Sengunthar Engineering College</h3>
 <p>Thudupathi, Perundurai, Erode - 638057</p>
 <p>Tamil Nadu, India</p>
 </div>
 <div class="footer-contacts">
 <div class="contact-group">
 <h4>Staff Coordinators</h4>
 <p>Dr. Example Name (CSE) - 9876543210</p>
 <p>Prof. Example Name (IT) - 9876543211</p>
 </div>
 <div class="contact-group">
 <h4>Student Coordinators</h4>
 <p>Student Name 1 - 9876543212</p>
 <p>Student Name 2 - 9876543213</p>
 </div>
 </div>
 </div>
 <div class="footer-bottom">
 <p>
 &copy; 2026 THIGAZH | School of Computing | Erode Sengunthar
 Engineering College.
 </p>
 </div>
 </footer>

 <!-- Modals -->

 <!-- Modal: Console Craft (Day 1) -->
 <div id="modal-consolecraft" class="modal">
 <div class="modal-content comic-panel">
 <span class="close" onclick="closeModal('modal-consolecraft')">&times;</span>
 <h2 class="glitch" data-text="Console Craft">Console Craft</h2>
 <div class="modal-body">
 <div class="poster consolecraft-poster"></div>
 <div class="details">
 <p><strong>Description:</strong> Build functional console-based applications that showcase logic, structure, and programming creativity under time pressure.</p>
 <p><strong>Structure:</strong> Participants will be given problem statements and must develop a working console application within the allotted time.</p>
 <p><strong>Evaluates:</strong> Programming logic, code quality, problem-solving approach, and application completeness.</p>
 <p><strong>Team Size:</strong> 1 - 4 Members</p>
 <p><strong>Schedule:</strong> Day 1</p>
 <p><strong>Prize Pool Share:</strong> Part of the &#8377;100k overall pool.</p>
 <p><strong>Contact:</strong> Coordinator (9876543210)</p>
 <a href="#registration" class="btn primary-btn"
 onclick="preSelectEvent('console_craft', 'royal'); closeModal('modal-consolecraft')">Register for this Event</a>
 </div>
 </div>
 </div>
 </div>

 <!-- Modal: AI-Verse (Day 1) -->
 <div id="modal-aiverse" class="modal">
 <div class="modal-content comic-panel">
 <span class="close" onclick="closeModal('modal-aiverse')">&times;</span>
 <h2 class="glitch" data-text="AI-Verse">AI-Verse</h2>
 <div class="modal-body">
 <div class="poster aiverse-poster"></div>
 <div class="details">
 <p><strong>Description:</strong> Design intelligent AI-driven solutions to tackle real-world challenges using machine learning concepts and responsible AI principles.</p>
 <p><strong>Structure:</strong> Teams analyze a problem statement and design an intelligent model or prototype capable of generating meaningful insights or predictions.</p>
 <p><strong>Evaluates:</strong> Innovation, AI model approach, technical implementation, and quality of inferences produced.</p>
 <p><strong>Team Size:</strong> 1 - 4 Members</p>
 <p><strong>Schedule:</strong> Day 1</p>
 <p><strong>Prize Pool Share:</strong> Part of the &#8377;100k overall pool.</p>
 <p><strong>Contact:</strong> Coordinator (9876543211)</p>
 <a href="#registration" class="btn primary-btn"
 onclick="preSelectEvent('ai_verse', 'royal'); closeModal('modal-aiverse')">Register for this Event</a>
 </div>
 </div>
 </div>
 </div>

 <!-- Modal: CODE BŸTE (Day 2) -->
 <div id="modal-codebyte" class="modal">
 <div class="modal-content comic-panel">
 <span class="close" onclick="closeModal('modal-codebyte')">&times;</span>
 <h2 class="glitch" data-text="CODE BŸTE">CODE BŸTE</h2>
 <div class="modal-body">
 <div class="poster codebyte-poster"></div>
 <div class="details">
 <div style="background: rgba(220,20,60,0.08); border-left: 3px solid var(--neon-red); border-radius: 6px; padding: 1rem 1.2rem; margin-bottom: 1.2rem; font-size: 0.88rem; line-height: 1.75; color: var(--text-light);">
 <p style="margin:0 0 0.5rem;">🕸️ <strong>Hey Coders! Your Friendly Neighborhood Spider-Man Here!</strong></p>
 <p style="margin:0 0 0.5rem;">This mission is strictly <strong>SOLO</strong>. Just you and your brain! 🧠</p>
 <p style="margin:0 0 0.3rem;">🕷️ <strong>Rules from the Web:</strong></p>
 <ul style="margin:0 0 0.5rem 1.3rem; padding:0;">
 <li>Individual participation only — prove your own superpowers!</li>
 <li>3 thrilling rounds to test your logic, speed, and coding instincts.</li>
 <li>Allowed languages: <strong>C, C++, Python, or Java</strong>.</li>
 </ul>
 <p style="margin:0;"><em>With great power comes great responsibility</em> — and a lot of fun! 🕸️</p>
 </div>
 <p><strong>Description:</strong> A competitive coding event designed to test participants' programming and problem-solving abilities.</p>
 <p><strong>Structure:</strong> Three challenging rounds covering problem analysis, algorithm design, and optimized code writing.</p>
 <p><strong>Evaluates:</strong> Logical thinking, efficiency, and debugging.</p>
 <p><strong>Team Size:</strong> 1 (Solo only)</p>
 <p><strong>Schedule:</strong> Day 2</p>
 <p><strong>Prize Pool Share:</strong> Part of the &#8377;100k overall pool.</p>
 <p><strong>Contact:</strong> Coordinator (9876543212)</p>
 <a href="#registration" class="btn primary-btn"
 onclick="preSelectEvent('codebyte', 'royal'); closeModal('modal-codebyte')">Register for this Event</a>
 </div>
 </div>
 </div>
 </div>

 <!-- Modal: QUANTA (Day 2) -->
 <div id="modal-quanta" class="modal">
 <div class="modal-content comic-panel">
 <span class="close" onclick="closeModal('modal-quanta')">&times;</span>
 <h2 class="glitch" data-text="QUANTA">QUANTA</h2>
 <div class="modal-body">
 <div class="poster quanta-poster"></div>
 <div class="details">
 <p><strong>Description:</strong> A mind-bending technical quiz spanning algorithms, data structures, AI, networking, and emerging technologies.</p>
 <p><strong>Structure:</strong> Multiple rounds of rapid-fire questions, puzzles, and technical challenges that test breadth and depth of knowledge.</p>
 <p><strong>Evaluates:</strong> Technical knowledge, speed of recall, problem-solving under pressure.</p>
 <p><strong>Team Size:</strong> 1 - 4 Members</p>
 <p><strong>Schedule:</strong> Day 2</p>
 <p><strong>Prize Pool Share:</strong> Part of the &#8377;100k overall pool.</p>
 <p><strong>Contact:</strong> Coordinator (9876543213)</p>
 <a href="#registration" class="btn primary-btn"
 onclick="preSelectEvent('quanta', 'royal'); closeModal('modal-quanta')">Register for this Event</a>
 </div>
 </div>
 </div>
 </div>

 <!-- Modal: SPIDER VAULT (Day 2) -->
 <div id="modal-spidervault" class="modal">
 <div class="modal-content comic-panel">
 <span class="close" onclick="closeModal('modal-spidervault')">&times;</span>
 <h2 class="glitch" data-text="SPIDER VAULT">SPIDER VAULT</h2>
 <div class="modal-body">
 <div class="poster spidervault-poster"></div>
 <div class="details">
 <p><strong>Description:</strong> Crack the code, reverse-engineer hidden logic, and escape the Spider Vault in this thrilling cryptography and reverse-engineering challenge.</p>
 <p><strong>Structure:</strong> Participants investigate patterns, decode encrypted data, and reconstruct the original approach through analytical reasoning.</p>
 <p><strong>Evaluates:</strong> Problem-solving ability, debugging skills, logical reasoning, and accuracy of the reconstructed solution.</p>
 <p><strong>Team Size:</strong> 1 - 4 Members</p>
 <p><strong>Schedule:</strong> Day 2</p>
 <p><strong>Prize Pool Share:</strong> Part of the &#8377;100k overall pool.</p>
 <p><strong>Contact:</strong> Coordinator (9876543214)</p>
 <a href="#registration" class="btn primary-btn"
 onclick="preSelectEvent('spider_vault', 'royal'); closeModal('modal-spidervault')">Register for this Event</a>
 </div>
 </div>
 </div>
 </div>
 <!-- Script -->
 <script src="assets/js/script.js"></script>
</body>

</html>