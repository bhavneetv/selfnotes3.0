<?php
session_start();
require("../../includes/connection.php");


// echo "<script>alert('g')</script>";

if (empty($_SESSION['User'])) {
    header("Location: ../login-sign.php");
    exit();
}

else  {
    $v = $_SESSION['User'];
    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);
    $row = $res->fetch_assoc();

    $name = $row['name'];
    $email = $row['email'];
   
    $role = $row['role'];
  


    if ($role == "Student") {
        header("Location: ../../students/index.php");
    } elseif ($role == "Teacher") {
        $link = "../../teacher/teacherMain.php";
    } elseif ($role == "Admin") {
        $link = "../../admin/adminMain.php";
    }
} 

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
    <title>Self Notes | Account</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="../assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../assest/icon/site.webmanifest" />

</head>

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
                        <span class="text-lg font-bold" id="vvv">RR</span>
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
                    <span>Deshboard</span>
                </a>


                <a href="../contact/contact.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
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


        <main class="p-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 transition-colors duration-300">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Account Details</h1>
                        <div class="flex space-x-4">

                            <button id="editBtn" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                                Edit Profile
                            </button>
                            <button id="saveBtn" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors" style="display:none">
                                Save Profile
                            </button>
                        </div>
                    </div>

                    <!-- Profile Section -->
                    <div class="mb-8">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-3xl font-bold text-white" id='vv'>RR</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white" id="v"><?php echo $name; ?></h2>
                                <p class="text-gray-500 dark:text-gray-400"><?php echo $role; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Personal Information</h3>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Full Name</label>
                                <input type="text" value="<?php echo $name; ?>" id="name"
                                    class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors inp"
                                    disabled>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Email Address</label>
                                <input type="email" value="<?php echo $email; ?>" id="email"
                                    class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors inp"
                                    disabled>
                            </div>
                        </div>

                        <!-- Academic Information -->

                    </div>



                    <!-- Progress Summary -->
                    <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl transition-colors duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Learning Progress</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow transition-colors duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Notes Created</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo $note_num; ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow transition-colors duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Total Views</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo $view; ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Your existing footer code goes here -->
    </div>

    <script>

        function getInitials(name) {
            // Split the name by spaces
            let words = name.trim().split(/\s+/);

            // Extract the first letter of each word and join them
            let initials = words.map(word => word[0]).join('');

            return initials.toUpperCase(); // Convert to uppercase if needed
        }

        // Example usage


        let names = document.getElementById("v").innerHTML;
        document.getElementById("vv").innerHTML = getInitials(names);
        document.getElementById("vvv").innerHTML = getInitials(names);


        // Edit functionality
        document.getElementById('editBtn').addEventListener('click', function() {
            let all_btn = document.querySelectorAll('.inp');
            all_btn.forEach(input => {
                input.disabled = !input.disabled;
                if (!input.disabled) {
                    input.focus();
                }
            });

            this.style.display = 'none'
            document.getElementById('saveBtn').style.display = 'block'
        });

        document.getElementById('saveBtn').addEventListener('click', function() {
            // js ajax script will be run

        });



        // Mobile menu functionality
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

        // Subject dropdown functionality



        function openPopup() {
            document.getElementById('subjectPopup').style.display = 'flex';
        }



        function infoUptade(n, e) {


            $.ajax({

                type: "POST",
                // Our sample url to make request 
                url: 'uptade_info.php',

                data: {
                    name: n,
                    email: e,
                  


                },

                success: function(response) {

                    if (response == "true") {
                        alert("Info Updated");
                        window.location.reload();
                    } else {
                        alert("Info Not Updated");
                    }


                },
            });
        }

        document.getElementById('saveBtn').addEventListener('click', function() {
            let n = document.getElementById('name').value;
            let e = document.getElementById('email').value;
            // let g = document.getElementById('classc').value;
            infoUptade(n, e);
        });
    </script>
</body>

</html>