<?php

session_start();
require("../../includes/connection.php");






function getInitials($name)
{
    // Trim and remove extra spaces
    $name = trim(preg_replace('/\s+/', ' ', $name));

    // Split name into words
    $words = explode(" ", $name);

    // Get the first letter of the first word
    $firstLetter = strtoupper(substr($words[0], 0, 1));

    // Get the first letter of the last word (if exists)
    $lastLetter = isset($words[1]) ? strtoupper(substr(end($words), 0, 1)) : '';

    // Return initials
    return $firstLetter . $lastLetter;
}

// Example Usage:






if (!empty($_SESSION['User'])) {
    $v = $_SESSION['User'];



    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);


    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $name = $row['name'];
        $role = $row['role'];
        $email = $row['email'];

        $initials = getInitials($name);
        if ($role == "admin") {
            $link = "../../admin/adminMain.php";
        } elseif ($role == "Teacher") {
            $link = "../../teacher/teacherMain.php";
        } else {
            $link = "../../students/index.php";
        }
    } else {
        $name = 'Guest';
        $role = 'Guest';
        $initials = 'G';
        $email = '';
        $link = "../../students/index.php";
    }
}
else{
    $name = 'Guest';
    $role = 'Guest';
    $email = '';
    $initials = 'G';
    $link = "../../students/index.php";
}










?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Self Notes</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link rel="icon" type="image/png" href="../assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../assest/icon/site.webmanifest" />
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <style>
        .loading-spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading .loading-spinner {
            display: inline-block;
        }

        .loading .button-text {
            display: none;
        }
    </style>
    <!-- Existing Sidebar starts here -->
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
                        <span class="text-lg font-bold"><?php echo $initials; ?></span>
                    </div>
                    <div>
                        <h3 class="font-medium"><?php echo $name; ?></h3>
                        <p class="text-sm text-gray-400"><?php echo $role; ?></p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4">
                <a href="<?php echo $link; ?>" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="30px" height="30px" class="w-5 h-5" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M11.7769 10L16.6065 11.2941" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M11 12.8975L13.8978 13.6739" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M20.3116 12.6473C19.7074 14.9024 19.4052 16.0299 18.7203 16.7612C18.1795 17.3386 17.4796 17.7427 16.7092 17.9223C16.6129 17.9448 16.5152 17.9621 16.415 17.9744C15.4999 18.0873 14.3834 17.7881 12.3508 17.2435C10.0957 16.6392 8.96815 16.3371 8.23687 15.6522C7.65945 15.1114 7.25537 14.4115 7.07573 13.641C6.84821 12.6652 7.15033 11.5377 7.75458 9.28263L8.27222 7.35077C8.35912 7.02646 8.43977 6.72546 8.51621 6.44561C8.97128 4.77957 9.27709 3.86298 9.86351 3.23687C10.4043 2.65945 11.1042 2.25537 11.8747 2.07573C12.8504 1.84821 13.978 2.15033 16.2331 2.75458C18.4881 3.35883 19.6157 3.66095 20.347 4.34587C20.9244 4.88668 21.3285 5.58657 21.5081 6.35703C21.669 7.04708 21.565 7.81304 21.2766 9" stroke="#D7D9DB" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M3.27222 16.647C3.87647 18.9021 4.17859 20.0296 4.86351 20.7609C5.40432 21.3383 6.10421 21.7424 6.87466 21.922C7.85044 22.1495 8.97798 21.8474 11.2331 21.2432C13.4881 20.6389 14.6157 20.3368 15.347 19.6519C15.8399 19.1902 16.2065 18.6126 16.415 17.9741M8.51621 6.44531C8.16368 6.53646 7.77741 6.63996 7.35077 6.75428C5.09569 7.35853 3.96815 7.66065 3.23687 8.34557C2.65945 8.88638 2.25537 9.58627 2.07573 10.3567C1.91482 11.0468 2.01883 11.8129 2.30728 13" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    <span>Deshboard</span>
                </a>

            </div>
        </div>
    </nav>

    <!-- Your existing sidebar code goes here -->

    <!-- Main Content -->
    <div id="content" class="md:ml-72 transition-all duration-300">
        <!-- Your existing header code goes here -->
        <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <button id="menuBtn"
                    class="md:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>



            </div>
        </header>

        <!-- Account Details Content -->
        <!-- Main Content -->
        <!-- Main Content -->
        <main class="p-6">
            <div class="max-w-5xl mx-auto">
                <!-- Hero Section -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-4">Get in Touch</h1>
                    <div class="w-24 h-1 bg-indigo-600 mx-auto mb-4 rounded-full"></div>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Have questions or need assistance? We're here to help! Fill out the form below and we'll get back to you as soon as possible.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Contact Information Cards -->
                    <div class="space-y-6">
                        <!-- Quick Contact Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Email Us</h3>
                                    <p class="text-indigo-600 dark:text-indigo-400">selfnotesofficals@gmail.com</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Available 24/7 for your questions and concerns.</p>
                        </div>

                        <!-- Phone Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Call Us</h3>
                                    <p class="text-green-600 dark:text-green-400">+91 935050XXX</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Mon-Fri: 9:00 AM - 6:00 PM</p>
                        </div>

                        <!-- Location Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Visit Us</h3>
                                    <p class="text-pink-600 dark:text-pink-400">Our Office</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Ambala, Haryana<br>India</p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="md:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                            <form class="space-y-6" id="contactForm" action="https://api.web3forms.com/submit" method="POST">
                                <input type="hidden" name="access_key" value="7e4074bc-1245-4410-bfd5-87f8d050dffd">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name Input -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Full Name</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="name"
                                                class="w-full pl-10 px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"
                                                placeholder="John Doe" value="<?php echo $name; ?>" required>
                                        </div>
                                    </div>

                                    <!-- Email Input -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Email Address</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                                </svg>
                                            </div>
                                            <input type="email" name="email"
                                                class="w-full pl-10 px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"
                                                placeholder="john@example.com" value="<?php echo $email; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Problem Type Select -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Type of Problem</label>
                                    <div class="relative">
                                        <select name="type" class="w-full px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors appearance-none">
                                            <option value="" disabled selected>Please select an option</option>
                                            <option value="technical">Technical Issue</option>
                                            <option value="account">Account Related</option>

                                            <option value="request_subject">Request Subject</option>
                                            <option value="feature">Feature Request</option>
                                            <option value="subject_course">Subject/Course</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Textarea -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Your Message</label>
                                    <textarea name="message" rows="6"
                                        class="w-full px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors resize-none"
                                        placeholder="Please describe your problem or question in detail..."></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit"
                                        id="submitButton"
                                        class="group relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 overflow-hidden">
                                        <span class="relative z-10 flex items-center">
                                            <span class="button-text flex items-center">
                                                Send Message
                                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </span>
                                            <span class="loading-spinner"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Your existing footer code goes here -->
    </div>
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        closeSidebarBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

       

        let b = document.getElementById('submitButton');
        b.addEventListener('click', () => {

                b.classList.add('loading');
                // b.disabled = true;

            })
            // const form = document.getElementById('contactForm');

            // Add loading state

         
        
    </script>


</body>

</html>