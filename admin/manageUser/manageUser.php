<?php
session_start();
require("../../includes/connection.php");



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
        $login = '../../includes/logout.php';
    } else {
        echo "Error";
        $log = 'Sign Up / Login';
    }
} else {

    header("Location:../../public/login-sign.php");
}

if ($role == 'Student') {
    header("Location:../../students/index.php");
}
if($role == 'Teacher') {
    header("Location:../../teacher/teacherMain.php");
}


$myArray = explode(',', $subject);

$fetch = "SELECT * FROM user";

$result = $conn->query($fetch);

$note_num = $result->num_rows;




?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes | Manage User</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../public/assest/common.css">
    <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />
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
       .dark .text-gray-900 , .dark .text-gray-800{
        color: white;
       }

       .bgg{
        background-color: rgb(244, 244, 244);
       }
       .dark .bgg{
        background-color: rgb(43, 53, 68);
       }
      .dark .border-t{
        background-color: var(--color-gray-700);
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

                <a href="../../public/accounts/account.php">
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
                <a href="../approve/approve.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg fill="#ffffff" height="24px" width="24px" class="w-5 h-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.695 491.695" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M436.714,0H149.471c-16.438,0-29.812,13.374-29.812,29.812v66.714c-54.49,15.594-94.489,65.857-94.489,125.288 c0,59.431,39.998,109.694,94.489,125.288v114.783c0,16.438,13.374,29.812,29.812,29.812h234.733c2.785,0,5.455-1.106,7.425-3.075 l71.821-71.822c1.969-1.969,3.075-4.64,3.075-7.425V29.812C466.525,13.374,453.152,0,436.714,0z M149.471,21h287.243 c4.858,0,8.811,3.953,8.811,8.812v31.689H140.659V29.812C140.659,24.953,144.612,21,149.471,21z M46.17,221.813 c0-60.263,49.027-109.29,109.29-109.29c60.263,0,109.29,49.027,109.29,109.29s-49.027,109.291-109.29,109.291 C95.197,331.104,46.17,282.076,46.17,221.813z M140.659,461.884V351.258c4.86,0.552,9.797,0.846,14.802,0.846 c39.135,0,74.292-17.347,98.195-44.752h64.336c5.799,0,10.5-4.701,10.5-10.5s-4.701-10.5-10.5-10.5h-49.381 c9.133-15.95,14.984-34.005,16.644-53.242h32.736c5.799,0,10.5-4.701,10.5-10.5c0-5.799-4.701-10.5-10.5-10.5h-32.603 c-1.42-19.194-7.02-37.242-15.886-53.241h48.488c5.799,0,10.5-4.701,10.5-10.5c0-5.799-4.701-10.5-10.5-10.5h-62.974 c-23.918-28.323-59.67-46.347-99.558-46.347c-5.005,0-9.942,0.294-14.802,0.846v-9.867h304.866v316.372h-42.009 c-16.439,0-29.811,13.374-29.811,29.811v42.011H149.471C144.612,470.695,140.659,466.743,140.659,461.884z M394.705,455.845v-27.16 c0-4.859,3.953-8.811,8.811-8.811h27.16L394.705,455.845z"></path> <path d="M359.246,158.869h34.87c5.799,0,10.5-4.701,10.5-10.5c0-5.799-4.701-10.5-10.5-10.5h-34.87c-5.799,0-10.5,4.701-10.5,10.5 C348.746,154.168,353.447,158.869,359.246,158.869z"></path> <path d="M359.246,233.11h34.87c5.799,0,10.5-4.701,10.5-10.5c0-5.799-4.701-10.5-10.5-10.5h-34.87c-5.799,0-10.5,4.701-10.5,10.5 C348.746,228.409,353.447,233.11,359.246,233.11z"></path> <path d="M359.246,307.352h34.87c5.799,0,10.5-4.701,10.5-10.5s-4.701-10.5-10.5-10.5h-34.87c-5.799,0-10.5,4.701-10.5,10.5 S353.447,307.352,359.246,307.352z"></path> <path d="M394.116,381.593c5.799,0,10.5-4.701,10.5-10.5s-4.701-10.5-10.5-10.5h-98.225c-5.799,0-10.5,4.701-10.5,10.5 s4.701,10.5,10.5,10.5H394.116z"></path> <path d="M236.982,168.845l-12.81-12.81c-3.45-3.449-8.036-5.349-12.915-5.349s-9.465,1.9-12.915,5.349l-67.19,67.19l-18.573-18.573 c-3.449-3.448-8.036-5.348-12.914-5.348c-4.878,0-9.465,1.9-12.914,5.349l-12.813,12.812c-7.12,7.121-7.12,18.708,0.001,25.829 l44.297,44.296c3.45,3.451,8.037,5.351,12.916,5.351c0,0,0.001,0,0.001,0c4.878,0,9.465-1.9,12.913-5.349l92.917-92.917 C244.103,187.554,244.103,175.966,236.982,168.845z M131.151,270.807l-40.429-40.428l8.942-8.942l24.062,24.062 c4.101,4.101,10.749,4.101,14.85,0l72.681-72.681l8.942,8.942L131.151,270.807z"></path> </g> </g></svg>
                    <span>Approve Notes</span>
                </a>

               
                <a href="../../teacher/manageNote/manageNote.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                <svg width="24px" class="w-5 h-5" height="24px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="#ffffff" fill-rule="evenodd"> <path d="M17.556 13.111h-.338a.443.443 0 0 1-.311-.76l.236-.236a.448.448 0 0 0 0-.631l-.627-.627a.448.448 0 0 0-.631 0l-.227.227a.433.433 0 0 1-.324.142.446.446 0 0 1-.444-.444v-.338a.446.446 0 0 0-.446-.444h-.888a.446.446 0 0 0-.444.444v.338a.446.446 0 0 1-.444.444.433.433 0 0 1-.324-.142l-.227-.227a.448.448 0 0 0-.631 0l-.627.627a.448.448 0 0 0 0 .631c.084.084.178.164.258.253.076.08.116.19.111.3a.446.446 0 0 1-.444.444h-.34a.446.446 0 0 0-.444.444v.889c.001.245.2.443.444.444h.338c.245.001.443.2.444.444a.408.408 0 0 1-.111.3c-.08.089-.173.169-.258.253a.448.448 0 0 0 0 .631l.627.627a.448.448 0 0 0 .631 0l.227-.227a.433.433 0 0 1 .324-.142c.245.001.443.2.444.444v.338c.001.245.2.443.444.444h.889a.446.446 0 0 0 .444-.444v-.339a.446.446 0 0 1 .444-.444.433.433 0 0 1 .324.142l.227.227a.448.448 0 0 0 .631 0l.627-.627a.448.448 0 0 0 0-.631l-.236-.236a.443.443 0 0 1 .311-.76h.338a.446.446 0 0 0 .447-.445v-.888a.446.446 0 0 0-.444-.445zM14 15.333a1.333 1.333 0 1 1 0-2.666 1.333 1.333 0 0 1 0 2.666z"></path> <path d="M18 4v5.54A5.971 5.971 0 0 0 10.69 9H2v7h6.35c.26.74.664 1.42 1.19 2H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h3V1a1 1 0 1 1 2 0v2h6V1a1 1 0 0 1 2 0v2h3a1 1 0 0 1 1 1z"></path> </g> </g></svg>
                    <span>Manage Notes</span>
                </a>

                <a href="../../teacher/uploadNote/uploadNote.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span>Upload Notes</span>
                </a>

                <a href="../../public/contact/contact.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
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
        <main class="container mx-auto px-4 py-8">
        <!-- Admin Users Management Section -->
        <div class="mb-8 fade-in" style="animation-delay: 0.1s;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 e mb-2">User Management</h2>
                    <p class="text-gray-600 dark:text-gray-400">View and manage user accounts</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center">
                    <div class="relative mr-4">
                        <input
                            id="searchInput"
                            type="text"
                            placeholder="Search users..."
                            class="pl-10 pr-4 py-2 w-full md:w-64 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                   
                </div>
            </div>
        </div>

        <!-- User Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 fade-in" style="animation-delay: 0.2s;">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex items-center">
                <div class="rounded-full bg-indigo-100 dark:bg-indigo-900 p-3 mr-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 "><?php echo $note_num; ?> </p>
                </div>
            </div>

            
        </div>

        <!-- User Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in" style="animation-delay: 0.3s;" id="user-grid">
            <!-- User 1 -->
           

            <!-- User 2 -->
           
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
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Subjects</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mathematics</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Physics</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Chemistry</a></li>
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
    <script src="../../public/assest/common.js"></script>
    <!-- <script src="js/script.js"></script> -->
    <script src="../../teacher/js/teacher.js"></script>
    <script src="approve.js"></script>

</body>

</html>