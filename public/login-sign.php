<?php
require("../includes/connection.php");
$sql = "SELECT course FROM all_notes ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
// $rows = $result->fetch_assoc();

// echo $result ->num_rows;

if ($result->num_rows > 90) {

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['course'];
    }
} else {


    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['course'];
    }
    $customCourses = ['Btech(cse)', 'BCA', '12th', '10th'];
    array_splice($courses, 1, 0, $customCourses);
}

$uniqueCourses = array_unique($courses);


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes - Login/Signup</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <link rel="icon" type="image/png" href="assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="assest/icon/site.webmanifest" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #4f46e5 0%, #8b5cf6 50%, #d946ef 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4f46e5;
            border-radius: 3px;
        }

        .flip-container {
            perspective: 1000px;
        }

        .flipper {
            transition: 0.6s;
            transform-style: preserve-3d;
            position: relative;
        }

        .flip-container.flip .flipper {
            transform: rotateY(180deg);
        }

        .front,
        .back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .front {
            z-index: 2;
            transform: rotateY(0deg);
        }

        .back {
            transform: rotateY(180deg);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }

        /* Dark Mode */
        .dark body {
            background-color: #0f172a;
            color: #f3f4f6;
        }

        .dark .bg-white {
            background-color: #1e293b;
        }

        .dark .text-gray-800 {
            color: #f3f4f6;
        }

        .dark .text-gray-700 {
            color: #e2e8f0;
        }

        .dark .text-gray-600 {
            color: #cbd5e1;
        }

        .dark .bg-gray-100 {
            background-color: #334155;
        }

        .dark .border-gray-200 {
            border-color: #475569;
        }

        .dark .text-gray-500 {
            color: #94a3b8;
        }

        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .dark-glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .light-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="app()">

    <!-- Sidebar (hidden on mobile) -->
    <nav id="sidebar"
        class="fixed left-0 top-0 w-72 h-full bg-gray-900 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 custom-scrollbar overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold gradient-text">Self Notes</h1>
                <button id="closeSidebar" class="md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- User Profile Section -->
            <div class="mb-8 p-4 bg-gray-800 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-lg font-bold">G</span>
                    </div>
                    <div>
                        <h3 class="font-medium">Guest</h3>
                        <p class="text-sm text-gray-400">Guest</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4">
                <a href="../students/index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="24px" height="24px" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M21.6602 10.44L20.6802 14.62C19.8402 18.23 18.1802 19.69 15.0602 19.39C14.5602 19.35 14.0202 19.26 13.4402 19.12L11.7602 18.72C7.59018 17.73 6.30018 15.67 7.28018 11.49L8.26018 7.30001C8.46018 6.45001 8.70018 5.71001 9.00018 5.10001C10.1702 2.68001 12.1602 2.03001 15.5002 2.82001L17.1702 3.21001C21.3602 4.19001 22.6402 6.26001 21.6602 10.44Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path opacity="0.4" d="M15.0603 19.3901C14.4403 19.8101 13.6603 20.1601 12.7103 20.4701L11.1303 20.9901C7.16034 22.2701 5.07034 21.2001 3.78034 17.2301L2.50034 13.2801C1.22034 9.3101 2.28034 7.2101 6.25034 5.9301L7.83034 5.4101C8.24034 5.2801 8.63034 5.1701 9.00034 5.1001C8.70034 5.7101 8.46034 6.4501 8.26034 7.3001L7.28034 11.4901C6.30034 15.6701 7.59034 17.7301 11.7603 18.7201L13.4403 19.1201C14.0203 19.2601 14.5603 19.3501 15.0603 19.3901Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path opacity="0.4" d="M12.6406 8.52979L17.4906 9.75979" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path opacity="0.4" d="M11.6602 12.3999L14.5602 13.1399" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    <span>Login Guest</span>
                </a>

                <a href="contact/contact.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg height="24px" width="24px" version="1.1" id="Capa_1" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 301.211 301.211" xml:space="preserve" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path style="fill:#ffffff;" d="M301.211,186.788c0-25.181-15.364-45.941-34.952-48.326c-3.446-4.105-7.957-7.287-13.104-9.117 v-2.882c0-27.604-10.767-55.478-29.54-76.475c-19.713-22.049-45.642-34.192-73.009-34.192S97.311,27.939,77.597,49.988 c-18.773,20.998-29.54,48.872-29.54,76.475v2.882c-5.147,1.83-9.658,5.011-13.104,9.117C15.364,140.847,0,161.607,0,186.788 c0,25.183,15.364,45.945,34.954,48.328c5.57,6.635,13.919,10.862,23.239,10.862c16.731,0,30.344-13.611,30.344-30.342v-57.697 c0-15.075-11.054-27.612-25.481-29.947v-1.529c0-11.417,2.059-22.517,5.77-32.873c18.188-21.764,53.591-38.831,81.779-38.831 c28.188,0,63.59,17.067,81.779,38.831c3.711,10.356,5.77,21.457,5.77,32.873v1.529c-14.427,2.335-25.48,14.872-25.48,29.947v57.697 c0,16.73,13.612,30.342,30.344,30.342c9.32,0,17.669-4.228,23.239-10.862c1.232-0.15,2.446-0.376,3.643-0.669 c-5.672,21.692-26.124,35.967-53.579,35.967h-3.055c-9.391,0-18.251-1.736-26.038-5.054c1.668-3.312,2.614-7.047,2.614-11.002 c0-13.53-11.008-24.538-24.539-24.538h-7.405c-13.53,0-24.538,11.008-24.538,24.538c0,13.531,11.008,24.539,24.538,24.539h7.405 c3.768,0,7.339-0.855,10.532-2.379c10.932,5.824,23.784,8.896,37.431,8.896h3.055c18.997,0,36.464-5.987,49.182-16.859 c12.771-10.916,20.118-26.314,20.902-43.617C295.411,216.039,301.211,202.251,301.211,186.788z M157.897,263.898 c-5.26,0-9.538-4.279-9.538-9.539c0-5.259,4.278-9.538,9.538-9.538h7.405c5.26,0,9.539,4.279,9.539,9.538 c0,5.26-4.279,9.539-9.539,9.539H157.897z M286.211,186.788c0,12.703-5.3,24.023-12.873,29.701c0.008-0.284,0.021-0.566,0.021-0.852 v-57.697c0-0.285-0.014-0.567-0.021-0.851C280.911,162.768,286.211,174.086,286.211,186.788z M15,186.788 c0-12.702,5.3-24.02,12.873-29.699c-0.008,0.283-0.021,0.565-0.021,0.851v57.697c0,0.286,0.014,0.568,0.021,0.852 C20.3,210.811,15,199.491,15,186.788z M73.537,157.939v57.697c0,8.459-6.883,15.342-15.344,15.342 c-8.46,0-15.342-6.882-15.342-15.342v-57.697c0-8.46,6.882-15.342,15.342-15.342C66.654,142.598,73.537,149.48,73.537,157.939z M150.605,44.759c-22.364,0-48.109,9.321-68.349,23.435c16.336-22.455,41.385-37.397,68.349-37.397 c26.964,0,52.013,14.942,68.349,37.398C198.715,54.081,172.97,44.759,150.605,44.759z M243.018,230.979 c-8.461,0-15.344-6.882-15.344-15.342v-57.697c0-8.46,6.883-15.342,15.344-15.342c8.46,0,15.342,6.882,15.342,15.342v57.697 C258.359,224.096,251.477,230.979,243.018,230.979z"></path>
                        </g>
                    </svg>
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </nav>




    <div class="black" id="black" style="display: none; position: fixed; inset: 0px; z-index: 1000; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.5);">

        <div id="forgotPasswordEmailModal"
            class="fixed inset-0 flex items-center justify-center p-4 animate-fadeIn bg-black bg-opacity-20 backdrop-blur-sm  z-[1001]" style="z-index: 1001;">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 transform transition-all">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Reset Password</h3>
                    <button
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Enter your email address to receive a password reset code.
                </p>
                <div class="space-y-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input id="reset-email" type="email" placeholder="you@example.com"
                            class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <button id="otpButton"
                        class="w-full py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-105 flex items-center justify-center gap-2">
                        <span id="buttonText">Send Reset Code</span>

                        <!-- New Improved Loader -->
                        <span id="loader-email" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- OTP Verification Modal -->
        <div id="otpVerificationModal"
            class="fixed inset-0 flex items-center justify-center p-4 animate-fadeIn bg-black bg-opacity-20 backdrop-blur-sm hidden z-[1001]" style="z-index: 1001;">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 transform transition-all">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Enter OTP</h3>
                    <button
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Enter the verification code sent to your email.</p>
                <div class="relative" style="z-index: 1001; margin-bottom: 20px;">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="otp" type="number" placeholder="123456"
                        class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <button id="verifyButton"
                    class="w-full py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-105 flex items-center justify-center gap-2">
                    <span id="buttonText">Verify OTP</span>

                    <!-- New Improved Loader -->
                    <span id="loader-otp" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- New Password Modal -->
    <div id="newPasswordModal"
        class="fixed inset-0 flex items-center justify-center p-4 animate-fadeIn bg-black bg-opacity-20 backdrop-blur-sm hidden  z-[1001]" style="z-index: 1001;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Set New Password</h3>
                <button
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="pass-i1" placeholder="••••••••"
                            class="pl-10 pr-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <div class="absolute inset-y-0 left-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <button
                            class="absolute inset-y-0 right-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm
                        Password</label>
                    <div class="relative">
                        <input type="password" id="pass-i2" placeholder="••••••••"
                            class="pl-10 pr-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <div class="absolute inset-y-0 left-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <button
                            class="absolute inset-y-0 right-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button id="resetButton"
                    class="w-full py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-105 flex items-center justify-center gap-2">
                    <span id="buttonText">Reset Password</span>

                    <!-- New Improved Loader -->
                    <span id="loader-new" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    </div>
    <!-- Main Content -->
    <div id="content" class="md:ml-72 transition-all duration-300">
        <!-- Top Navigation -->
        <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <button id="menuBtn"
                    class="md:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>


                <div class="flex items-center space-x-4">
                    <button @click="toggleTheme()"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content Area with Background -->
        <main class="min-h-screen p-6 relative" style="height: 960px;">
            <!-- Background patterns -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -left-20 w-96 h-96 bg-indigo-500 opacity-10 rounded-full filter blur-3xl">
                </div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-500 opacity-10 rounded-full filter blur-3xl">
                </div>
                <div class="absolute top-1/4 right-1/3 w-60 h-60 bg-pink-500 opacity-10 rounded-full filter blur-3xl">
                </div>
            </div>



            <!-- Login/Signup Card -->
            <div class="flex items-center justify-center py-12 relative z-10">
                <div class="flip-container w-full max-w-md" :class="{'flip': isSignup}">
                    <div class="flipper">
                        <!-- Login Form (Front) -->
                        <div class="front">
                            <div class="overflow-hidden rounded-2xl shadow-xl">
                                <!-- Login Header -->
                                <div class="relative h-40 bg-gradient-to-r from-indigo-600 to-purple-600">
                                    <div class="absolute inset-0 opacity-20 mix-blend-overlay">
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                                            <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="url(#trianglify-9o9pxh)"
                                                fill-opacity="1"></path>
                                        </svg>
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 right-0 flex flex-col items-center transform translate-y-1/2">
                                        <div
                                            class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center">
                                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Login Content -->
                                <div class="px-10 pt-14 pb-8 bg-white dark:bg-gray-800 rounded-b-2xl">
                                    <h3 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-1">
                                        Welcome Back</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-center mb-8">Sign in to continue
                                        your learning journey</p>

                                    <form id="loginForm" method="POST" action="login.php">
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="login-email">Email Address</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <input id="login-email" type="email" placeholder="you@example.com" name="email"
                                                        class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                                        for="login-password">Password</label>
                                                    <p id="forgot-password" style="cursor: pointer;"
                                                        class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Forgot
                                                        Password?</p>
                                                </div>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    </div>
                                                    <input id="login-password" type="password" placeholder="••••••••" name="password"
                                                        class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="remember-me" type="checkbox" name="keep"
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="remember-me"
                                                    class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Remember
                                                    me</label>
                                            </div>

                                            <button type="submit"
                                                class="w-full py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-105">
                                                Sign In
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Guest Login Option -->
                                    <div class="mt-4 text-center">
                                        <a href="../students/index.php" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">
                                            Continue as guest
                                        </a>
                                    </div>

                                    <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                                        Don't have an account?
                                        <button @click="isSignup = true"
                                            class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition-colors">
                                            Create an account
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Signup Form (Back) -->
                        <div class="back">
                            <div class="overflow-hidden rounded-2xl shadow-xl">
                                <!-- Signup Header -->
                                <div class="relative h-40 bg-gradient-to-r from-purple-600 to-pink-600">
                                    <div class="absolute inset-0 opacity-20 mix-blend-overlay">
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                                            <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="url(#trianglify-2x6ebs)"
                                                fill-opacity="1"></path>
                                        </svg>
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 right-0 flex flex-col items-center transform translate-y-1/2">
                                        <div
                                            class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center">
                                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Signup Content -->
                                <div class="px-10 pt-14 pb-8 bg-white dark:bg-gray-800 rounded-b-2xl">
                                    <h3 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-1">Create
                                        an Account</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-center mb-8">Join us to start your
                                        learning journey</p>

                                    <form id="signupForm" action="sign.php" method="post">
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="signup-name">Full Name</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <input id="signup-name" type="text" placeholder="John Doe" name="name"
                                                        class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="signup-email">Email Address</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <input id="signup-email" type="email" placeholder="you@example.com"
                                                        name="email" class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="signup-password">Password</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    </div>
                                                    <input id="signup-password" type="password" placeholder="••••••••"
                                                        name="password" class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Password must
                                                    be at least 8 characters long</p>
                                            </div>


                                            <div class="mt-4">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="role">Role</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg fill="#9CA3AF" width="24px" class="w-5 h-5" height="24px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" stroke="#9CA3AF">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path d="M197.769 791.767l60.672-286.853c2.341-11.066-4.733-21.934-15.799-24.275s-21.934 4.733-24.275 15.799l-60.672 286.853c-2.341 11.066 4.733 21.934 15.799 24.275s21.934-4.733 24.275-15.799zm571.063-286.786l61.778 287.068c2.38 11.058 13.273 18.093 24.33 15.713s18.093-13.273 15.713-24.33l-61.778-287.068c-2.38-11.058-13.273-18.093-24.33-15.713s-18.093 13.273-15.713 24.33z"></path>
                                                                <path d="M967.45 386.902L535.9 208.126c-10.609-4.399-30.569-4.442-41.207-.088L57.821 386.901l436.881 178.857c10.624 4.355 30.583 4.313 41.207-.085L967.45 386.901zM551.583 603.516c-20.609 8.533-51.787 8.599-72.409.145L24.437 417.494c-32.587-13.359-32.587-47.847.009-61.188l454.73-186.174c20.641-8.448 51.818-8.382 72.407.156l448.836 185.936c32.466 13.442 32.466 47.913.004 61.354l-448.84 185.938zm288.673 166.569c-98 57.565-209.669 88.356-325.888 88.356-116.363 0-228.162-30.866-326.246-88.564-9.749-5.735-22.301-2.481-28.036 7.268s-2.481 22.301 7.268 28.036c104.336 61.377 223.297 94.22 347.014 94.22 123.564 0 242.386-32.763 346.634-93.998 9.753-5.729 13.015-18.279 7.286-28.032s-18.279-13.015-28.032-7.286z"></path>
                                                                <path d="M983.919 383.052v296.233c0 11.311 9.169 20.48 20.48 20.48s20.48-9.169 20.48-20.48V383.052c0-11.311-9.169-20.48-20.48-20.48s-20.48 9.169-20.48 20.48z"></path>
                                                            </g>
                                                        </svg>

                                                    </div>
                                                    <select name="role" id="role" class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                                        <option value="Student">Student</option>
                                                        <option value="Teacher">Teacher</option>
                                                    </select>




                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                                    for="class">Course/Class</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg width="24px" class="h-5 w-5" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path d="M6 15.5002H7M6 18.5002H7M17 18.5002H18M17 15.5002H18M10 22.0002V18.0002C10 16.8956 10.8954 16.0002 12 16.0002C13.1046 16.0002 14 16.8956 14 18.0002V22.0002M12 5H16.84C16.896 5 16.924 5 16.9454 4.9891C16.9642 4.97951 16.9795 4.96422 16.9891 4.9454C17 4.92401 17 4.89601 17 4.84V2.16C17 2.10399 17 2.07599 16.9891 2.0546C16.9795 2.03578 16.9642 2.02049 16.9454 2.0109C16.924 2 16.896 2 16.84 2H12.16C12.104 2 12.076 2 12.0546 2.0109C12.0358 2.02049 12.0205 2.03578 12.0109 2.0546C12 2.07599 12 2.10399 12 2.16V5ZM12 5V7.69092M12.03 12.25H12.0375M12 7.69092C12.1947 7.69092 12.3895 7.71935 12.5779 7.77623C13.0057 7.90536 13.3841 8.24585 14.1407 8.92681L17 11.5002L18.5761 11.8942C19.4428 12.1109 19.8761 12.2192 20.1988 12.4608C20.4834 12.674 20.7061 12.9592 20.8439 13.2871C21 13.6587 21 14.1053 21 14.9987V18.8002C21 19.9203 21 20.4804 20.782 20.9082C20.5903 21.2845 20.2843 21.5905 19.908 21.7822C19.4802 22.0002 18.9201 22.0002 17.8 22.0002H6.2C5.0799 22.0002 4.51984 22.0002 4.09202 21.7822C3.71569 21.5905 3.40973 21.2845 3.21799 20.9082C3 20.4804 3 19.9203 3 18.8002V14.9987C3 14.1053 3 13.6587 3.15613 13.2871C3.29388 12.9592 3.51657 12.674 3.80124 12.4608C4.12389 12.2192 4.55722 12.1109 5.42388 11.8942L7 11.5002L9.85931 8.92681C10.6159 8.24584 10.9943 7.90536 11.4221 7.77623C11.6105 7.71935 11.8053 7.69092 12 7.69092ZM12.03 13C11.6158 13 11.28 12.6642 11.28 12.25C11.28 11.8358 11.6158 11.5 12.03 11.5C12.4442 11.5 12.78 11.8358 12.78 12.25C12.78 12.6642 12.4442 13 12.03 13Z" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </g>
                                                        </svg>

                                                    </div>
                                                    <select name="class" id="class" class="pl-10 w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                                        <?php foreach ($uniqueCourses as $course) { ?>
                                                            <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                                                        <?php } ?>
                                                    </select>




                                                </div>
                                            </div>





                                            <button type="submit"
                                                class="w-full py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform transition hover:scale-105">
                                                Sign Up
                                            </button>
                                        </div>


                                    </form>



                                    <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                                        Already have an account?
                                        <button @click="isSignup = false"
                                            class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 transition-colors">
                                            Sign in
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <li><a href="../students/index.php" class="text-gray-400 hover:text-white transition-colors">Login Guest</a></li>
                            <!-- <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li> -->
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

    <!-- JavaScript -->
    <script>
        // Alpine.js Application
        function app() {
            return {
                darkMode: localStorage.getItem('theme') === 'true',
                isSignup: false,

                init() {
                    // Initialize dark mode
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }

                    // Mobile menu functionality
                    const menuBtn = document.getElementById('menuBtn');
                    const sidebar = document.getElementById('sidebar');
                    const closeSidebar = document.getElementById('closeSidebar');

                    menuBtn.addEventListener('click', () => {
                        sidebar.classList.remove('-translate-x-full');
                    });

                    closeSidebar.addEventListener('click', () => {
                        sidebar.classList.add('-translate-x-full');
                    });


                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode);

                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },

            }
        }
    </script>

    <script src="js/password.js"></script>



</body>

</html>