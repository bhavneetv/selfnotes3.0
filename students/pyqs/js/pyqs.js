// Subject dropdown functionality
// Toggle Dark Mode

const body = document.getElementById("b");




// Loading Screen
window.addEventListener("load", () => {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.add("-translate-x-full");
  setTimeout(() => {
    document.getElementById("loadingScreen").style.opacity = "0";
    setTimeout(() => {
      document.getElementById("loadingScreen").style.display = "none";
    }, 500);
  }, 1500);
});

// Mobile menu functionality

document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.add("-translate-x-full");
  const menuBtn = document.getElementById("menuBtn");

  // Function to check if device width is less than 1500px
  function isMobileView() {
    return window.innerWidth < 1500;
  }

  // Toggle sidebar
  menuBtn.addEventListener("click", function () {
    sidebar.classList.toggle("-translate-x-full");
    document.getElementById("closeSidebar").style.display = "block";
  });

  // Handle window resize
  window.addEventListener("resize", function () {
    if (!isMobileView()) {
      sidebar.classList.remove("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    } else {
      sidebar.classList.add("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    }
  });

  // Initial state check
  if (!isMobileView()) {
    sidebar.classList.remove("-translate-x-full");
    document.getElementById("closeSidebar").style.display = "block";
  }


  document
    .getElementById("closeSidebar")
    .addEventListener("click", function () {
      sidebar.classList.add("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "none";
    });
});

document.addEventListener("DOMContentLoaded", async function () {
  // Function to create a note container
  function createNoteContainer(data) {
  
    return `
       

<!-- Refined PYQ Container Card -->
<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden relative group border border-gray-100 note_box">
    <!-- Decorative left border -->
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-green-400 to-blue-500"></div>
    
    <div class="p-5 sm:p-6">
        <!-- Header with year, subject and uploader -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-medium shadow-sm year" >${data.chapter}</span>
                <span class="text-gray-700 font-medium subject" style="text-transform: capitalize;">${data.subject}</span>
            </div>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="author">Uploaded by:${data.uploaded_By}</span>
            </div>
        </div>
        
        <!-- Paper title with icon -->
        <div class="flex items-start mb-5">
            <div class="mr-3 flex-shrink-0 p-2 bg-gray-50 rounded-lg text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1 title" style="text-transform: capitalize;">${data.title}</h3>
                <div class="flex items-center text-gray-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <span>70 marks</span>
                </div>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="h-px bg-gray-100 w-full my-3"></div>
        
        <!-- Download button -->
        <div class="flex justify-end mt-4">
            <a href="${data.link}">
            <button class="group relative inline-flex items-center px-4 py-2 overflow-hidden rounded-lg bg-green-600 text-white transition-all duration-300 ease-out hover:bg-green-700 shadow-md hover:shadow-lg">
                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download PDF</span>
            </button>
            </a>
        </div>
    </div>
</div>
      `;
  }

  // Function to load notes into the notesSection div
  function loadNotes(data) {
    const skeletonScreen = document.getElementById("skeletonScreen");
    const notesSection = document.getElementById("notesSection");

    // Show skeleton screen
    skeletonScreen.classList.remove("hidden");
    notesSection.classList.add("hidden");

    // Simulate loading delay (e.g., fetching data)
    setTimeout(() => {
      // Clear existing content
      notesSection.innerHTML = "";

      // Add new notes
      data.forEach((item) => {
        const noteElement = document.createElement("div");
        noteElement.innerHTML = createNoteContainer(item);
        notesSection.appendChild(noteElement);
      });

      // Hide skeleton screen and show notes
      skeletonScreen.classList.add("hidden");
      notesSection.classList.remove("hidden");
    }, 1000); // Simulate a 1-second delay
  }

  // function to check if the id exists



  function fetchNotes() {
    fetch("js/fetch.php")
      .then((response) => response.json())
      .then((data) => {
        // jsonData.push(data);
        // console.log(data);
        // loadNotes(data , id);
        loadNotes(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }
  
  fetchNotes()

});
