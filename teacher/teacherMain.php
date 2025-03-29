<?php
session_start();
require("../includes/connection.php");



if (isset($_SESSION['User']) && isset($_COOKIE['User'])) {



    $v = $_SESSION['User'];






    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        // print_r($row['Full_name']);
        $name = $row['name'];
        $role = $row['role'];
        $log = 'Log Out';
        $login = '../includes/logout.php';
        $subject = $row['subject'];
    } else {
        echo "Error";
    }
} elseif (!empty($_SESSION['User']) && empty($_COOKIE['User'])) {



    $v = $_SESSION['User'];



    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];
        $log = 'Log Out';
        $subject = $row['subject'];
        $login = '../includes/logout.php';
    } else {
        echo "Error";
        $log = 'Sign Up / Login';
    }
} elseif (!empty($_COOKIE['User']) && empty($_SESSION['User'])) {


    $v = $_COOKIE['User'];
    $_SESSION['User'] = $v;



    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];
        $log = 'Log Out';
        $subject = $row['subject'];
        $login = '../includes/logout.php';
    } else {
        echo "Error";
        $log = 'Sign Up / Login';
    }
} else {

    header("Location:../public/login-sign.php");
}

if ($role == 'Student') {
    header("Location:../students/index.php");
}


$myArray = explode(',', $subject);

$fetch = "SELECT * FROM all_notes WHERE author_mail = '$v'";

$result = $conn->query($fetch);

$note_num = $result->num_rows;

$sql = "SELECT SUM(view) AS total_views FROM all_notes where author_mail = '$v'";
$result = $conn->query($sql);

// Fetch and display result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $view =  $row["total_views"];
} else {
    $view = 0;
}



?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes | Deshboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../public/assest/icon/site.webmanifest" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../public/assest/common.css">
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
    <link rel="stylesheet" href="../students/css/style.css">

    <style>
        .dark .text-gray-900,
        .dark .text-gray-800 {
            color: white;
        }

        .bgg {
            background-color: rgb(244, 244, 244);
        }

        .dark .bgg {
            background-color: rgb(43, 53, 68);
        }
    </style>


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

                <a href="../public/accounts/account.php">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span id="n" class="text-lg font-bold" <?php echo "names = " . $name; ?>></span>
                        </div>
                        <div>
                            <h3 class="font-medium" id="v"><?php echo $name; ?></h3>
                            <p class="text-sm text-gray-400"><?php echo $role; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4">
                <a href="manageNote/manageNote.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="24px" class="w-5 h-5" height="24px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g fill="#ffffff" fill-rule="evenodd">
                                <path d="M17.556 13.111h-.338a.443.443 0 0 1-.311-.76l.236-.236a.448.448 0 0 0 0-.631l-.627-.627a.448.448 0 0 0-.631 0l-.227.227a.433.433 0 0 1-.324.142.446.446 0 0 1-.444-.444v-.338a.446.446 0 0 0-.446-.444h-.888a.446.446 0 0 0-.444.444v.338a.446.446 0 0 1-.444.444.433.433 0 0 1-.324-.142l-.227-.227a.448.448 0 0 0-.631 0l-.627.627a.448.448 0 0 0 0 .631c.084.084.178.164.258.253.076.08.116.19.111.3a.446.446 0 0 1-.444.444h-.34a.446.446 0 0 0-.444.444v.889c.001.245.2.443.444.444h.338c.245.001.443.2.444.444a.408.408 0 0 1-.111.3c-.08.089-.173.169-.258.253a.448.448 0 0 0 0 .631l.627.627a.448.448 0 0 0 .631 0l.227-.227a.433.433 0 0 1 .324-.142c.245.001.443.2.444.444v.338c.001.245.2.443.444.444h.889a.446.446 0 0 0 .444-.444v-.339a.446.446 0 0 1 .444-.444.433.433 0 0 1 .324.142l.227.227a.448.448 0 0 0 .631 0l.627-.627a.448.448 0 0 0 0-.631l-.236-.236a.443.443 0 0 1 .311-.76h.338a.446.446 0 0 0 .447-.445v-.888a.446.446 0 0 0-.444-.445zM14 15.333a1.333 1.333 0 1 1 0-2.666 1.333 1.333 0 0 1 0 2.666z"></path>
                                <path d="M18 4v5.54A5.971 5.971 0 0 0 10.69 9H2v7h6.35c.26.74.664 1.42 1.19 2H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h3V1a1 1 0 1 1 2 0v2h6V1a1 1 0 0 1 2 0v2h3a1 1 0 0 1 1 1z"></path>
                            </g>
                        </g>
                    </svg>
                    <span>Manage Notes</span>
                </a>

                <a href="uploadNote/uploadNote.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span>Upload Notes</span>
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

                <!-- Add this inside the header, next to the search bar -->
                <div class="flex items-center" style="margin-right: 20px;" id="modes">

                </div>
                <div class="flex items-center space-x-4">
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

                    <a href="<?php echo $login; ?>">
                        <button id="loginBtn" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                            <?php echo $log; ?>
                        </button>
                    </a>
                </div>
            </div>
        </header>



        <!-- Main Content Area -->
        <main class="p-6">
            <!-- Teacher Welcome Section -->
            <div class="welcome-container p-6 rounded-xl transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg mb-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="welcome-content md:w-2/3 mb-6 md:mb-0 md:pr-8">
                        <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 ">Welcome, <span class="text-indigo-600 dark:text-indigo-400"><?php echo $name; ?></span>!</h1>
                        <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">Thank you for being part of our teaching community. Your contribution helps students achieve academic excellence.</p>
                        <div class="stats-overview grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                            <div class="stat-card p-4 bg-green-50 bgg rounded-lg">
                                <p class="text-green-600 dark:text-green-300 font-semibold">Notes</p>
                                <p class="text-2xl font-bold text-gray-800 "><?php echo $note_num; ?></p>
                            </div>
                            <div class="stat-card p-4 bg-purple-50 bgg rounded-lg">
                                <p class="text-purple-600 dark:text-purple-300 font-semibold">Views</p>
                                <p class="text-2xl font-bold text-gray-800 "><?php echo $view; ?></p>
                            </div>
                        </div>
                        <a href="uploadNote/uploadNote.php">

                            <button id="uploadNotesBtn" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload New Notes
                            </button>
                        </a>
                    </div>
                    <div class="welcome-illustration md:w-1/3 flex justify-center">
                        <svg class="w-72 h-72" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="250" cy="250" r="200" fill="#f3f4f6" class="dark:fill-gray-700" />
                            <rect x="150" y="130" width="200" height="240" rx="10" fill="#ffffff" class="dark:fill-gray-600" stroke="#4f46e5" stroke-width="8" />
                            <rect x="170" y="170" width="160" height="20" rx="5" fill="#4f46e5" class="dark:fill-indigo-400" />
                            <rect x="170" y="210" width="160" height="10" rx="5" fill="#9ca3af" class="dark:fill-gray-400" />
                            <rect x="170" y="230" width="160" height="10" rx="5" fill="#9ca3af" class="dark:fill-gray-400" />
                            <rect x="170" y="250" width="160" height="10" rx="5" fill="#9ca3af" class="dark:fill-gray-400" />
                            <rect x="170" y="270" width="160" height="10" rx="5" fill="#9ca3af" class="dark:fill-gray-400" />
                            <rect x="170" y="290" width="80" height="30" rx="5" fill="#4f46e5" class="dark:fill-indigo-400" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Subject Cards Section -->

            <!-- Quick Actions Section -->
            <div class="quick-actions bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 ">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="manageNote/manageNote.php" class="action-card flex items-center p-4 bg-indigo-50 bgg rounded-lg hover:bg-indigo-100 dark:hover:bg-gray-600 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <span class="text-gray-800  font-medium">Manage Notes</span>
                    </a>
                    <a href="uploadNote/uploadNote.php" class="action-card flex items-center p-4 bg-green-50 bgg rounded-lg hover:bg-green-100 dark:hover:bg-gray-600 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="text-gray-800  font-medium">Upload Notes</span>
                    </a>

                    <a href="../public/accounts/account.php" class="action-card flex items-center p-4 bg-purple-50 bgg rounded-lg hover:bg-purple-100 dark:hover:bg-gray-600 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-800 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-gray-800  font-medium">Account Settings</span>
                    </a>
                </div>
            </div>


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
                            <li><a href="../students/index.php" class="text-gray-400 hover:text-white transition-colors">View all Notes</a></li>
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
                            <li><a href="../about.html" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>

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
    </script>
    <script src="../public/assest/common.js"></script>
    <!-- <script src="js/script.js"></script> -->
    <script src="js/teacher.js"></script>

</body>

</html>