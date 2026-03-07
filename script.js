// Energy Sparks Canvas Background for Hero Section
const canvas = document.getElementById('particle-canvas');
const ctx = canvas.getContext('2d');

let particlesArray;

function initCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

window.addEventListener('resize', initCanvas);
initCanvas();

class Particle {
    constructor(x, y, directionX, directionY, size, color) {
        this.x = x;
        this.y = y;
        this.directionX = directionX;
        this.directionY = directionY;
        this.size = size;
        this.color = color;
    }
    
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
        ctx.fillStyle = this.color;
        ctx.shadowBlur = 10;
        ctx.shadowColor = this.color;
        ctx.fill();
    }
    
    update() {
        // Move particle upwards like a spark
        this.y -= this.directionY;
        this.x += this.directionX;
        
        // Reset if it goes out of screen
        if (this.y < 0) {
            this.y = canvas.height;
            this.x = Math.random() * canvas.width;
        }
        
        this.draw();
    }
}

function initParticles() {
    particlesArray = [];
    let numberOfParticles = (canvas.width * canvas.height) / 7000;
    for (let i = 0; i < numberOfParticles; i++) {
        let size = (Math.random() * 2) + 0.5;
        let x = Math.random() * canvas.width;
        let y = Math.random() * canvas.height;
        let directionX = (Math.random() * 1) - 0.5;
        let directionY = (Math.random() * 2) + 1; // Faster upwards movement
        let color = Math.random() > 0.5 ? '#ff003c' : '#ff3c00'; // Red and Orange sparks
        
        particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
    }
}

function animateParticles() {
    requestAnimationFrame(animateParticles);
    ctx.clearRect(0, 0, innerWidth, innerHeight);
    
    for (let i = 0; i < particlesArray.length; i++) {
        particlesArray[i].update();
    }
}

initParticles();
animateParticles();

// Modals Logic
function openModal(id) {
    document.getElementById(id).style.display = "block";
    document.body.style.overflow = "hidden";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
    document.body.style.overflow = "auto";
}

window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
        document.body.style.overflow = "auto";
    }
}

// Pass Selection Helper
function selectPass(passType) {
    const passSelect = document.getElementById('pass_type');
    passSelect.value = passType;
    updateEventSelects();
}

// Dynamic Event Selects based on Pass
function updateEventSelects() {
    const passType = document.getElementById('pass_type').value;
    const selectionArea = document.getElementById('events-selection-area');
    selectionArea.innerHTML = '';
    
    const day1Events = [
        {val: 'codeathon', name: 'Codeathon 💻 - Day 1'},
        {val: 'project_expo', name: 'Project Expo 🚀 - Day 1'}
    ];

    const day2Events = [
        {val: 'console_app', name: 'Console-Based App 🖥️ - Day 2'},
        {val: 'tech_innovation', name: 'Tech Innovation - Day 2'}
    ];

    const allEvents = [...day1Events, ...day2Events];

    let selectHTML = (title, options, name = "selected_events[]") => `
        <div class="input-group">
            <label>${title}</label>
            <select name="${name}" required>
                <option value="">-- Choose Event --</option>
                ${options.map(e => `<option value="${e.val}">${e.name}</option>`).join('')}
            </select>
        </div>
    `;

    if (passType === 'royal') {
        // User must first pick the day to see events, or just show two separate groupings and enforce they pick one
        selectionArea.innerHTML = `
            <div class="form-subtitle">Royal Pass (Choose 1 Event from either Day 1 OR Day 2)</div>
            ${selectHTML('Select Your 1 Event', allEvents)}
        `;
    } else if (passType === 'elite') {
        selectionArea.innerHTML = `
            <div class="form-subtitle">Elite Pass (Choose 1 Event from Day 1 AND 1 Event from Day 2)</div>
            ${selectHTML('Select Event for Day 1', day1Events, "selected_events_day1")}
            ${selectHTML('Select Event for Day 2', day2Events, "selected_events_day2")}
        `;
    }
    
    calculateTotal();
}

// Calculate Total Pricing
function calculateTotal() {
    const passType = document.getElementById('pass_type').value;
    let teamSize = 1; // Leader is always counted
    
    if (document.getElementById('member2') && document.getElementById('member2').value.trim() !== '') teamSize++;
    if (document.getElementById('member3') && document.getElementById('member3').value.trim() !== '') teamSize++;
    if (document.getElementById('member4') && document.getElementById('member4').value.trim() !== '') teamSize++;
    
    let pricePerHead = 0;
    if (passType === 'royal') pricePerHead = 250;
    else if (passType === 'elite') pricePerHead = 400;
    
    const total = teamSize * pricePerHead;
    const totalElement = document.getElementById('live-total');
    if (totalElement) {
        totalElement.innerText = '₹' + total;
    }
}

// Attach Event Listeners on Load
document.addEventListener('DOMContentLoaded', () => {
    const memberInputs = ['member2', 'member3', 'member4'];
    memberInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', calculateTotal);
        }
    });

    const passTypeEl = document.getElementById('pass_type');
    if (passTypeEl) {
        passTypeEl.addEventListener('change', calculateTotal);
    }
});

// Mobile Hamburger Menu
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Close menu when clicking a link
    document.querySelectorAll('#nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });
}

// ==========================================
// SPIDER-VERSE WEB NAVIGATION ANIMATION
// ==========================================
const navCanvas = document.getElementById('nav-web-canvas');

// Ensure canvas covers entire scrollable document height
function resizeNavCanvas() {
    if (navCanvas) {
        navCanvas.style.height = document.documentElement.scrollHeight + 'px';
    }
}
window.addEventListener('resize', resizeNavCanvas);
window.addEventListener('load', resizeNavCanvas);

document.querySelectorAll('.navbar a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetSection = document.querySelector(targetId);
        if (!targetSection) return;

        // Origin point: center of clicked link
        const linkRect = this.getBoundingClientRect();
        const startX = linkRect.left + linkRect.width / 2;
        const startY = linkRect.top + linkRect.height / 2 + window.scrollY;

        // Destination point: top center of the target section
        const targetRect = targetSection.getBoundingClientRect();
        const endX = targetRect.left + targetRect.width / 2;
        const endY = targetRect.top + window.scrollY + 50; // Offset slightly into the section

        // Control point for Quadratic Bezier curve to make it arc like a gravity-affected web
        const cpX = (startX + endX) / 2 + (Math.random() * 200 - 100); // Random slight arc
        const cpY = Math.min(startY, endY) - Math.abs(endY - startY) * 0.2; // Arc upwards

        // Create the SVG Path
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const d = `M ${startX} ${startY} Q ${cpX} ${cpY} ${endX} ${endY}`;
        path.setAttribute('d', d);
        path.setAttribute('class', 'shooting-web');
        
        // Setup drawing animation lengths
        navCanvas.appendChild(path);
        const length = path.getTotalLength();
        path.style.strokeDasharray = length;
        path.style.strokeDashoffset = length;

        // Start smooth scroll
        window.scrollTo({
            top: targetRect.top + window.scrollY - 70, // offset for navbar
            behavior: 'smooth'
        });

        // Cleanup DOM after animation finishes (0.6s shoot + 0.4s fade = ~1s total)
        setTimeout(() => {
            if (navCanvas.contains(path)) {
                navCanvas.removeChild(path);
            }
        }, 1100);
    });
});
