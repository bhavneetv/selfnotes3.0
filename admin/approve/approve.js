document.addEventListener("DOMContentLoaded", async function () {
  function createNoteContainer(data) {
    let dateString = data.uploaded_time;
    let dateObj = new Date(dateString.replace(/-/g, "/")); // Convert to valid Date format

    let day = dateObj.getDate();
    let month = dateObj.toLocaleString("en-US", { month: "short" }); // "Feb"
    let year = dateObj.getFullYear().toString().slice(-2); // "25"

    let formattedDate = `${day} ${month} ${year}`;

    let n = data.uploaded_By;
    // Split the name by spaces
    let words = n.trim().split(/\s+/);

    // Extract the first letter of each word and join them
    let initials = words.map((word) => word[0]).join("");

    let initial = initials.toUpperCase(); // Convert to uppercase if needed

    return `
     <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden note_box transition-all hover:shadow-xl">
    <!-- Header Section -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-medium">
                ${initial}
            </div>
            <div>
                <h3 class="font-medium text-gray-900 dark:text-gray-100">${data.uploaded_By}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Teacher</p>
            </div>
        </div>
        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
            Pending Review
        </span>
    </div>
    
    <!-- Content Section -->
    <div class="p-4">
        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">${data.title}</h4>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                ${data.description}
            </p>
            
            <!-- Info Grid - Responsive: 2 cols on mobile, 3 cols on larger screens -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Subject</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100 sub">${data.subject}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">File Type</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">PDF</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Grade Level</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">${data.course}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Note Type</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">${data.type}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Submitted On</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">${formattedDate}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Topic ID</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">${data.topic_id}</p>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons - Icon Only Buttons -->
        <div class="flex justify-end gap-2">
            <!-- Preview Button -->
            <a href="${data.link}" class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-colors duration-200 flex items-center justify-center tooltip-container" aria-label="Preview">
                <span class="tooltip absolute bottom-full mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none">Preview</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </a>
            
            <!-- Edit Button (New) -->
            <button class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white transition-colors duration-200 flex items-center justify-center edit" note_id="${data.id}" aria-label="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            
            <!-- Reject Button -->
            <button class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors duration-200 flex items-center justify-center del relative" note_id="${data.id}" note_link="${data.link}" aria-label="Reject">
                <!-- Default state: Cross icon -->
                <div class="loader-default flex items-center cc">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <!-- Loading state: Spinner -->
                <div class="loader-spinner absolute flex items-center justify-center opacity-0 pointer-events-none">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
            
            <!-- Approve Button -->
            <button class="p-2 rounded-full bg-green-500 hover:bg-green-600 text-white transition-colors duration-200 flex items-center justify-center approve" note_id="${data.id}" aria-label="Approve">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
        `;
  }

  // Function to load notes into the notesSection div
  function loadNotes(data) {
    // const skeletonScreen = document.getElementById("skeletonScreen");
    const notesSection = document.getElementById("notesApprovalGrid");

    // // Show skeleton screen
    // skeletonScreen.classList.remove("hidden");
    // notesSection.classList.add("hidden");

    notesSection.innerHTML = "";

    // Add new notes`
    data.forEach((item) => {
      const noteElement = document.createElement("div");
      noteElement.innerHTML = createNoteContainer(item);
      notesSection.appendChild(noteElement);
    });

    let approve = notesSection.querySelectorAll(".approve");
    approve.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("note_id");

        deletePhp(NoteId, "approve");
      });
    });
    let edit = notesSection.querySelectorAll(".edit");
    edit.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("note_id");

        const d = new Date();
        d.setTime(d.getTime() + 24 * 60 * 60 * 1000);
        let expires = "expires=" + d.toUTCString();
        document.cookie = "Edit_note" + "=" + NoteId + ";" + expires + ";path=/";
        window.location.href = "../../teacher/editNote/editNotes.php";

        // deletePhp(NoteId, "edit");
      });
    });

    let del = notesSection.querySelectorAll(".del");
    del.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("note_id");
        const link = btn.getAttribute("note_link");
        // console.log(NoteId);

        if (
          confirm(
            "Are you sure you want to delete this note? This action cannot be undone."
          )
        ) {
          btn.querySelector(".loader-spinner").classList.remove("opacity-0");
          btn.querySelector(".cc").innerHTML = "            ";
          deleteFile(link, NoteId);
          btn.disabled = true;
          // deletePhp(NoteId,"del")
        }
      });
    });
  }

  // console.log(totalView);
  // console.log(totalView);

  // function to fetch notes by subject
  function fetchNotes() {
    fetch("fetch.php")
      .then((response) => response.json())
      .then((data) => {
        // jsonData.push(data);
        //   console.log(data);
        loadNotes(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // callback function to display syllabus & tick mark in notes
  fetchNotes();

  function deletePhp(id, action) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "action.php",

      data: {
        id: id,
        action: action,
      },

      success: function (response) {
        console.log(response);
        if (response == "yes") {
          window.location.reload();
        } else {
          alert(response);
        }
      },
    });
  }

  const GITHUB_USERNAME = "selfnotess";
  const REPO_NAME = "selfnotes_pdf";
  const BRANCH = "main";
  const GITHUB_TOKEN = "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";

  // Function to generate a unique file link (modify logic if needed)

  // Function to extract the file path from the GitHub raw link
  function extractFilePath(url) {
    const parts = url.split(`/${BRANCH}/`);
    return parts.length > 1 ? parts[1] : null;
  }

  // Function to get the file's SHA (required for deletion)
  async function getFileSHA(filePath) {
    const url = `https://api.github.com/repos/${GITHUB_USERNAME}/${REPO_NAME}/contents/${filePath}?ref=${BRANCH}`;

    try {
      const response = await fetch(url, {
        headers: { Authorization: `token ${GITHUB_TOKEN}` },
      });

      if (!response.ok) throw new Error("File not found or error fetching SHA");

      const data = await response.json();
      return data.sha; // SHA required for deletion
    } catch (error) {
      console.error("Error fetching file SHA:", error);
      return null;
    }
  }

  async function deleteFile(k, id) {
    const fileLink = k;
    const filePath = extractFilePath(fileLink);

    if (!filePath) {
      alert("Invalid file link.");
      deletePhp(id, "del");
      return;
    }

    const sha = await getFileSHA(filePath);
    if (!sha) {
      alert("Error: File not found.");
      deletePhp(id, "del");
      return;
    }

    const url = `https://api.github.com/repos/${GITHUB_USERNAME}/${REPO_NAME}/contents/${filePath}`;

    try {
      const response = await fetch(url, {
        method: "DELETE",
        headers: {
          Authorization: `token ${GITHUB_TOKEN}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          message: `Deleting file ${filePath} via API`,
          sha: sha,
          branch: BRANCH,
        }),
      });

      if (!response.ok) throw new Error("Error deleting file");

      alert("File deleted successfully!");
      deletePhp(id, "del");
    } catch (error) {
      console.error("Error deleting file:", error);
      alert("Error deleting file.");
    }
  }
});

function handleSearch() {
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput.value.trim().toLowerCase(); // Get the search term

  // Get all note containers currently in the notesSection div
  const notes = document.querySelectorAll(".note_box");

  for (let i = 0; i < notes.length; i++) {
    const note = notes[i];
    const author = note.querySelector("h3").textContent.toLowerCase(); // Get the note title
    const title = note.querySelector("h4").textContent.toLowerCase(); // Get the note title
    const description = note
      .querySelector("p.text-gray-600")
      .textContent.toLowerCase(); // Get the note description
    //   const author = note.querySelector('.author').textContent.toLowerCase(); // Get the note author
    const subject = note.querySelector(".sub").textContent.toLowerCase(); // Get the note subject

    // Check if the title or description includes the search term
    if (
      title.includes(searchTerm) ||
      description.includes(searchTerm) ||
      author.includes(searchTerm) ||
      subject.includes(searchTerm)
    ) {
      note.style.display = "block"; // Show the note if it matches the search term
      note.classList.add("animate-fade-in");
    } else {
      note.style.display = "none"; // Hide the note if it doesn't match
    }
  }
}
const style = document.createElement("style");
style.innerHTML = `
      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-in {
          animation: fadeIn 0.3s ease-in-out;
      }
  `;
document.head.appendChild(style);
// Add event listener to the search input
document.getElementById("searchInput").addEventListener("input", handleSearch);
