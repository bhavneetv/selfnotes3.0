<?php
session_start();
require("../includes/connection.php");


if (empty($_COOKIE["subject"])) {


    header("Location: login-sign.php");
    exit();
} else {

    $v = $_COOKIE["subject"];
    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $class = $row['class'];
    }

   
$sql = "SELECT subject FROM all_notes WHERE course = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $class);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {

    // Fetch subjects from the first query
    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = trim($row['subject']);
    }

    // Fetch custom subjects (links)
    $new = "SELECT link FROM all_notes WHERE type = 'subject' AND course = ?";
    $stmt2 = $conn->prepare($new);
    $stmt2->bind_param("s", $class);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $custom_subjects = [];
    while ($row = $result2->fetch_assoc()) {
        // Explode values if they are comma-separated
        $links = explode(',', $row['link']);
        
        // Trim each value and merge into custom_subjects array
        foreach ($links as $link) {
            $custom_subjects[] = trim($link);
        }
    }

    // Remove empty values
    $custom_subjects = array_filter($custom_subjects, fn($value) => !empty($value));
    $subjects = array_filter($subjects, fn($value) => !empty($value));

    // Merge custom subjects into the subjects array at position 1
    array_splice($subjects, 1, 0, $custom_subjects);

    // Remove duplicate values
    $uniqueSubjects = array_unique($subjects);

    // Reset array keys
    $uniqueSubjects = array_values($uniqueSubjects);

    // Sort the array in A-Z order
    sort($uniqueSubjects);

    // print_r($uniqueSubjects);
} else {
    $uniqueSubjects = ["Physics", "EVS", "Mathematics", "Biology", "Chemistry", "English", "History", "Science", "MP", "Hindi"];
    sort($uniqueSubjects);
}

    // $uniqueSubjects = $subjects;
    $stmt->close();
    $conn->close();
}













?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Notes | Subject Selection</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="assest/icon/site.webmanifest" />
    <style>
        /* Animations */
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

        @keyframes scaleIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .form-container {
            animation: scaleIn 0.5s ease-out forwards;
        }

        .checkbox-item {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .theme-transition {
            transition: all 0.4s ease;
        }

        /* Fixed Custom checkbox styling */
        .custom-checkbox {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            user-select: none;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .custom-checkbox:hover {
            transform: translateY(-2px);
        }

        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: relative;
            height: 22px;
            width: 22px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #818cf8;
            /* Indigo-400 */
            background-color: white;
        }

        /* Checkmark styling */
        .custom-checkbox input:checked~.checkmark {
            background-color: #6366f1;
            /* Indigo-500 */
            border-color: #6366f1;
            /* Indigo-500 */
        }

        .custom-checkbox input:checked~.checkmark::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            top: 4px;
        }

        .submit-btn {
            transition: all 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen theme-transition bg-gradient-to-br from-blue-50 to-indigo-50" id="body">
    <div class="container mx-auto px-4 py-12 max-w-2xl">
        <div class="form-container bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header section -->
            <div class="relative bg-gradient-to-r from-indigo-500 to-purple-600 p-6 theme-transition">


                <div class="absolute top-4 right-4">
                    <button id="themeToggle" class="w-10 h-10 flex items-center justify-center rounded-full bg-white bg-opacity-20 text-white hover:bg-opacity-30 transition-all">
                        <span id="darkIcon" class="hidden">🌙</span>
                        <span id="lightIcon">☀️</span>
                    </button>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Subject Selection</h1>
                <p class="text-indigo-100">Choose your favorite subjects for the upcoming semester</p>
                <p class="text-indigo-100">Note : These subject are based on your course and notes available in our database <br> if not available, it will be automatically generated or request Us</p>
            </div>

            <!-- Form section -->
            <form id="subjectForm" class="p-6 theme-transition">
                <div class="space-y-2 mb-8">

                    <?php foreach ($uniqueSubjects as $subject): ?>

                        <div class="checkbox-item" style="animation-delay: 0.1s;">
                            <label class="custom-checkbox theme-transition hover:bg-indigo-50">
                                <input type="checkbox" name="subject" value="<?php echo $subject; ?>">
                                <span class="checkmark mr-4"></span>
                                <div>
                                    <span class="text-gray-800 font-medium theme-transition"><?php echo $subject; ?></span>
                                    <!-- <p class="text-gray-500 text-sm theme-transition">Algebra, Calculus, Statistics</p> -->
                                </div>
                            </label>
                        </div>

                    <?php endforeach; ?>


                </div>

                <!-- Selected count -->
                <div id="selectionCount" class="mb-6 p-4 rounded-lg bg-indigo-50 text-indigo-700 hidden theme-transition">
                    You've selected <span id="selectedCount">0</span> subjects
                </div>

                <!-- Submit button -->
                <button type="submit" id="submitBtn" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-medium rounded-lg submit-btn disabled:opacity-50 disabled:cursor-not-allowed">
                    Submit Selection
                </button>
            </form>
        </div>
    </div>

    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const darkIcon = document.getElementById('darkIcon');
        const lightIcon = document.getElementById('lightIcon');
        const body = document.getElementById('body');
        const checkboxes = document.querySelectorAll('input[name="subject"]');
        const selectionCount = document.getElementById('selectionCount');
        const selectedCount = document.getElementById('selectedCount');
        const submitBtn = document.getElementById('submitBtn');

        // Check for saved theme preference or use default
        const darkMode = localStorage.getItem('darkMode') === 'true';

        // Apply initial theme
        if (darkMode) {
            applyDarkMode();
        }

        // Toggle theme
        themeToggle.addEventListener('click', () => {
            if (body.classList.contains('from-gray-800')) {
                // Switch to light mode
                localStorage.setItem('darkMode', 'false');
                applyLightMode();
            } else {
                // Switch to dark mode
                localStorage.setItem('darkMode', 'true');
                applyDarkMode();
            }
        });

        function applyDarkMode() {
            body.classList.remove('from-blue-50', 'to-indigo-50');
            body.classList.add('from-gray-800', 'to-gray-900');

            document.querySelector('.form-container').classList.remove('bg-white');
            document.querySelector('.form-container').classList.add('bg-gray-800');

            themeToggle.classList.remove('bg-white', 'bg-opacity-20', 'text-white');
            themeToggle.classList.add('bg-gray-700', 'text-yellow-300');

            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');

            document.querySelectorAll('.text-gray-800').forEach(el => {
                el.classList.remove('text-gray-800');
                el.classList.add('text-gray-100');
            });

            document.querySelectorAll('.text-gray-500').forEach(el => {
                el.classList.remove('text-gray-500');
                el.classList.add('text-gray-400');
            });

            document.querySelectorAll('.hover\\:bg-indigo-50').forEach(el => {
                el.classList.remove('hover:bg-indigo-50');
                el.classList.add('hover:bg-gray-700');
            });

            if (selectionCount.classList.contains('bg-indigo-50')) {
                selectionCount.classList.remove('bg-indigo-50', 'text-indigo-700');
                selectionCount.classList.add('bg-gray-700', 'text-indigo-300');
            }
        }

        function applyLightMode() {
            body.classList.remove('from-gray-800', 'to-gray-900');
            body.classList.add('from-blue-50', 'to-indigo-50');

            document.querySelector('.form-container').classList.remove('bg-gray-800');
            document.querySelector('.form-container').classList.add('bg-white');

            themeToggle.classList.remove('bg-gray-700', 'text-yellow-300');
            themeToggle.classList.add('bg-white', 'bg-opacity-20', 'text-white');

            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');

            document.querySelectorAll('.text-gray-100').forEach(el => {
                el.classList.remove('text-gray-100');
                el.classList.add('text-gray-800');
            });

            document.querySelectorAll('.text-gray-400').forEach(el => {
                el.classList.remove('text-gray-400');
                el.classList.add('text-gray-500');
            });

            document.querySelectorAll('.hover\\:bg-gray-700').forEach(el => {
                el.classList.remove('hover:bg-gray-700');
                el.classList.add('hover:bg-indigo-50');
            });

            if (selectionCount.classList.contains('bg-gray-700')) {
                selectionCount.classList.remove('bg-gray-700', 'text-indigo-300');
                selectionCount.classList.add('bg-indigo-50', 'text-indigo-700');
            }
        }

        // Handle checkbox changes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checked = document.querySelectorAll('input[name="subject"]:checked');

                // Update selected count display
                selectedCount.textContent = checked.length;

                if (checked.length > 0) {
                    selectionCount.classList.remove('hidden');
                    selectionCount.style.animation = 'fadeIn 0.3s ease-out forwards';
                    submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                    submitBtn.removeAttribute('disabled');
                } else {
                    selectionCount.classList.add('hidden');
                    submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
                    submitBtn.setAttribute('disabled', 'true');
                }

                // Add pulse animation to checkmark and change background color
                if (checkbox.checked) {
                    const checkmark = checkbox.nextElementSibling;
                    checkmark.style.animation = 'pulse 0.3s ease-out';
                    checkmark.classList.add('bg-indigo-500');

                    // Reset animation
                    setTimeout(() => {
                        checkmark.style.animation = '';
                    }, 300);
                } else {
                    const checkmark = checkbox.nextElementSibling;
                    checkmark.classList.remove('bg-indigo-500');
                }
            });
        });

        // Form submission
        document.getElementById('subjectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const checkboxes = document.querySelectorAll('input[name="subject"]:checked');
            const selectedSubjects = Array.from(checkboxes).map(cb => cb.value);

            if (selectedSubjects.length === 0) {
                alert('Please select at least one subject.');
            } else {
                // alert('You selected: ' + );

                let sub = selectedSubjects.join(',')
                recentAdd(sub);
                document.getElementById("submitBtn").disabled = true;

                // Here you would typically send the data to a server
            }
        });

        // Initialize button state
        submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
        submitBtn.setAttribute('disabled', 'true');

        function recentAdd(NoteId) {
            // alert(NoteId);
            $.ajax({
                type: "POST",
                // Our sample url to make request
                url: "subjectPhp.php",

                data: {
                    subject: NoteId,
                },

                success: function(response) {
                    if (response === "yes") {
                        window.location.href = "../students/index.php";
                    } else {
                        alert(response);
                    }
                },
            });
        }
    </script>
</body>

</html>