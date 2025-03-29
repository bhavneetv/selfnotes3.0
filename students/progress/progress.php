<?php

session_start();
require("../../includes/connection.php");
if(empty($_SESSION["User"])) {


    header("Location: ../../public/login-sign.php");
    exit();
}






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
        $subject = $row['subject'];
        $sub = $row['progress'];
        $time = $row['total_time'];

        $initials = getInitials($name);
    } 
    else{
        header("Location: ../../public/login-sign.php");
        exit();
    }

    $subject = explode(',', $subject);
    $progress  = explode(',', $sub);
    $pro_count = count($progress);
    if ($pro_count == 1) {
        $currentValue = 0;
       
    } else {
        $currentValue = $pro_count ;
        // $currentValue = count($currentValue);
    }

} else {
   
    header("Location: ../../public/login-sign.php");
    exit();
}








?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <title> Self Notes | Progress</title>
    <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />

</head>


<style>
    @media (max-width: 768px) {
        .n {
            display: none;
        }

    }
</style>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
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
            <a href="../index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                <svg width="24px" height="24px" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.6602 10.44L20.6802 14.62C19.8402 18.23 18.1802 19.69 15.0602 19.39C14.5602 19.35 14.0202 19.26 13.4402 19.12L11.7602 18.72C7.59018 17.73 6.30018 15.67 7.28018 11.49L8.26018 7.30001C8.46018 6.45001 8.70018 5.71001 9.00018 5.10001C10.1702 2.68001 12.1602 2.03001 15.5002 2.82001L17.1702 3.21001C21.3602 4.19001 22.6402 6.26001 21.6602 10.44Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="0.4" d="M15.0603 19.3901C14.4403 19.8101 13.6603 20.1601 12.7103 20.4701L11.1303 20.9901C7.16034 22.2701 5.07034 21.2001 3.78034 17.2301L2.50034 13.2801C1.22034 9.3101 2.28034 7.2101 6.25034 5.9301L7.83034 5.4101C8.24034 5.2801 8.63034 5.1701 9.00034 5.1001C8.70034 5.7101 8.46034 6.4501 8.26034 7.3001L7.28034 11.4901C6.30034 15.6701 7.59034 17.7301 11.7603 18.7201L13.4403 19.1201C14.0203 19.2601 14.5603 19.3501 15.0603 19.3901Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="0.4" d="M12.6406 8.52979L17.4906 9.75979" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="0.4" d="M11.6602 12.3999L14.5602 13.1399" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span>Deshboard</span>
                </a>
                <a href="../pyqs/pyqs.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Important Topic</span>
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
        <!-- Replace the main content section in your HTML -->
        <main class="p-6 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <!-- Hero Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-6 transition-colors duration-300">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">My Learning Journey</h1>
                        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Track your progress across all subjects. Find how many ntes you read</p>
                    </div>

                    <!-- Overall Progress Circle -->
                    <div class="flex justify-center mb-8">
                        <div class="relative w-64 h-64">
                            <!-- SVG Circular Progress Bar -->
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                <!-- Background Circle -->
                                <circle cx="50" cy="50" r="45" stroke="gray" stroke-width="10" fill="transparent" opacity="0.2"></circle>
                                <!-- Animated Progress Circle -->
                                <circle id="progress-circle" cx="50" cy="50" r="45" stroke="blue" stroke-width="10" fill="transparent"
                                    stroke-dasharray="283" stroke-dashoffset="283" stroke-linecap="round"
                                    class="transition-all duration-500 ease-out"></circle>
                            </svg>

                            <!-- Progress Text -->
                            <div class="absolute inset-0 flex items-center justify-center flex-col">
                                <span class="text-4xl font-bold text-gray-800 dark:text-white mb-2" id="overall-percentage" percentage="<?php echo $currentValue; ?>">0%</span>
                                <span class="text-gray-600 dark:text-gray-300">Overall Progress</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Summary -->
                    <div class="flex flex-wrap justify-center gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl text-white text-center min-w-[150px]">
                            <div class="text-2xl font-bold"><?php echo count($subject); ?></div>
                            <div class="text-blue-100">Subjects</div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl text-white text-center min-w-[150px]">
                            <div class="text-2xl font-bold"><?php echo $time; ?></div>
                            <div class="text-purple-100">Hours Spent</div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-orange-600 p-4 rounded-xl text-white text-center min-w-[150px]">
                            <div class="text-2xl font-bold"><?php echo $currentValue; ?></div>
                            <div class="text-purple-100">Total Notes</div>
                        </div>

                    </div>
                </div>

                <!-- Subject Progress Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="subject-progress-grid">

                    <!-- Physics Progress -->
                    <div class="subject-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-3 sm:p-4 transform transition-all duration-300 hover:scale-105" data-delay="200">
                        <div class="text-center mb-2">
                            <h3 class="text-sm sm:text-base font-medium text-gray-800 dark:text-white">Physics</h3>
                        </div>
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto flex items-center justify-center">
                            <div class="counter text-2xl sm:text-3xl md:text-4xl font-bold text-green-600 dark:text-green-400 counter-animation" data-target="78">
                                0%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Add this script section just before the closing body tag -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
        <script src="../../public/assest/common.js"></script>
        <script>
            async function loadSubjectCards() {
                try {
                    let response = await fetch("fetch_progress.php");
                    let data = await response.json();

                    let container = document.getElementById("subject-progress-grid");

                    container.innerHTML = "";

                    Object.keys(data).forEach(subject => {
                        let count = data[subject];

                        let card = `
                <div class="subject-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-3 sm:p-4 transform transition-all duration-300 hover:scale-105" data-delay="200">
                        <div class="text-center mb-2">
                            <h3 class="text-sm sm:text-base font-medium text-gray-800 dark:text-white">${subject}</h3>
                        </div>
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto flex items-center justify-center">
                            <div class="counter text-2xl sm:text-3xl md:text-4xl font-bold text-green-600 dark:text-green-400 counter-animation" data-target="${count}">
                                ${count} 
                            </div>
                        </div>
                    </div>
            `;


                        container.innerHTML += card;
                    });
                } catch (error) {
                    console.error("Error fetching subject data:", error);
                }
            }

            window.onload = loadSubjectCards;



            function updateProgress(percentage) {
                const circle = document.getElementById("progress-circle");
                const percentageText = document.getElementById("overall-percentage");


                const circumference = 2 * Math.PI * 45;

                const offset = circumference - (percentage / 100) * circumference;


                circle.style.transition = "stroke-dashoffset 1s ease-in-out";
                circle.style.strokeDashoffset = offset;

                let current = 0;
                const interval = setInterval(() => {
                    if (current >= percentage) {
                        clearInterval(interval);
                    } else {
                        current++;
                        percentageText.innerText = current + "%";
                    }
                }, 10);
            }

            let total = document.getElementById("overall-percentage").getAttribute("percentage");
            console.log(total);
            let totalPercent = parseInt(total / 45 * 100);
            if(totalPercent > 100) totalPercent = 100;
            // console.log(totalPercent);
            setTimeout(() => {
                updateProgress(totalPercent);
            }, 1000);
        </script>

</body>

</html>