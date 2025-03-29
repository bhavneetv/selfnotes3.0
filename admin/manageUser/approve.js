document.addEventListener("DOMContentLoaded", async function () {
  function createNoteContainer(data) {
    let dateString = data.date_create;
    let dateObj = new Date(dateString.replace(/-/g, "/")); // Convert to valid Date format

    let day = dateObj.getDate();
    let month = dateObj.toLocaleString("en-US", { month: "short" }); // "Feb"
    let year = dateObj.getFullYear().toString().slice(-2); // "25"

    let formattedDate = `${day} ${month} ${year}`;

    let n = data.name;
    // Split the name by spaces
    let words = n.trim().split(/\s+/);

    // Extract the first letter of each word and join them
    let initials = words.map((word) => word[0]).join("");

    let initial = initials.toUpperCase(); // Convert to uppercase if needed


    return `


<div class="user-card bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden note_box">
    <div class="flex items-start p-6">
        <div class="h-12 w-12 flex-shrink-0">
            <div class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-lg">
                ${initial}
            </div>
        </div>
        <div class="ml-4 flex-grow">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900  user-name">${data.name}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 user-email">${data.email}</p>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    Active
                </span>
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <p class="roless">${data.role} • Joined ${formattedDate}</p>
                <p class="mt-1 subss">Course: ${data.class} • Subject: ${data.subject}</p>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-200 px-6 py-3 bg-gray-50  flex justify-end">
        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 del " id="${data.id}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </div>
</div>
        `;
  }

  // Function to load accounts
  function loadNotes(data) {

    const notesSection = document.getElementById("user-grid");


    notesSection.innerHTML = "";
    data.forEach((item) => {
      const noteElement = document.createElement("div");
      noteElement.innerHTML = createNoteContainer(item);
      notesSection.appendChild(noteElement);
    });

 // for delete 
    let del = notesSection.querySelectorAll(".del");
    del.forEach((btn) => {
      btn.addEventListener("click", function () {
        const NoteId = btn.getAttribute("id");
        console.log(NoteId);

        if(confirm("Are you sure you want to delete this note? This action cannot be undone.")){
          deletePhp(NoteId)
        }
      });
    });
  }


  // function to fetch accounts
  function fetchNotes() {
    fetch("fetch.php")
      .then((response) => response.json())
      .then((data) => {
        // jsonData.push(data);
          // console.log(data);
        loadNotes(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // callback function 
  fetchNotes();

  // function to delete accounts doing request
  function deletePhp(id) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "action.php",

      data: {
        id: id,
        
      },

      success: function (response) {
        console.log(response);
         if(response == "yes"){
              window.location.reload();
         }
         else{
          alert(response)
         }
      },
    });
  }
});

// for search feature

function handleSearch() {
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput.value.trim().toLowerCase(); // Get the search term

  // Get all note containers currently in the notesSection div
  const notes = document.querySelectorAll(".note_box");

  for (let i = 0; i < notes.length; i++) {
    const note = notes[i];
    const author = note.querySelector("h3").textContent.toLowerCase(); // Get the note title
    const title = note.querySelector(".user-email").textContent.toLowerCase(); // Get the note title
    const description = note
      .querySelector(".roless")
      .textContent.toLowerCase(); // Get the note description
    //   const author = note.querySelector('.author').textContent.toLowerCase(); // Get the note author
    const subject = note.querySelector(".subss").textContent.toLowerCase(); // Get the note subject

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
