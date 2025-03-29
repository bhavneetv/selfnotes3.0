document.addEventListener("DOMContentLoaded", async function () {
  let totalView = 0;

  // Function to create a note container
  //   console.log(totalView)
  function createNoteContainer(data) {
    let newView = parseInt(data.view);

    totalView += newView;
    document.getElementById("totalView").textContent = totalView;

    let dateString = data.uploaded_time;
    let dateObj = new Date(dateString.replace(/-/g, "/")); // Convert to valid Date format

    let day = dateObj.getDate();
    let month = dateObj.toLocaleString("en-US", { month: "short" }); // "Feb"
    let year = dateObj.getFullYear().toString().slice(-2); // "25"

    let formattedDate = `${day} ${month} ${year}`;
    // Output: "26 Feb 25"

    let a;
    if (data.approve == 0) {
      a = "Waiting for Approval";
    } else {
      a = "Approved";
    }

    // console.log(b);
    // console.log(dateInput);
    // console.log(n);
    // console.log(totalView);

    return `
           <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group border border-gray-100 dark:border-gray-700">
    <!-- Colored Top Accent -->
    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    
    <!-- Card Header -->
    <div class="p-5 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <div class="bg-indigo-50 dark:bg-indigo-900/30 p-2.5 rounded-xl group-hover:bg-indigo-100 dark:group-hover:bg-indigo-800/40 transition-colors">
          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-800  text-sm sm:text-base truncate max-w-[120px] sm:max-w-[160px]">${data.title}</h3>
      </div>
      <span class="px-3 py-1.5 text-xs font-medium rounded-full bg-indigo-100 text-black  ">${data.subject}</span>
    </div>
      
    <!-- Card Content -->
    <div class="px-5 pb-5">
      <!-- Divider -->
      <div class="border-t border-gray-100 dark:border-gray-700 -mx-5 mb-4"></div>
      
      <!-- Metadata Row -->
      <div class="flex justify-between text-xs mb-3">
        <span class="text-gray-500  font-medium">${data.type}</span>
        <span class="text-gray-500">${formattedDate}</span>
      </div>
        
      <!-- Views Row -->
      <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-2 bg-gray-50 dark:bg-gray-200 px-3 py-1.5 rounded-lg">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
          <span class="text-xs text-gray-600  font-medium">${data.view} views</span>
        </div>
        <span class="px-3 py-1.5 text-xs font-medium text-black  bg-gray-100  rounded-lg">${a}</span>
      </div>
        
      <!-- Actions Row -->
      <div class="flex justify-end space-x-2 mt-2">
        <button class="p-2 rounded-xl transition-all hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:scale-105 group/btn edit"  title="edit"  noteId="${data.id}">
        <svg width="24px" height="24px" class="w-5 h-5 text-gray-400 group-hover/btn:text-blue-500 dark:text-gray-500 dark:group-hover/btn:text-blue-400 transition-colors" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </button>
        <button class="p-2 rounded-xl transition-all hover:bg-red-50 dark:hover:bg-red-900/20 hover:scale-105 group/btn del"  title="Delete" noteLink="${data.link}" noteId="${data.id}">
          <svg class="w-5 h-5 text-gray-400 group-hover/btn:text-red-500 dark:text-gray-500 dark:group-hover/btn:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
        </button>
        <a href="${data.link}" class="inline-block" title="Download" noteId="${data.id}">
          <button class="p-2 rounded-xl transition-all hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:scale-105 group/btn" title="Download">
            <svg class="w-5 h-5 text-gray-400 group-hover/btn:text-emerald-500 dark:text-gray-500 dark:group-hover/btn:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
          </button>
        </a>
      </div>
    </div>
  </div>
      `;
  }

  // Function to load notes into the notesSection div
  function loadNotes(data) {
    // const skeletonScreen = document.getElementById("skeletonScreen");
    const notesSection = document.getElementById("notesList");

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

    let delBtn = notesSection.querySelectorAll(".del");
    delBtn.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("noteId");
        const NoteLink = btn.getAttribute("noteLink");
        // console.log(NoteId);

        if (
          confirm(
            "Are you sure you want to delete this note? This action cannot be undone."
          )
        ) {
          // console.log(NoteLink)
          deleteFile(NoteLink, NoteId);
          btn.disabled = true;
          //deleteNotephp(NoteId);
        }
      });
    });

    let editBtn = notesSection.querySelectorAll(".edit");
    editBtn.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("noteId");
        // console.log(NoteId);

        const d = new Date();
        d.setTime(d.getTime() + 24 * 60 * 60 * 1000);
        let expires = "expires=" + d.toUTCString();
        document.cookie = "Edit_note" + "=" + NoteId + ";" + expires + ";path=/";
        window.location.href = "../editNote/editNotes.php";
      });
    });
  }

  // console.log(totalView);
  // console.log(totalView);

  // function to fetch notes by subject
  function fetchNotes() {
    fetch("fetchNote.php")
      .then((response) => response.json())
      .then((data) => {
        // jsonData.push(data);
        // console.log(data);
        loadNotes(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // callback function to display syllabus & tick mark in notes
  fetchNotes();

  function deleteNotephp(sub) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "delete.php",

      data: {
        sub: sub,
      },

      success: function (response) {
        if (response == "yes") {
          window.location.reload();
        } else {
          alert(response);
        }
      },
    });
  }



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
      return;
    }

    const sha = await getFileSHA(filePath);
    if (!sha) {
      alert("Error: File not found.");
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
      deleteNotephp(id);
    } catch (error) {
      console.error("Error deleting file:", error);
      alert("Error deleting file.");
    }
  }
});
