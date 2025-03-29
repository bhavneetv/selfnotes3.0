<?php
session_start();
require("../includes/connection.php");



if (isset($_SESSION['User']) && isset($_COOKIE['User'])) {



    $v = $_SESSION['User'];
} elseif (!empty($_SESSION['User']) && empty($_COOKIE['User'])) {


    $v = $_SESSION['User'];
} elseif (!empty($_COOKIE['User']) && empty($_SESSION['User'])) {


    $v = $_COOKIE['User'];
    $_SESSION['User'] = $v;
}




if (!empty($_SESSION['User'])) {


    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        // print_r($row['Full_name']);
        $name = $row['name'];
        $role = $row['role'];
        $logout = 'block';
        $login = 'none';
        $subject = $row['subject'];
        $notes = "Recent Notes";
    } else {
        echo "Error";
        setcookie('User', '', time() - 3600, '/');
        session_destroy();
        $subject = 'Mathematics,MP,EVS,Physics,Chemistry,English,Biology';
        $log = "Sign Up / Login";
    }
} else {

    $name = 'Guest';
    $role = 'Guest';

    $logout = 'none';
    $login = 'block';
    $subject = 'Mathematics,MP,EVS,Physics,Chemistry,English,Biology';

    $notes = "Suggested Notes";
}




$myArray = explode(',', $subject);



?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes | Deshboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="description" content="SelfNotes offers free, high-quality study notes for students. Find comprehensive and easy-to-understand notes across a wide range of subjects to help you succeed in your exams.">
    <link rel="icon" type="image/png" href="../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../public/assest/icon/site.webmanifest" />
    <!-- Meta keywords for SEO -->
    <meta name="keywords" content="free study notes, student notes, educational resources, exam preparation, high school notes, college notes, self-study materials, free notes for students">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Author of the website -->
    <meta name="author" content="Self Notes">

    <!-- Open Graph Tags for Social Media -->
    <meta property="og:title" content="Self Notes - Free Study Notes for Students">
    <meta property="og:description" content="Self Notes provides free study notes for students, helping them excel in their studies and exams. Access comprehensive, clear, and useful notes on various subjects.">
    <script>
        // Check for user preference or system preference
        function getThemePreference() {
            if (localStorage.getItem('theme')) {
                return localStorage.getItem('theme');
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        // Apply theme on load
        function applyTheme(theme) {
            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(theme);
            localStorage.setItem('theme', theme);
        }

        // Initial theme setup
        applyTheme(getThemePreference());
    </script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gray-50 " id="b">
    <!-- AI Chat Button -->

    <!-- Loading Screen -->
    <div id="loadingScreen" class="fixed inset-0 bg-gray-900 flex items-center justify-center z-50">
        <div class="text-center">
            <span class="loader"></span>
            <p class="text-white mt-4 text-xl">Loading your learning experience...</p>
        </div>
    </div>

    <!-- Login Modal -->

    <!-- Sidebar -->
    <nav id="sidebar" class="fixed left-0 top-0 w-72 h-full bg-gray-900 text-white transform -translate-x-full custom:translate-x-0 transition-transform duration-300 z-40 custom-scrollbar overflow-y-auto">

        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold ">Self Notes</h1>
                <button id="closeSidebar" class="md:hidden ">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>


            <!-- User Profile Section -->
            <div class="mb-8 p-4 bg-gray-800 rounded-lg">
                <div class="flex items-center justify-between">
                    <a href="accounts\account.php" class="flex items-center space-x-4 flex-grow">
                        <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span id="n" class="text-lg font-bold" <?php echo "names = " . $name; ?>></span>
                        </div>
                        <div>
                            <h3 class="font-medium" id="v"><?php echo $name; ?></h3>
                            <p class="text-sm text-gray-400"><?php echo $role; ?></p>
                        </div>
                    </a>

                    <!-- Logout Button -->
                    <a href="../includes/logout.php" class="text-red-400 hover:text-red-600 transition-colors" style="display:<?php echo $logout; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </div>



            <!-- Navigation Links -->
            <div class="space-y-4">
                <a href="progress/progress.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>My Progress</span>
                </a>

                <a href="pyqs/pyqs.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Important Topics</span>
                </a>
                <a href="my_notes/notes.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="24px" height="24px" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M8 14L16 14" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 10L10 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 18L12 18" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10 3H6C4.89543 3 4 3.89543 4 5V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V5C20 3.89543 19.1046 3 18 3H14.5M10 3V1M10 3V5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    <span>My Notes</span>
                    <!-- <span>My Notes</span> -->
                </a>
                <a href="talk/talk.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="24px" height="24px" class="w-5 h-5" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #ffffff;
                                        stroke-miterlimit: 10;
                                        stroke-width: 1.91px;
                                    }
                                </style>
                            </defs>
                            <path class="cls-1" d="M22.5,10.05v10.5l-2.86-2.87H11.05a3.81,3.81,0,0,1-3.7-2.86,3.77,3.77,0,0,1-.12-1V10.05a3.82,3.82,0,0,1,3.82-3.82h7.63A3.82,3.82,0,0,1,22.5,10.05Z"></path>
                            <path class="cls-1" d="M16.77,5.27v1H11.05a3.82,3.82,0,0,0-3.82,3.82v2.86H4.36L1.5,15.77V5.27A3.82,3.82,0,0,1,5.32,1.45H13A3.82,3.82,0,0,1,16.77,5.27Z"></path>
                        </g>
                    </svg>
                    <span>My Chats</span>
                </a>

                <a href="../public/contact/contact.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg height="24px" width="24px" version="1.1" id="Capa_1" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 301.211 301.211" xml:space="preserve" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path style="fill:#ffffff;" d="M301.211,186.788c0-25.181-15.364-45.941-34.952-48.326c-3.446-4.105-7.957-7.287-13.104-9.117 v-2.882c0-27.604-10.767-55.478-29.54-76.475c-19.713-22.049-45.642-34.192-73.009-34.192S97.311,27.939,77.597,49.988 c-18.773,20.998-29.54,48.872-29.54,76.475v2.882c-5.147,1.83-9.658,5.011-13.104,9.117C15.364,140.847,0,161.607,0,186.788 c0,25.183,15.364,45.945,34.954,48.328c5.57,6.635,13.919,10.862,23.239,10.862c16.731,0,30.344-13.611,30.344-30.342v-57.697 c0-15.075-11.054-27.612-25.481-29.947v-1.529c0-11.417,2.059-22.517,5.77-32.873c18.188-21.764,53.591-38.831,81.779-38.831 c28.188,0,63.59,17.067,81.779,38.831c3.711,10.356,5.77,21.457,5.77,32.873v1.529c-14.427,2.335-25.48,14.872-25.48,29.947v57.697 c0,16.73,13.612,30.342,30.344,30.342c9.32,0,17.669-4.228,23.239-10.862c1.232-0.15,2.446-0.376,3.643-0.669 c-5.672,21.692-26.124,35.967-53.579,35.967h-3.055c-9.391,0-18.251-1.736-26.038-5.054c1.668-3.312,2.614-7.047,2.614-11.002 c0-13.53-11.008-24.538-24.539-24.538h-7.405c-13.53,0-24.538,11.008-24.538,24.538c0,13.531,11.008,24.539,24.538,24.539h7.405 c3.768,0,7.339-0.855,10.532-2.379c10.932,5.824,23.784,8.896,37.431,8.896h3.055c18.997,0,36.464-5.987,49.182-16.859 c12.771-10.916,20.118-26.314,20.902-43.617C295.411,216.039,301.211,202.251,301.211,186.788z M157.897,263.898 c-5.26,0-9.538-4.279-9.538-9.539c0-5.259,4.278-9.538,9.538-9.538h7.405c5.26,0,9.539,4.279,9.539,9.538 c0,5.26-4.279,9.539-9.539,9.539H157.897z M286.211,186.788c0,12.703-5.3,24.023-12.873,29.701c0.008-0.284,0.021-0.566,0.021-0.852 v-57.697c0-0.285-0.014-0.567-0.021-0.851C280.911,162.768,286.211,174.086,286.211,186.788z M15,186.788 c0-12.702,5.3-24.02,12.873-29.699c-0.008,0.283-0.021,0.565-0.021,0.851v57.697c0,0.286,0.014,0.568,0.021,0.852 C20.3,210.811,15,199.491,15,186.788z M73.537,157.939v57.697c0,8.459-6.883,15.342-15.344,15.342 c-8.46,0-15.342-6.882-15.342-15.342v-57.697c0-8.46,6.882-15.342,15.342-15.342C66.654,142.598,73.537,149.48,73.537,157.939z M150.605,44.759c-22.364,0-48.109,9.321-68.349,23.435c16.336-22.455,41.385-37.397,68.349-37.397 c26.964,0,52.013,14.942,68.349,37.398C198.715,54.081,172.97,44.759,150.605,44.759z M243.018,230.979 c-8.461,0-15.344-6.882-15.344-15.342v-57.697c0-8.46,6.883-15.342,15.344-15.342c8.46,0,15.342,6.882,15.342,15.342v57.697 C258.359,224.096,251.477,230.979,243.018,230.979z"></path>
                        </g>
                    </svg>
                    <span>Contact Us</span>
                </a>

                <!-- Subjects Section -->
                <div class="mt-8">
                    <h2 class="px-3 text-sm font-semibold text-gray-400 uppercase">Subjects</h2>
                    <div class="mt-4 space-y-2">
                        <!-- Subject Items -->


                        <?php
                        foreach ($myArray as $item) {
                            echo "<div class='subject-item'>
                            <button class='w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 transition-colors'>
                                <span class='text-lg'>$item</span>
                            </button>
                        </div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="content" class="custom:ml-72 transition-all duration-300">
        <!-- Top Navigation -->
        <header class="bg-white shadow-md sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <button id="menuBtn" class="custom:hidden text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Search Bar -->
                <div class="flex-1 mx-4">
                    <div class="relative max-w-md">
                        <input type="text" id="searchInput" placeholder="Search notes, subjects, chapters..."
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <!-- Add this inside the header, next to the search bar -->
                <div class="flex items-center" style="margin-right: 20px;" id="modes">
                    <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                        <!-- Sun icon for dark mode -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon icon for light mode -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center space-x-4">

                    <a href="../public/login-sign.php" style="display: <?php echo $login; ?> ">
                        <button id="loginBtn" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                            Login
                        </button>
                    </a>
                </div>
            </div>
        </header>



        <!-- Main Content Area -->
        <main class="p-6">
            <!-- Progress Section -->
            <section class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="progressRing">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Total notes reads</h3>
                                <p class="text-gray-500" id="subjectName">Mathematics</p>
                            </div>
                            <div class="relative w-16 h-16">
                                <svg class="w-16 h-16" style="display: none;">
                                    <circle class="text-gray-200" stroke-width="5" stroke="currentColor" fill="transparent" r="30" cx="32" cy="32" />
                                    <circle class="text-indigo-600 progress-ring" stroke-width="5" stroke="currentColor" fill="transparent" r="30" cx="32" cy="32"
                                        style="stroke-dasharray: 188.5; stroke-dashoffset: 47.125;" />
                                </svg>
                                <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm font-semibold" id="progressValue">0</span>
                            </div>
                        </div>
                    </div>
                    <!-- Add more progress cards -->
                </div>
            </section>

            <!-- Notes Grid -->
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6" id="subjectName2"><?php echo $notes; ?></h2>
                <!-- Skeleton Screen -->
                <div id="skeletonScreen" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Skeleton Cards -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="animate-pulse">
                            <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-10 bg-gray-200 rounded mb-4"></div>
                        </div>
                    </div>
                    <!-- Repeat skeleton cards as needed -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="animate-pulse">
                            <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-10 bg-gray-200 rounded mb-4"></div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="animate-pulse">
                            <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-10 bg-gray-200 rounded mb-4"></div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div id="notesSection" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                    <!-- Notes will be dynamically added here -->
                </div>
            </section>





            <section class="mt-12 px-4 py-8">
                <div class="max-w-6xl mx-auto" style="margin: 0;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-left">Available Syllabus</h2>

                    <!-- Grid Layout for Syllabus Cards (Always Left-Aligned) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-start" id="syllabus">
                        <!-- Syllabus cards will be loaded dynamically here -->
                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-12">
            <div class="max-w-7xl mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Self Notes</h3>
                        <p class="text-gray-400">Your one-stop destination for quality study materials and notes.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                            <!-- <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li> -->
                            <li><a href="../public/contact/contact.php" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                            <li><a href="../teacher/uploadNote/uploadNote.php" class="text-gray-400 hover:text-white transition-colors">Upload Your Notes</a></li>
                            <li><a href="../teacher/manageNote/manageNote.php" class="text-gray-400 hover:text-white transition-colors">Manage Your Notes</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Problems</h4>
                        <ul class="space-y-2">
                            <li><a href="../public/contact/contact.php" class="text-gray-400 hover:text-white transition-colors">Report Problem</a></li>

                        </ul>
                        <ul class="space-y-2">
                            <li><a href="../about.php" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>

                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-400">selfnotesofficials@gmail.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <script>
        // function to get first letter of name
        function getInitials(name) {
            // Split the name by spaces
            let words = name.trim().split(/\s+/);

            // Extract the first letter of each word and join them
            let initials = words.map(word => word[0]).join('');

            return initials.toUpperCase(); // Convert to uppercase if needed
        }

        // Example usage


        let names = document.getElementById("v").innerHTML;
        document.getElementById("n").innerHTML = getInitials(names);
        // Add this to your existing script.js or create a new one
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');

            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                applyTheme(newTheme);
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                const newTheme = e.matches ? 'dark' : 'light';
                applyTheme(newTheme);
            });
        });

        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon("../includes/track_time.php");
        });
    </script>
    <script src="js/script2_ai.js"></script>
    <script src="js/script.js"></script>

</body>

</html>