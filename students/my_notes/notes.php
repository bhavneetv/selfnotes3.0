<?php

session_start();
require("../../includes/connection.php");

$v = $_SESSION['User'];


function timeAgo($time) {
  
    if (date('H:i:s', strtotime($time)) === "00:00:00") {
        return "Not save";
    }

    $time = new DateTime($time);
    $now = new DateTime();
    $diff = $now->diff($time);

    if ($diff->y > 0) {
        return $diff->y . " year" . ($diff->y > 1 ? "s" : "") . " ago";
    } elseif ($diff->m > 0) {
        return $diff->m . " month" . ($diff->m > 1 ? "s" : "") . " ago";
    } elseif ($diff->d > 0) {
        return $diff->d . " day" . ($diff->d > 1 ? "s" : "") . " ago";
    } elseif ($diff->h > 0) {
        return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago";
    } elseif ($diff->i > 0) {
        return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago";
    } else {
        return "Just now";
    }
}

function getInitials($name) {
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









$ex_name = "SELECT * FROM user WHERE email = '$v' ";
$res = $conn->query($ex_name);

if (empty($v)) {
    header("Location: ../../public/login-sign.php");
    exit();
}

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();

    $name = $row['name'];
    $role = $row['role'];
    $initials = getInitials($name);


    
}
else {
    $name = 'Guest';
    $role = 'Guest';
    $initials = 'G';

    $note1 = 'Guest';
    $note2 = 'Guest';
    $note3 = 'Guest';

    $note1_t = 'Guest';
    $note2_t = 'Guest';
    $note3_t = 'Guest';
}

$ex_notes = "SELECT * FROM my_notes WHERE owner = '$v' ";
$res_notes = $conn->query($ex_notes);
if($res_notes->num_rows > 0){

    $row = $res_notes->fetch_assoc();

    $note1 = $row['note1_name'];
    $note2 = $row['note2_name'];
    $note3 = $row['note3_name'];

    $note1_t = $row['note1_edit'];
    $note1_t = timeAgo($note1_t);
    $note2_t = $row['note2_edit'];
    $note2_t = timeAgo($note2_t);
    $note3_t = $row['note3_edit'];
    $note3_t = timeAgo($note3_t);



   
}
else{
    $note1 = 'Note 1';
    $note2 = 'Note 2';
    $note3 = 'Note 3';

    $note1_t = 'Not save';
    $note2_t = 'Not save';
    $note3_t = 'Not save';
}











?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes | My Notes</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <div id="noteMenu">

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
              <a href="../accounts/account.php">
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
              </a>

                <!-- Navigation Links -->
                <div class="space-y-4">
                    <a href="../index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="30px" height="30px"  class="w-5 h-5" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.7769 10L16.6065 11.2941" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path> <path d="M11 12.8975L13.8978 13.6739" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path> <path d="M20.3116 12.6473C19.7074 14.9024 19.4052 16.0299 18.7203 16.7612C18.1795 17.3386 17.4796 17.7427 16.7092 17.9223C16.6129 17.9448 16.5152 17.9621 16.415 17.9744C15.4999 18.0873 14.3834 17.7881 12.3508 17.2435C10.0957 16.6392 8.96815 16.3371 8.23687 15.6522C7.65945 15.1114 7.25537 14.4115 7.07573 13.641C6.84821 12.6652 7.15033 11.5377 7.75458 9.28263L8.27222 7.35077C8.35912 7.02646 8.43977 6.72546 8.51621 6.44561C8.97128 4.77957 9.27709 3.86298 9.86351 3.23687C10.4043 2.65945 11.1042 2.25537 11.8747 2.07573C12.8504 1.84821 13.978 2.15033 16.2331 2.75458C18.4881 3.35883 19.6157 3.66095 20.347 4.34587C20.9244 4.88668 21.3285 5.58657 21.5081 6.35703C21.669 7.04708 21.565 7.81304 21.2766 9" stroke="#D7D9DB" stroke-width="1.5" stroke-linecap="round"></path> <path d="M3.27222 16.647C3.87647 18.9021 4.17859 20.0296 4.86351 20.7609C5.40432 21.3383 6.10421 21.7424 6.87466 21.922C7.85044 22.1495 8.97798 21.8474 11.2331 21.2432C13.4881 20.6389 14.6157 20.3368 15.347 19.6519C15.8399 19.1902 16.2065 18.6126 16.415 17.9741M8.51621 6.44531C8.16368 6.53646 7.77741 6.63996 7.35077 6.75428C5.09569 7.35853 3.96815 7.66065 3.23687 8.34557C2.65945 8.88638 2.25537 9.58627 2.07573 10.3567C1.91482 11.0468 2.01883 11.8129 2.30728 13" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        <span>Deshboard</span>
                    </a>
                    <a href="../talk/talk.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg width="24px" height="24px" class="w-5 h-5" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ffffff;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><path class="cls-1" d="M22.5,10.05v10.5l-2.86-2.87H11.05a3.81,3.81,0,0,1-3.7-2.86,3.77,3.77,0,0,1-.12-1V10.05a3.82,3.82,0,0,1,3.82-3.82h7.63A3.82,3.82,0,0,1,22.5,10.05Z"></path><path class="cls-1" d="M16.77,5.27v1H11.05a3.82,3.82,0,0,0-3.82,3.82v2.86H4.36L1.5,15.77V5.27A3.82,3.82,0,0,1,5.32,1.45H13A3.82,3.82,0,0,1,16.77,5.27Z"></path></g></svg>
                        <span>My Chats</span>
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
        <!--  -->
        <!-- <div id="content" class="md:ml-72 transition-all duration-300"> -->
        <!-- Top Navigation -->

        <!-- Main Content -->
        <div id="content" class="md:ml-72 transition-all duration-300">
            <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-30">
                <div class="flex items-center justify-between px-6 py-4 " style="height: 70px;">
                    <button id="menuBtn"
                        class="md:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>


            </header>
            <!-- Main Content Area -->
            <div id="editNameModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50"
                style="background-color: rgba(43, 46, 51, 0.62);">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-96">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Name</h3>
                        <button onclick="closeModal('editNameModal')"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <input type="text" id="ei"
                        class="w-full px-4 py-2 mb-4 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter new name">
                    <button
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors" id="saveChangesBtn">Save
                        Changes</button>
                </div>
            </div>


            <main class="p-6">
                <div class="max-w-6xl mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Notes</h1>

                    </div>

                    <!-- Notes Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Note Card 1 -->

                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo $note1; ?></h3>
                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <i class="fa-solid fa-pen" note_n="note1"></i>
                                        </button>
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <i class="fa-solid fa-lock"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Last edited: <?php echo $note1_t; ?></p>
                                <div class="flex justify-between items-center">
                                    <button
                                        class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors next"
                                        note="note1">View
                                        Note</button>
                                    <!-- <i class="fa-solid fa-pen"></i> -->
                                </div>
                            </div>
                        </div>


                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo $note2; ?></h3>
                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <i class="fa-solid fa-pen" note_n="note2"></i>
                                        </button>
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <!-- <i class="fa-solid fa-lock"></i> -->
                                        </button>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Last edited: <?php echo $note2_t; ?></p>   
                                <div class="flex justify-between items-center">
                                    <button
                                        class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors next"
                                        note="note2">View
                                        Note</button>
                                    <!-- <i class="fa-solid fa-pen"></i> -->
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo $note3; ?></h3>
                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <i class="fa-solid fa-pen" note_n="note3"></i>
                                        </button>
                                        <button
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                            <!-- <i class="fa-solid fa-lock"></i> -->
                                        </button>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Last edited: <?php echo $note3_t; ?></p>
                                <div class="flex justify-between items-center">
                                    <button
                                        class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors next"
                                        note="note3">View
                                        Note</button>
                                    <!-- <i class="fa-solid fa-pen"></i> -->
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 2 -->

            </main>

        </div>
    </div>
    </div>

    <!--! ---------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div id="textarea" style="display: none;">

        <body class="min-h-screen transition-colors duration-200">
            <div class="container mx-auto px-4 py-8 max-w-5xl">
                <!-- Floating Header -->
                <div
                    class="glass-effect flex justify-between items-center mb-8 p-4 rounded-2xl shadow-lg sticky top-4 z-50">
                    <div class="flex items-center gap-4">
                        <button onclick="goBack()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 shadow-md">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Back</span>
                        </button>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white hidden md:block">My Notes
                        </h1>
                    </div>
                    <div class="flex items-center gap-3">
                       
                        <button id="saveBtn"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl transition duration-200 flex items-center gap-2 shadow-md">
                            <i class="fas fa-save"></i>
                            <span class="hidden sm:inline">Save</span>
                        </button>
                    </div>
                </div>

                <!-- Note Title and Tags -->
                <div class="mb-6 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <input type="text" placeholder="Note Title" disabled id="note_i"
                            class="flex-1 px-4 py-3 text-xl font-semibold bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="px-4 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">Notes</span>
                        <span
                            class="px-4 py-1.5 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm font-medium">Personal</span>
                    </div>
                </div>

                <!-- Toolbar -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-t-2xl border border-gray-200 dark:border-gray-700 p-4 flex flex-wrap gap-4 shadow-lg">
                    <div
                        class="toolbar-group flex items-center gap-3 border-r border-gray-200 dark:border-gray-700 pr-4">
                        <select id="fontFamily" onchange="formatText('fontName')"
                            class="bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-3 py-2">
                            <option value="Arial">Arial</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Courier New">Courier New</option>
                        </select>
                        <select id="fontSize" onchange="formatText('fontSize')"
                            class="bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-3 py-2">
                            <option value="1">Small</option>
                            <option value="3" selected>Normal</option>
                            <option value="5">Large</option>
                            <option value="7">Huge</option>
                        </select>
                    </div>

                    <div
                        class="toolbar-group flex items-center gap-2 border-r border-gray-200 dark:border-gray-700 pr-4">
                        <button onclick="formatText('bold')" class="toolbar-btn tooltip" data-tooltip="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button onclick="formatText('italic')" class="toolbar-btn tooltip" data-tooltip="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button onclick="formatText('underline')" class="toolbar-btn tooltip" data-tooltip="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <button onclick="formatText('strikeThrough')" class="toolbar-btn tooltip" data-tooltip="Strike">
                            <i class="fas fa-strikethrough"></i>
                        </button>
                    </div>

                    <div
                        class="toolbar-group flex items-center gap-2 border-r border-gray-200 dark:border-gray-700 pr-4">
                        <button onclick="formatText('justifyLeft')" class="toolbar-btn tooltip"
                            data-tooltip="Align Left">
                            <i class="fas fa-align-left"></i>
                        </button>
                        <button onclick="formatText('justifyCenter')" class="toolbar-btn tooltip"
                            data-tooltip="Align Center">
                            <i class="fas fa-align-center"></i>
                        </button>
                        <button onclick="formatText('justifyRight')" class="toolbar-btn tooltip"
                            data-tooltip="Align Right">
                            <i class="fas fa-align-right"></i>
                        </button>
                        <button onclick="formatText('justifyFull')" class="toolbar-btn tooltip" data-tooltip="Justify">
                            <i class="fas fa-align-justify"></i>
                        </button>
                    </div>

                    <div class="toolbar-group flex items-center gap-2">
                        <input type="color" onchange="formatText('foreColor')"
                            class="tooltip h-9 w-9 rounded-lg cursor-pointer" data-tooltip="Text Color">
                        <button onclick="formatText('insertUnorderedList')" class="toolbar-btn tooltip"
                            data-tooltip="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button onclick="formatText('insertOrderedList')" class="toolbar-btn tooltip"
                            data-tooltip="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>
                        <button onclick="formatText('indent')" class="toolbar-btn tooltip" data-tooltip="Indent">
                            <i class="fas fa-indent"></i>
                        </button>
                        <button onclick="formatText('outdent')" class="toolbar-btn tooltip" data-tooltip="Outdent">
                            <i class="fas fa-outdent"></i>
                        </button>
                    </div>
                </div>

                <!-- Editor -->
                <div contenteditable="true" id="editor"
                    class="w-full p-8 bg-white dark:bg-gray-800 border border-t-0 border-gray-200 dark:border-gray-700 rounded-b-2xl text-gray-800 dark:text-white shadow-lg mb-6">
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center sm:justify-start gap-4 mt-8">
                    <button onclick="clearNote()"
                        class="action-btn bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-lg">
                        <i class="fas fa-eraser"></i>
                        <span class="hidden sm:inline">Clear</span>
                    </button>
                    <button id="deleteBtn"
                        class="action-btn bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-lg">
                        <i class="fas fa-trash"></i>
                        <span class="hidden sm:inline">Delete</span>
                    </button>
                    <button onclick="downloadNote()"
                        class="action-btn bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-lg">
                        <i class="fas fa-download"></i>
                        <span class="hidden sm:inline">Export</span>
                    </button>
                </div>
            </div>
    </div>

    <script src="note.js"></script>
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
    </script>

    <script src="https://kit.fontawesome.com/7967a222d3.js" crossorigin="anonymous"></script>
</body>

</html>