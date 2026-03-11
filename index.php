<?php require_once 'config.php'; ?>
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
    <link rel="stylesheet" href="style.css" />
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
            <img src="images/logo.png" alt="THIGAZH Logo" class="nav-logo-img" />
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
                <li><a href="#events">Events</a></li>
                <li><a href="#pricing">Passes</a></li>
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
                <source src="spider-man-marvel-rivals.1920x1080.mp4" type="video/mp4">
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
                        <li><span>&#9658;</span> M.Tech Computer Science</li>
                    </ul>
                    <p class="about-text">
                        These departments collaboratively conduct technical events as part
                        of THIGAZH 2K26, bringing together innovation, coding excellence,
                        and creativity.
                    </p>
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
                <div class="prize-amount glitch-heavy" data-text="₹100K">
                    ₹100K
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
                        <li><span>Codeathon</span></li>
                        <li><span>Project Expo</span></li>
                    </ul>
                </div>
                <div class="comic-card structure-card day-2">
                    <h3>DAY 2</h3>
                    <p class="desc">
                        Two premier technical events conducted by departments under the
                        School of Computing.
                    </p>
                    <ul class="schedule-list">
                        <li><span>Console-Based App</span></li>
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
                <!-- Event Card 1 -->
                <div class="comic-card event-card" onclick="openModal('modal-cse')">
                    <div class="card-content">
                        <h3>Codeathon</h3>
                        <p class="desc">
                            A high-stakes competitive coding event assessing logical
                            thinking, efficiency, and debugging.
                        </p>
                        <button class="btn secondary-btn">Explore</button>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="comic-card event-card" onclick="openModal('modal-it')">
                    <div class="card-content">
                        <h3>Project Expo</h3>
                        <p class="desc">
                            Showcase your innovative technical projects and practical
                            real-world applications.
                        </p>
                        <button class="btn secondary-btn">Explore</button>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="comic-card event-card" onclick="openModal('modal-aids')">
                    <div class="card-content">
                        <h3>Console-Based App</h3>
                        <p class="desc">
                            Develop functional console software focusing on logic building
                            and system design.
                        </p>
                        <button class="btn secondary-btn">Explore</button>
                    </div>
                </div>



                <!-- Event Card 5 -->
                <div class="comic-card event-card" onclick="openModal('modal-mindsynth')">
                    <div class="card-content">
                        <h3>Intelligent Solution Design (MindSynth)</h3>
                        <p class="desc">
                            Develop AI-driven solutions to solve real-world problems using machine learning concepts and
                            responsible AI guardrails.
                        </p>
                        <button class="btn secondary-btn">Explore</button>
                    </div>
                </div>

                <!-- Event Card 6 -->
                <div class="comic-card event-card" onclick="openModal('modal-arachnid')">
                    <div class="card-content">
                        <h3>Reverse Engineering Challenge (Arachnid Cipher)</h3>
                        <p class="desc">
                            Analyze given outputs, datasets, or code fragments to identify the underlying logic or
                            algorithm used to generate them.
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
    <!-- CSE Modal -->
    <div id="modal-cse" class="modal">
        <div class="modal-content comic-panel">
            <span class="close" onclick="closeModal('modal-cse')">&times;</span>
            <h2 class="glitch" data-text="Codeathon 💻">Codeathon</h2>
            <div class="modal-body">
                <div class="poster cse-poster"></div>
                <div class="details">
                    <p>
                        <strong>Description:</strong> A competitive coding event designed
                        to test participants’ programming and problem-solving abilities.
                    </p>
                    <p>
                        <strong>Structure:</strong> Consists of three challenging rounds
                        analyzing problems, developing algorithms, and writing optimized
                        code.
                    </p>
                    <p>
                        <strong>Evaluates:</strong> Logical thinking, efficiency, and
                        debugging.
                    </p>
                    <p><strong>Team Size:</strong> 1 - 4 Members</p>
                    <p><strong>Schedule:</strong> Day 1</p>
                    <p>
                        <strong>Prize Pool Share:</strong> Part of the ₹60k overall pool.
                    </p>
                    <p><strong>Contact:</strong> Coordinator (9876543210)</p>
                    <a href="#registration" class="btn primary-btn"
                        onclick="preSelectEvent('codeathon', 'royal'); closeModal('modal-cse')">Register for this
                        Event</a>
                </div>
            </div>
        </div>
    </div>

    <!-- IT Modal -->
    <div id="modal-it" class="modal">
        <div class="modal-content comic-panel">
            <span class="close" onclick="closeModal('modal-it')">&times;</span>
            <h2 class="glitch" data-text="Project Expo 🚀">Project Expo</h2>
            <div class="modal-body">
                <div class="poster it-poster"></div>
                <div class="details">
                    <p>
                        <strong>Description:</strong> A platform for teams to showcase
                        their innovative technical projects and ideas.
                    </p>
                    <p>
                        <strong>Structure:</strong> Present the concept, design, and
                        practical applications of your project.
                    </p>
                    <p>
                        <strong>Evaluates:</strong> Innovation, usability, feasibility,
                        and real-world impact.
                    </p>
                    <p><strong>Team Size:</strong> 1 - 4 Members</p>
                    <p><strong>Schedule:</strong> Day 1</p>
                    <p>
                        <strong>Prize Pool Share:</strong> Part of the ₹60k overall pool.
                    </p>
                    <p><strong>Contact:</strong> Coordinator (9876543211)</p>
                    <a href="#registration" class="btn primary-btn"
                        onclick="preSelectEvent('project_expo', 'royal'); closeModal('modal-it')">Register for this
                        Event</a>
                </div>
            </div>
        </div>
    </div>

    <!-- AIDS Modal -->
    <div id="modal-aids" class="modal">
        <div class="modal-content comic-panel">
            <span class="close" onclick="closeModal('modal-aids')">&times;</span>
            <h2 class="glitch" data-text="Console-Based App">Console-Based App</h2>
            <div class="modal-body">
                <div class="poster aids-poster"></div>
                <div class="details">
                    <p>
                        <strong>Description:</strong> Develop functional console-based
                        software applications focusing on structured problem solving.
                    </p>
                    <p>
                        <strong>Structure:</strong> Design and build applications using
                        core programming logic and system design formatting.
                    </p>
                    <p>
                        <strong>Evaluates:</strong> Ability to convert concepts into
                        working solutions.
                    </p>
                    <p><strong>Team Size:</strong> 1 - 4 Members</p>
                    <p><strong>Schedule:</strong> Day 2</p>
                    <p>
                        <strong>Prize Pool Share:</strong> Part of the ₹60k overall pool.
                    </p>
                    <p><strong>Contact:</strong> Coordinator (9876543212)</p>
                    <a href="#registration" class="btn primary-btn"
                        onclick="preSelectEvent('console_app', 'royal'); closeModal('modal-aids')">Register for this
                        Event</a>
                </div>
            </div>
        </div>
    </div>



    <!-- MindSynth Modal -->
    <div id="modal-mindsynth" class="modal">
        <div class="modal-content comic-panel">
            <span class="close" onclick="closeModal('modal-mindsynth')">&times;</span>
            <h2 data-text="Intelligent Solution Design">Intelligent Solution Design (MindSynth)</h2>
            <div class="modal-body">
                <div class="poster mindsynth-poster"></div>
                <div class="details">
                    <p>
                        <strong>Description:</strong> Develop AI-driven solutions to solve real-world problems using
                        machine learning concepts and responsible AI guardrails.
                    </p>
                    <p>
                        <strong>Structure:</strong> Teams analyze the problem statement and design an intelligent model
                        or prototype capable of generating meaningful insights or predictions.
                    </p>
                    <p>
                        <strong>Evaluates:</strong> Innovation, AI model approach, technical implementation, and the
                        quality of inferences produced.
                    </p>
                    <p><strong>Team Size:</strong> 1 - 4 Members</p>
                    <p><strong>Schedule:</strong> Day 1</p>
                    <p>
                        <strong>Prize Pool Share:</strong> Part of the ₹60k overall pool.
                    </p>
                    <p><strong>Contact:</strong> Coordinator (9876543212)</p>
                    <a href="#registration" class="btn primary-btn"
                        onclick="preSelectEvent('mindsynth', 'royal'); closeModal('modal-mindsynth')">Register for this
                        Event</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Arachnid Cipher Modal -->
    <div id="modal-arachnid" class="modal">
        <div class="modal-content comic-panel">
            <span class="close" onclick="closeModal('modal-arachnid')">&times;</span>
            <h2 data-text="Reverse Engineering Challenge">Reverse Engineering Challenge (Arachnid Cipher)</h2>
            <div class="modal-body">
                <div class="poster arachnid-poster"></div>
                <div class="details">
                    <p>
                        <strong>Description:</strong> Analyze given outputs, datasets, or code fragments to identify the
                        underlying logic or algorithm used to generate them.
                    </p>
                    <p>
                        <strong>Structure:</strong> Participants investigate patterns, debug code, and reconstruct the
                        original approach through analytical reasoning.
                    </p>
                    <p>
                        <strong>Evaluates:</strong> Problem-solving ability, debugging skills, logical reasoning, and
                        accuracy of the reconstructed solution.
                    </p>
                    <p><strong>Team Size:</strong> 1 - 4 Members</p>
                    <p><strong>Schedule:</strong> Day 2</p>
                    <p>
                        <strong>Prize Pool Share:</strong> Part of the ₹60k overall pool.
                    </p>
                    <p><strong>Contact:</strong> Coordinator (9876543212)</p>
                    <a href="#registration" class="btn primary-btn"
                        onclick="preSelectEvent('arachnid', 'royal'); closeModal('modal-arachnid')">Register for this
                        Event</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="script.js"></script>
</body>

</html>