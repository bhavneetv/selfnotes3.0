<?php
require("includes/connection.php");
session_start();
$sql = "SELECT * FROM all_notes";
$result = $conn->query($sql);

$total_notes = $result->num_rows;

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$total_user = $result->num_rows;

$sql = "SELECT * FROM user WHERE role ='Teacher'"  ;
$result = $conn->query($sql);

$total_teacher = $result->num_rows;

if (!empty($_COOKIE['visited'])) {
    setcookie('visited', 'true', time() + (86400 * 30 * 3), "/"); 
    header("Location: students/index.php"); 
    exit();
}
// setcookie('visited', 'true', time() + (86400 * 30 * 3), "/"); 


?>













<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Self Notes</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link rel="icon" type="image/png" href="public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="public/assest/icon/site.webmanifest" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <meta name="description" content="Self Notes offers free, high-quality study notes for students. Find comprehensive and easy-to-understand notes across a wide range of subjects to help you succeed in your exams.">

<!-- Meta keywords for SEO -->
<meta name="keywords" content="free study notes, student notes, educational resources, exam preparation, high school notes, college notes, self-study materials, free notes for students">

<!-- Author of the website -->
<meta name="author" content="Self Notes">

<!-- Open Graph Tags for Social Media -->
<meta property="og:title" content="SelfNotes - Free Study Notes for Students">
<meta property="og:description" content="SelfNotes provides free study notes for students, helping them excel in their studies and exams. Access comprehensive, clear, and useful notes on various subjects.">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    html{
      scroll-behavior: smooth;
      overflow-x: hidden;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #0f172a;
      color: #e2e8f0;
      overflow-x: hidden;
      /* overflow-y: hidden; */
    }

    .blur-bg {
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    .glass-effectss {
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
    }

    .feature-card {
      transition: all 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-10px);
    }

    .btn-glow {
      box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
      transition: all 0.3s ease;
    }

    .btn-glow:hover {
      box-shadow: 0 0 25px rgba(99, 102, 241, 0.8);
    }

    .counter-value {
      transition: color 0.3s ease;
    }

    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      background-image: linear-gradient(45deg, #6366f1, #8b5cf6, #d946ef);
    }

    .particles {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>
<body>
  <!-- Particles Background -->
  <div class="particles" id="particles"></div>

  <!-- Navbar -->
  <nav id="navbar" class="fixed w-full py-4 z-50 transition-all duration-300 ease-in-out">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="blur-bg glass-effectss px-6 py-3 rounded-full flex justify-between items-center">
        <div class="flex items-center">
          <span class="text-2xl font-bold gradient-text">Self Notes</span>
        </div>
        <div>
          <a href="public/login-sign.php"><button class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
            Login
          </button></a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="min-h-screen flex items-center pt-32 pb-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2 space-y-8" id="hero-content">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
            Take notes the <span class="gradient-text">modern</span> way
          </h1>
          <p class="text-lg text-gray-300 max-w-xl">
            Self Notes provides a free, secure, and beautiful platform for all your note-taking needs. Organize your thoughts, ideas, and tasks with ease.
          </p>
          <div class="flex flex-wrap gap-4">
           
            <button id="next1" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full btn-glow transition duration-300 ease-in-out transform hover:scale-105">
              Get Started - It's Free
            </button>
            
           <a href="#features"> <button class="bg-transparent border-2 border-indigo-500 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out hover:bg-indigo-900">
              Learn More
            </button></a>
          </div>
        </div>
        <div class="w-full lg:w-1/2 relative" id="hero-image">
                    <div class="relative floating">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg blur opacity-30"></div>
                        <div class="relative bg-gray-800 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-4 bg-gray-700 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-700 rounded"></div>
                                <div class="h-4 bg-gray-700 rounded w-5/6"></div>
                                <div class="h-4 bg-gray-700 rounded w-2/3"></div>
                                <div class="h-4 bg-gray-700 rounded w-4/5"></div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16" id="features">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Amazing Features</h2>
        <p class="text-gray-400 max-w-2xl mx-auto">Discover why thousands of users choose Self Notes for their note-taking needs</p>
      </div>
      
      <style>

  .glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    transition: all 0.3s ease;
  }
  
  .glass-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px 0 rgba(31, 38, 135, 0.25);
    background: rgba(255, 255, 255, 0.15);
  }
  
  .feature-icon {
    transition: all 0.3s ease;
  }
  
  .feature-card:hover .feature-icon {
    transform: scale(1.1);
  }
  


</style>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="feature-cards">
    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-indigo-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Free Notes</h3>
        <p class="text-gray-300">Access and download notes completely free of charge. No hidden fees or subscriptions required.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-purple-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">24/7 Support</h3>
        <p class="text-gray-300">Get assistance anytime you need it with our round-the-clock customer support team.</p>
    </div>

    

   

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-green-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Check Progress</h3>
        <p class="text-gray-300">Track your learning journey with detailed progress reports and performance analytics.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-yellow-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Encrypted</h3>
        <p class="text-gray-300">Rest easy knowing your notes and personal information are protected with end-to-end encryption.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-red-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Create Own Notes</h3>
        <p class="text-gray-300">Easily create and customize your own study notes with our intuitive note-taking tools.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-teal-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Upload Notes</h3>
        <p class="text-gray-300">Easily upload and share your existing notes in various formats to enhance the community knowledge base.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-orange-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Teacher Support</h3>
        <p class="text-gray-300">Get expert guidance from qualified teachers who can answer questions and provide additional explanations.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-indigo-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Download Notes</h3>
        <p class="text-gray-300">Save notes offline for studying without internet connection across multiple devices and formats.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-purple-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">AI Summary</h3>
        <p class="text-gray-300">Get instant AI-generated summaries of lengthy notes to help you grasp key concepts quickly.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-pink-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Flashcards</h3>
        <p class="text-gray-300">Convert your notes into interactive flashcards for effective memorization and quick revision.</p>
    </div>

    <div class="feature-card glass-effect p-6 rounded-xl">
        <div class="w-14 h-14 bg-green-600/30 rounded-lg flex items-center justify-center mb-6 feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-3 text-white">Admin Approved Notes</h3>
        <p class="text-gray-300">Only high-quality, verified notes pass our rigorous approval process to ensure accuracy and reliability.</p>
    </div>
</div>
  </section>

  <!-- Stats Section -->
  <section class="py-16 bg-gradient-to-b from-transparent to-indigo-900/20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="glass-effectss p-8 rounded-2xl" id="stats-container">
          <h2 class="text-3xl font-bold mb-8">Why Users Love Self Notes</h2>
          
          <div class="grid grid-cols-2 gap-6">
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold gradient-text mb-2 counter-value" data-target="<?php echo $total_user; ?>">0</div>
              <p class="text-gray-400">Total Accounts</p>
            </div>
            
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold gradient-text mb-2 counter-value" data-target="<?php echo $total_notes; ?>">0</div>
              <p class="text-gray-400">Notes Created</p>
            </div>
            
            <div class="text-center">
              <div class="text-4xl md:text-5xl font-bold gradient-text mb-2 counter-value" data-target="<?php echo $total_teacher; ?>">0</div>
              <p class="text-gray-400">Total Teachers</p>
            </div>
            
            
          </div>
        </div>
        
        <div class="p-4" id="">
          <h3 class="text-2xl md:text-3xl font-bold mb-6">Ready to transform your note-taking experience?</h3>
          <p class="text-gray-300 mb-8">Join thousands of satisfied users who have made Self Notes their go-to platform for organizing their thoughts, ideas, and more.</p>
          <button id="next" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-10 rounded-full btn-glow transition duration-300 ease-in-out transform hover:scale-105 hover:rotate-1">
            Explore Main Website
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-10 mt-16 border-t border-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
          <span class="text-2xl font-bold gradient-text">Self Notes</span>
          <p class="text-gray-400 mt-2">Simplify your note-taking experience.</p>
        </div>
        
        <div class="flex space-x-6">
          <a href="#" class="text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
            </svg>
          </a>
        </div>
      </div>
      
      <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400 text-sm">
        <p>&copy; 2025 Self Notes. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('py-7');
        navbar.classList.remove('py-4');
      } else {
        navbar.classList.add('py-4');
        navbar.classList.remove('py-7');
      }
    });

    // Initialize GSAP animations
    document.addEventListener('DOMContentLoaded', function() {
      // Hero section animations
      gsap.from('#hero-content', {
        opacity: 0,
        x: -50,
        duration: 1,
        ease: 'power3.out'
      });
      
      gsap.from('#hero-image', {
        opacity: 0,
        y: 50,
        duration: 1,
        delay: 0.3,
        ease: 'power3.out'
      });
      
      // Feature cards animation
      gsap.from('.feature-card', {
        scrollTrigger: {
          trigger: '#features',
          start: 'top 80%'
        },
        opacity: 0,
        y: 50,
        duration: 0.7,
        stagger: 0.1,
        ease: 'power2.out'
      });
      
      // Stats counter animation
      const counterElements = document.querySelectorAll('.counter-value');
      
      const animateCounter = (el) => {
        const target = parseInt(el.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const startTime = performance.now();
        
        const updateCounter = (currentTime) => {
          const elapsedTime = currentTime - startTime;
          
          if (elapsedTime < duration) {
            const progress = elapsedTime / duration;
            const currentValue = Math.round(target * progress);
            el.textContent = currentValue.toLocaleString();
            requestAnimationFrame(updateCounter);
          } else {
            el.textContent = target.toLocaleString();
          }
        };
        
        requestAnimationFrame(updateCounter);
      };
      
      // Start counter animation when in view
      const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            counterElements.forEach(animateCounter);
            statsObserver.disconnect();
          }
        });
      }, { threshold: 0.5 });
      
      statsObserver.observe(document.getElementById('stats-container'));
      
      // CTA animation
      gsap.from('#cta-container', {
        scrollTrigger: {
          trigger: '#stats-container',
          start: 'top 70%'
        },
        opacity: 0,
        x: 50,
        duration: 0.8,
        ease: 'power2.out'
      });
      
      // Create particles
      createParticles();
    });

    // Particles background
    function createParticles() {
      const particlesContainer = document.getElementById('particles');
      const particleCount = 50;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        const size = Math.random() * 3 + 1;
        
        particle.style.position = 'absolute';
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
        particle.style.borderRadius = '50%';
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.pointerEvents = 'none';
        
        particlesContainer.appendChild(particle);
        
        // Animate each particle
        gsap.to(particle, {
          y: `${Math.random() * 200 - 100}`,
          x: `${Math.random() * 200 - 100}`,
          opacity: Math.random() * 0.5 + 0.3,
          duration: Math.random() * 10 + 10,
          repeat: -1,
          yoyo: true,
          ease: 'sine.inOut'
        });
      }
    }


  document.getElementById("next").addEventListener("click", function() {

    document.location.href = "students/index.php";

    
    const d = new Date();
    d.setTime(d.getTime() + (86400 * 30 * 3));
    let expires = "expires="+ d.toUTCString();
    document.cookie = "visited=true" + ";" + expires + ";path=/";
  });
  document.getElementById("next1").addEventListener("click", function() {

    document.location.href = "students/index.php";

    
    const d = new Date();
    d.setTime(d.getTime() + (86400 * 30 * 3));
    let expires = "expires="+ d.toUTCString();
    document.cookie = "visited=true" + ";" + expires + ";path=/";
  });


</script>

</body>
</html>