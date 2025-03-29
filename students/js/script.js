// to toggle dark mode
const themeToggle = document.getElementById("themeToggle");
const body = document.getElementById("b");

themeToggle.addEventListener("click", () => {
  body.classList.toggle("dark-mode");
});

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

  function isMobileView() {
    return window.innerWidth < 1500;
  }

  menuBtn.addEventListener("click", function () {
    sidebar.classList.toggle("-translate-x-full");
    document.getElementById("closeSidebar").style.display = "block";
  });

  window.addEventListener("resize", function () {
    if (!isMobileView()) {
      sidebar.classList.remove("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    } else {
      sidebar.classList.add("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    }
  });

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
  function createNoteContainer(data, readId) {
    // check it note is read or not
    const ids = readId;
    // console.log(ids);
    const idArray = ids.split(",").map(Number);
    // console.log(data.id);

    let tick = "none";

    for (let i = 0; i < idArray.length; i++) {
      if (idArray[i] == data.id) {
        tick = "block";
        break;
      } else {
        tick = "none";
      }
    }

    // for data formot in notes
    let dateString = data.uploaded_time;
    let pastDate = new Date(dateString.replace(" ", "T"));
    let now = new Date();
    let diffInSeconds = Math.floor((now - pastDate) / 1000);

    let time;

    if (diffInSeconds < 0) {
      time = "Future date";
    } else {
      let timeUnits = [
        { unit: "year", seconds: 31536000 },
        { unit: "month", seconds: 2592000 },
        { unit: "week", seconds: 604800 },
        { unit: "day", seconds: 86400 },
        { unit: "hour", seconds: 3600 },
        { unit: "minute", seconds: 60 },
        { unit: "second", seconds: 1 },
      ];

      for (let { unit, seconds } of timeUnits) {
        let value = Math.floor(diffInSeconds / seconds);
        if (value >= 1) {
          time = `${value} ${unit}${value > 1 ? "s" : ""} ago`;
          break;
        }
      }
    }

    return `
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow mb-4 note_box">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm subject">${data.subject}</span>
                <!-- Added tick mark icon -->
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:${tick}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-gray-400 text-sm chapter">${data.chapter}</span>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-2 ch_name">${data.title}</h3>
        <p class="text-gray-600 mb-1">${data.description}</p>
        
        <!-- Added total views with the author information -->
        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-500 text-sm author">Uploaded by: ${data.uploaded_By} <Br>${time}</p>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>${data.view} views</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" topic_id="${data.topic_id}" note_id="${data.id}" link="${data.link}">
            <button class="viewBtn button-transition flex items-center justify-center space-x-2 bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>View</span>
            </button>

            <button class="summaryBtn button-transition flex items-center justify-center space-x-2 bg-purple-100 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Summary</span>
            </button>

            <button class="button-transition fleshBtn flex items-center justify-center space-x-2 bg-green-100 text-green-600 px-4 py-2 rounded-lg hover:bg-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Flashcards</span>
            </button>

            <!-- Improved download button with better colors -->

           <a href="${data.link}" download="${data.title}" class="button-transition flex items-center justify-center space-x-2 bg-blue-50 text-blue-700 dark:bg-blue-100 dark:text-blue-800 px-4 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-200">
            <button class="button-transition flex items-center justify-center  bg-blue-50 text-blue-700 dark:bg-blue-100 dark:text-blue-800  hover:bg-blue-100 dark:hover:bg-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download</span>
            </button>
            </a>
            
        </div>
    </div>
</div>

<!-- Summary Container -->
<div class="summary-container mt-4 bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Chapter Summary</h4>
        <p class="text-gray-600" id="summaryContent">
            Coming soon !!!
        </p>
    </div>
</div>
      `;
  }

  // Function to load notes into the notesSection div
  function loadNotes(data, readId) {
    const skeletonScreen = document.getElementById("skeletonScreen");
    const notesSection = document.getElementById("notesSection");

    // Show skeleton screen
    skeletonScreen.classList.remove("hidden");
    notesSection.classList.add("hidden");

    setTimeout(() => {
      notesSection.innerHTML = "";

      // Add new notes
      data.forEach((item) => {
        const noteElement = document.createElement("div");
        noteElement.innerHTML = createNoteContainer(item, readId);
        notesSection.appendChild(noteElement);

        // Add event listener to the view button
        const viewBtn = noteElement.querySelector(".viewBtn");
        viewBtn.addEventListener("click", function () {
          const NoteId = noteElement
            .querySelector("[note_id]")
            .getAttribute("note_id");
          const link = noteElement.querySelector("[link]").getAttribute("link");
          let topic = noteElement.querySelector(".ch_name").textContent;

          recentAdd(NoteId);
          // console.log(link)
          let pdfData = { note: NoteId, topic: topic, link: link };
          localStorage.setItem("pdfViewData", JSON.stringify(pdfData));

          

          // addToRecentlyViewed(item);
        });

        // Add event listener to the summary button

        const summaryBtn = noteElement.querySelector(".summaryBtn");
        const summaryContainer =
          noteElement.querySelector(".summary-container");

        summaryBtn.addEventListener("click", function () {
          // Toggle 'active' class on the summary container
          summaryContainer.classList.toggle("active");

          const topicId = noteElement
            .querySelector("[topic_id]")
            .getAttribute("topic_id");
          console.log("Topic ID:", topicId);
        });

        const fleshBtn = noteElement.querySelector(".fleshBtn");
        // const fleshContainer = noteElement.querySelector(".flesh-container");

        fleshBtn.addEventListener("click", function () {
          // Toggle 'active' class on the summary container
        
          // const topicId = noteElement
          //   .querySelector("[topic_id]")
          //   .getAttribute("topic_id");
          // console.log("Topic ID:", topicId);

          setTimeout(() => {
    
            window.open("fleshNotes/fleshNote.php", "_parent")
          }, 200);
        });
      });

      // Hide skeleton screen and show notes
      skeletonScreen.classList.add("hidden");
      notesSection.classList.remove("hidden");
    }, 1000); // Simulate a 1-second delay
  }

  // Add event listeners to subject buttons
  document.querySelectorAll(".subject-item button").forEach((button) => {
    button.addEventListener("click", function () {
      const subject = this.querySelector("span").textContent.trim();
      document.getElementById(
        "subjectName"
      ).parentElement.parentElement.parentElement.style.display = "block";
      document.getElementById("subjectName").textContent = subject;
      document.getElementById("subjectName2").textContent = subject;
      document.getElementById("notesSection").innerHTML = "";
      document.getElementById("syllabus").innerHTML = "";
      sidebar.classList.toggle("-translate-x-full");
      
      document.getElementById("progressRing").style.display = "grid";
      displayProgress(subject);
      progressTick(subject, "sub");
      fetchSyllabus(subject);
    });
  });

  // function for syllabus create
  function createSyllabus(data) {
    let dateString = data.uploaded_time;
    let pastDate = new Date(dateString.replace(" ", "T"));
    let now = new Date();
    let diffInSeconds = Math.floor((now - pastDate) / 1000);

    let time;

    if (diffInSeconds < 0) {
      time = "Future date";
    } else {
      let timeUnits = [
        { unit: "year", seconds: 31536000 },
        { unit: "month", seconds: 2592000 },
        { unit: "week", seconds: 604800 },
        { unit: "day", seconds: 86400 },
        { unit: "hour", seconds: 3600 },
        { unit: "minute", seconds: 60 },
        { unit: "second", seconds: 1 },
      ];

      for (let { unit, seconds } of timeUnits) {
        let value = Math.floor(diffInSeconds / seconds);
        if (value >= 1) {
          time = `${value} ${unit}${value > 1 ? "s" : ""} ago`;
          break;
        }
      }
    }

    return `
   <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden relative group border border-gray-200 dark:border-gray-800 dark:bg-gray-900">
        <!-- Decorative left border -->
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-blue-500 to-indigo-600"></div>
        
        <div class="p-5 relative">
          <!-- Top info row -->
          <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <div class="flex flex-wrap items-center gap-2">
              <span class="inline-flex px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">${data.chapter}</span>
              <span class="text-gray-700 dark:text-gray-300 text-sm font-medium sub">${data.subject}</span>
            </div>
            <div class="flex items-center text-gray-600 dark:text-gray-400 text-xs">
              <svg class="w-3.5 h-3.5 mr-1 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <span>${data.title}</span>
            </div>
          </div>
          
          <!-- Syllabus title with icon -->
          <div class="flex items-start mb-3">
            <div class="mr-3 flex-shrink-0 p-2 bg-blue-50 rounded-lg">
              <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div>
              <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-1 texxt" >${data.description}</h3>
              <div class="flex flex-wrap gap-y-1 gap-x-3 text-gray-600 dark:text-gray-400 text-xs">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>${time}</span>
                </div>
                <div class="flex items-center">
                  <svg class="w-3.5 h-3.5 mr-1 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span>${data.uploaded_By}</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Divider -->
          <div class="h-px bg-gray-100 dark:bg-gray-800 w-full my-3"></div>
          
          <!-- Download button -->
          <div class="flex justify-end">
            <a href="${data.link}" class="group">
              <button class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs transition-all duration-300 hover:bg-blue-700 shadow-sm hover:shadow-md">
                <svg class="w-3.5 h-3.5 mr-1.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download</span>
              </button>
            </a>
          </div>
        </div>
      </div> `;
  }

  // function to load syllabus
  function loadSyllabus(data) {
    let syll = document.getElementById("syllabus");

    syll.innerHTML = "";

    // Add new notes
    setTimeout(() => {
      data.forEach((item) => {
        const noteElement = document.createElement("div");
        noteElement.innerHTML = createSyllabus(item);
        syll.appendChild(noteElement);
      });
    }, 1000);
  }
  // function to fetch notes by subject
  function fetchNotes(subject, id) {
    fetch("js/fetch.php?subject=" + subject)
      .then((response) => response.json())
      .then((data) => {
        loadNotes(data, id);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }
  // function to fetch recent notes
  function fetchRecentNotes(id) {
    fetch("js/fetch_recent.php")
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("progressRing").style.display = "none";
        loadNotes(data, id);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // function to fetch syllabus by subject
  function fetchSyllabus(sub) {
    fetch("js/fetch_syllabus.php?subject=" + sub)
      .then((response) => response.json())
      .then((data) => {
        loadSyllabus(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // function to add note to recent
  function recentAdd(NoteId) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "js/add_recent.php",

      data: {
        id: NoteId,
      },

      success: function (response) {
         console.log(response);
        setTimeout(() => {
          window.open("pdfOpen/pdf.php", "_parent");
        }, 200);
        // console.log(response);
      },
    });
  }

  // function to update the progress of the subject by tick mark
  function progressTick(sub, cond) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "js/tick.php",

      data: {},

      success: function (response) {
        if (cond == "sub") {
          fetchNotes(sub, response);
        } else {
          fetchRecentNotes(response);
        }
      },
    });
  }

  // function to display progress
  function displayProgress(sub) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "js/display_progress.php",

      data: {
        sub: sub,
      },

      success: function (response) {
        if (response != "") {
          $("#progressValue").text(response);
        } else {
        }
      },
    });
  }

  // callback function to display syllabus & tick mark in notes
  progressTick("subject", "recent");
  fetchSyllabus("Mathematics");
});
