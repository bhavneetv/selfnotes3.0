<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Self Notes | Flesh Note</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap">
  <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />
  <style>
    :root {
      --primary: #3b82f6;
      --primary-dark: #2563eb;
      --primary-light: #60a5fa;
      --bg-dark: #0f172a;
      --card-bg: #1e293b;
      --text-light: #f8fafc;
    }
    html{
      overflow-x: hidden;
    }
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-light);
      min-height: 100vh;
      overflow-x: hidden;
    }
    
    .app-container {
      position: relative;
      min-height: 100vh;
    }
    
    .glow {
      position: absolute;
      border-radius: 50%;
      filter: blur(70px);
      opacity: 0.3;
      z-index: 0;
      transition: all 0.5s ease;
    }
    
    .glow-1 {
      background: #60a5fa;
      width: 300px;
      height: 300px;
      top: -100px;
      left: -100px;
    }
    
    .glow-2 {
      background: #3b82f6;
      width: 350px;
      height: 350px;
      bottom: -120px;
      right: -100px;
    }
    
    .glow-3 {
      background: #1d4ed8;
      width: 200px;
      height: 200px;
      top: 40%;
      left: 35%;
    }
    
    .flashcard-container {
      perspective: 2000px;
      width: 100%;
      max-width: 650px;
      height: 420px;
      margin: 0 auto;
      z-index: 10;
      position: relative;
    }
    
    .flashcard {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      transform-style: preserve-3d;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), 0 5px 15px rgba(0, 0, 0, 0.1);
      background: var(--card-bg);
      background: linear-gradient(145deg, rgba(40, 60, 95, 0.8), rgba(30, 41, 59, 0.9));
      border: 1px solid rgba(78, 125, 224, 0.1);
    }
    
    .card-side {
      position: absolute;
      width: 100%;
      height: 100%;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2.5rem;
      border-radius: 16px;
    }
    
    .card-front {
      background: linear-gradient(145deg, rgba(40, 60, 95, 0.8), rgba(30, 41, 59, 0.9));
      backdrop-filter: blur(5px);
    }
    
    .card-back {
      transform: rotateY(180deg);
      background: linear-gradient(145deg, rgba(35, 55, 90, 0.8), rgba(30, 41, 59, 0.9));
      backdrop-filter: blur(5px);
    }
    
    .flipped {
      transform: rotateY(180deg);
    }
    
    .card-content {
      position: relative;
      z-index: 1;
      text-align: center;
      max-width: 90%;
    }
    
    .card-front .card-content:before {
      content: "";
      position: absolute;
      top: -40px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: var(--primary);
      border-radius: 10px;
    }
    
    .question-text {
      font-size: 1.85rem;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #f0f9ff 0%, #bfdbfe 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    .answer-text {
      font-size: 1.7rem;
      font-weight: 500;
      line-height: 1.5;
      margin-bottom: 1rem;
      color: #dbeafe;
    }
    
    .sparkle {
      position: absolute;
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.3);
      pointer-events: none;
      z-index: 2;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 0.8rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
      position: relative;
      overflow: hidden;
    }
    
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    }
    
    .btn-primary:active {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    
    .btn-primary:before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }
    
    .btn-primary:hover:before {
      left: 100%;
    }
    
    .control-bar {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
      z-index: 10;
      position: relative;
    }
    
    .progress-container {
      position: relative;
      height: 6px;
      width: 180px;
      background-color: rgba(148, 163, 184, 0.2);
      border-radius: 8px;
      overflow: hidden;
      margin: 0 auto;
      margin-top: 1rem;
    }
    
    .progress-bar {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
      transition: width 0.4s ease;
      border-radius: 8px;
    }
    
    .counter {
      font-size: 0.85rem;
      color: #94a3b8;
      text-align: center;
      margin-top: 0.5rem;
    }
    
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem 2rem;
      backdrop-filter: blur(10px);
      background-color: rgba(15, 23, 42, 0.7);
      border-bottom: 1px solid rgba(59, 130, 246, 0.1);
      z-index: 20;
      position: relative;
    }
    
    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, #93c5fd 0%, #3b82f6 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1px;
    }
    
    .glass-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(15, 23, 42, 0.7);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 100;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    
    .glass-modal.active {
      opacity: 1;
      pointer-events: auto;
    }
    
    .modal-content {
      background: linear-gradient(145deg, rgba(40, 60, 95, 0.8), rgba(30, 41, 59, 0.9));
      border-radius: 16px;
      padding: 2rem;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(78, 125, 224, 0.1);
      transform: translateY(20px);
      transition: transform 0.3s ease;
    }
    
    .glass-modal.active .modal-content {
      transform: translateY(0);
    }
    
    .modal-header {
      margin-bottom: 1.5rem;
    }
    
    .modal-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #dbeafe;
    }
    
    .note-textarea {
      width: 100%;
      height: 150px;
      background-color: rgba(30, 41, 59, 0.7);
      border: 1px solid rgba(59, 130, 246, 0.3);
      border-radius: 12px;
      padding: 1rem;
      color: white;
      font-size: 1rem;
      resize: none;
      margin-bottom: 1.5rem;
      transition: border-color 0.3s ease;
    }
    
    .note-textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }
    
    .floating-label {
      position: absolute;
      top: 0;
      right: 0;
      background-color: var(--primary);
      color: white;
      font-size: 0.7rem;
      padding: 0.3rem 0.7rem;
      border-radius: 0 16px 0 16px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    
    @media (max-width: 640px) {
      .flashcard-container {
        height: 350px;
      }
      
      .question-text,
      .answer-text {
        font-size: 1.4rem;
      }
      
      .header {
        padding: 1rem;
      }
      
      .control-bar {
        flex-wrap: wrap;
      }
      
      .btn-primary {
        padding: 0.7rem 1.2rem;
        font-size: 0.9rem;
      }
    }
    
    /* Card state indicators */
    .card-indicators {
      position: absolute;
      bottom: 1.5rem;
      display: flex;
      gap: 0.5rem;
    }
    
    .indicator {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.2);
    }
    
    .indicator.active {
      background-color: var(--primary);
    }
    
    /* Mouse follower */
    .cursor-follower {
      position: fixed;
      top: 0;
      left: 0;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
      pointer-events: none;
      z-index: 1;
      transform: translate(-50%, -50%);
      transition: opacity 0.5s ease;
      opacity: 0;
    }
  </style>
</head>
<body>
  <div class="cursor-follower"></div>
  
  <div class="app-container">
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    <div class="glow glow-3"></div>
    
    <header class="header">
      <div class="logo">FLASHY</div>
      <div id="card-counter" class="text-blue-300 text-sm">Card 1 of 5</div>
    </header>
    
    <main class="container mx-auto px-4 py-8">
      <div class="flashcard-container my-8">
        <div id="flashcard" class="flashcard">
          <div class="card-side card-front">
            <div class="floating-label">QUESTION</div>
            <div class="card-content">
              <h2 id="question" class="question-text"></h2>
            </div>
            <div class="card-indicators">
              <span class="indicator active"></span>
              <span class="indicator"></span>
            </div>
          </div>
          <div class="card-side card-back">
            <div class="floating-label">ANSWER</div>
            <div class="card-content">
              <p id="answer" class="answer-text"></p>
            </div>
            <div class="card-indicators">
              <span class="indicator"></span>
              <span class="indicator active"></span>
            </div>
          </div>
        </div>
      </div>
      
      <div class="progress-container">
        <div id="progress-bar" class="progress-bar" style="width: 20%"></div>
      </div>
      <div id="card-counter-text" class="counter">1 of 5</div>
      
      <div class="control-bar">
        <button id="prev-btn" class="btn-primary">
          <i class="fas fa-arrow-left mr-2"></i> Previous
        </button>
        <button id="flip-btn" class="btn-primary">
          <i class="fas fa-sync-alt mr-2"></i> Flip
        </button>
        <button id="next-btn" class="btn-primary">
          Next <i class="fas fa-arrow-right ml-2"></i>
        </button>
      </div>
      
      <div class="text-center mt-6">
        <button id="add-note-btn" class="btn-primary bg-blue-700">
          <i class="fas fa-sticky-note mr-2"></i> Add Note
        </button>
      </div>
    </main>
  </div>
  
  <!-- Note Modal -->
  <div id="note-modal" class="glass-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Note</h3>
      </div>
      <textarea id="note-text" class="note-textarea" placeholder="Write your note here..."></textarea>
      <div class="flex justify-end gap-3">
        <button id="cancel-note" class="btn-primary bg-gray-600 hover:bg-gray-500">Cancel</button>
        <button id="save-note" class="btn-primary">Save Note</button>
      </div>
    </div>
  </div>

  <script>
    alert("Coming Soon !!!")
    // Flashcard data
    const flashcards = [
  {
    question: "What does Kepler's First Law state?",
    answer: "Planets move in elliptical orbits with the Sun at one focus.",
    note: ""
  },
  {
    question: "What is the formula for Angular Momentum?",
    answer: "L = r × p = Iω (where L is angular momentum, r is radius, p is momentum, I is moment of inertia, and ω is angular velocity).",
    note: ""
  },
  {
    question: "How many equations are there in Maxwell's Equations?",
    answer: "Four equations describe classical electromagnetism.",
    note: ""
  },
  {
    question: "What does Kepler's Second Law state about planetary motion?",
    answer: "A planet sweeps out equal areas in equal times, meaning it moves faster when closer to the Sun.",
    note: ""
  },
  {
    question: "Which Maxwell equation represents Gauss's Law for electric fields?",
    answer: "∇⋅E = ρ/ε₀ (Electric flux through a surface is proportional to the enclosed charge).",
    note: ""
  }
];


    // DOM elements
    const flashcardEl = document.getElementById('flashcard');
    const questionEl = document.getElementById('question');
    const answerEl = document.getElementById('answer');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const flipBtn = document.getElementById('flip-btn');
    const counterEl = document.getElementById('card-counter');
    const counterTextEl = document.getElementById('card-counter-text');
    const progressBarEl = document.getElementById('progress-bar');
    const addNoteBtn = document.getElementById('add-note-btn');
    const noteModal = document.getElementById('note-modal');
    const noteText = document.getElementById('note-text');
    const saveNoteBtn = document.getElementById('save-note');
    const cancelNoteBtn = document.getElementById('cancel-note');
    const cursorFollower = document.querySelector('.cursor-follower');

    // Current card index
    let currentIndex = 0;
    
    // Mouse follower effect
    document.addEventListener('mousemove', (e) => {
      const glows = document.querySelectorAll('.glow');
      const mouseX = e.clientX;
      const mouseY = e.clientY;
      
      // Move the glows slightly for a parallax effect
      glows[0].style.transform = `translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`;
      glows[1].style.transform = `translate(${-mouseX * 0.01}px, ${-mouseY * 0.01}px)`;
      glows[2].style.transform = `translate(${mouseX * 0.015}px, ${-mouseY * 0.015}px)`;
      
      // Move cursor follower
      cursorFollower.style.left = `${mouseX}px`;
      cursorFollower.style.top = `${mouseY}px`;
      cursorFollower.style.opacity = '1';
    });
    
    // Hide cursor follower when mouse leaves window
    document.addEventListener('mouseout', () => {
      cursorFollower.style.opacity = '0';
    });

    // Create sparkle effect on card hover
    function createSparkles() {
      const card = document.querySelector('.flashcard-container');
      
      card.addEventListener('mousemove', (e) => {
        if (Math.random() > 0.9) {
          const sparkle = document.createElement('div');
          sparkle.classList.add('sparkle');
          
          // Position sparkle relative to card
          const rect = card.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          
          sparkle.style.left = `${x}px`;
          sparkle.style.top = `${y}px`;
          
          card.appendChild(sparkle);
          
          // Remove sparkle after animation
          setTimeout(() => {
            sparkle.remove();
          }, 300);
        }
      });
    }
    
    // Load card function
    function loadCard(index) {
      // Update card content
      questionEl.textContent = flashcards[index].question;
      answerEl.textContent = flashcards[index].answer;
      
      // Update progress indicators
      counterEl.textContent = `Card ${index + 1} of ${flashcards.length}`;
      counterTextEl.textContent = `${index + 1} of ${flashcards.length}`;
      
      // Update progress bar
      const progress = ((index + 1) / flashcards.length) * 100;
      progressBarEl.style.width = `${progress}%`;
      
      // Reset card flip
      flashcardEl.classList.remove('flipped');
    }

    // Navigate through cards
    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + flashcards.length) % flashcards.length;
      loadCard(currentIndex);
    });

    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % flashcards.length;
      loadCard(currentIndex);
    });

    // Flip card
    flipBtn.addEventListener('click', () => {
      flashcardEl.classList.toggle('flipped');
    });

    // Note modal functionality
    addNoteBtn.addEventListener('click', () => {
      noteText.value = flashcards[currentIndex].note;
      noteModal.classList.add('active');
    });

    cancelNoteBtn.addEventListener('click', () => {
      noteModal.classList.remove('active');
    });

    saveNoteBtn.addEventListener('click', () => {
      flashcards[currentIndex].note = noteText.value;
      noteModal.classList.remove('active');
    });

    // Close modal when clicking outside
    noteModal.addEventListener('click', (e) => {
      if (e.target === noteModal) {
        noteModal.classList.remove('active');
      }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') {
        prevBtn.click();
      } else if (e.key === 'ArrowRight') {
        nextBtn.click();
      } else if (e.key === ' ' || e.key === 'Spacebar') {
        e.preventDefault(); // Prevent page scroll
        flipBtn.click();
      } else if (e.key === 'Escape') {
        noteModal.classList.remove('active');
      }
    });

    // Create button pulse animation
    function createButtonEffects() {
      const buttons = document.querySelectorAll('.btn-primary');
      
      buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
          button.style.transform = 'translateY(-3px)';
        });
        
        button.addEventListener('mouseleave', () => {
          button.style.transform = 'translateY(0)';
        });
      });
    }

    // Initialize
    function init() {
      loadCard(currentIndex);
      createSparkles();
      createButtonEffects();
    }

    // Start app
    init();
  </script>
</body>
</html>