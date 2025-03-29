// this code is for main page

function showModal(modalId) {
  document.getElementById(modalId).style.display = "flex";
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

// Add click listeners to your edit and lock buttons

const editButtons = document.querySelectorAll(".fa-pen");

//* main process the fetch the selected notes

const note_btn = document.getElementsByClassName("next");

for (let i = 0; i < note_btn.length; i++) {
  note_btn[i].addEventListener("click", function () {
    let note_id = this.getAttribute("note");
    let note_n =
      this.parentElement.previousElementSibling.previousElementSibling;
    let note_name = note_n
      .getElementsByTagName("h3")[0]
      .innerHTML.toUpperCase();

    document.getElementById("note_i").value = note_name;

    getNote(note_id);
    document.getElementById("noteMenu").style.display = "none";
    document.getElementById("textarea").style.display = "block";

    let content = document.getElementById("editor").innerHTML;
    content = "";

    document.getElementById("saveBtn").addEventListener("click", function () {
      let content = document.getElementById("editor").innerHTML;
      //   console.log(content);
      saveNote(content, note_id);
    });

    document.getElementById("deleteBtn").addEventListener("click", function () {
      document.getElementById("editor").innerHTML = "";
      //   console.log(content);
      deleteNote(note_id);
    });

    // auto save
    let autoSaveTimeout;
    document.getElementById("editor").addEventListener("input", () => {
      clearTimeout(autoSaveTimeout);
      content = document.getElementById("editor").innerHTML;
      autoSaveTimeout = setTimeout(() => {
        saveNote(content, note_id);
      }, 40000); // Auto-save after 40 seconds of inactivity
    });
  });
}

function getNote(note_id) {
  $.ajax({
    type: "POST",
    // Our sample url to make request
    url: "fetch.php",

    data: {
      id: note_id,
    },

    success: function (response) {
      // display(response);

      $("#editor").html(response);
    },
  });
}

// this is for text area

function formatText(command, value) {
  if (command === "fontSize") {
    value = document.getElementById("fontSize").value;
  } else if (command === "fontName") {
    value = document.getElementById("fontFamily").value;
  } else if (command === "foreColor") {
    value = event.target.value;
  }
  document.execCommand(command, false, value);
  document.getElementById("editor").focus();
}

// Note Actions with animations
function showNotification(message, type = "success") {
  const notification = document.createElement("div");
  notification.className = `fixed bottom-20 right-20 ${
    type === "success" ? "bg-green-500" : "bg-red-500"
  } text-white px-6 py-3 rounded-xl shadow-lg transform transition-all duration-300 translate-y-full`;
  notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas ${
              type === "success" ? "fa-check-circle" : "fa-exclamation-circle"
            }"></i>
            <span>${message}</span>
        </div>
    `;
  document.body.appendChild(notification);

  // Animate in
  setTimeout(() => (notification.style.transform = "translateY(0)"), 10);

  // Animate out
  setTimeout(() => {
    notification.style.transform = "translateY(full)";
    notification.style.opacity = "0";
    setTimeout(() => notification.remove(), 300);
  }, 2000);
}

function saveNote(content, id) {
  saveNotephp(content, id);
}

function deleteNote(id) {
  if (
    confirm(
      "Are you sure you want to delete this note? This action cannot be undone."
    )
  ) {
    deleteNotephp(id);
    // showNotification("Note deleted!", "error");
  }
}

function clearNote() {
  if (confirm("Clear all content? This action cannot be undone.")) {
    document.getElementById("editor").innerHTML = "";
    showNotification("Content cleared!", "error");
  }
}

function downloadNote() {
  const title = document.querySelector("input").value || "Untitled Note";
  const content = document.getElementById("editor").innerHTML;
  const blob = new Blob([content], { type: "text/html" });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement("a");

  a.href = url;
  a.download = `${title}.html`;
  document.body.appendChild(a);
  a.click();
  window.URL.revokeObjectURL(url);
  document.body.removeChild(a);
  showNotification("Note exported successfully!");
}

function goBack() {
  if (
    confirm(
      "Are you sure you want to go back? Any unsaved changes will be lost."
    )
  ) {
    document.getElementById("noteMenu").style.display = "block";
    document.getElementById("textarea").style.display = "none";
  }
}

// Auto-save functionality

// Prevent accidental navigation
window.addEventListener("beforeunload", (e) => {
  const editor = document.getElementById("editor");
  if (editor.innerHTML.length > 0) {
    e.preventDefault();
    e.returnValue = "";
  }
});

// Keyboard shortcuts
document.addEventListener("keydown", (e) => {
  if (e.ctrlKey || e.metaKey) {
    switch (e.key.toLowerCase()) {
      case "s":
        e.preventDefault();
        saveNote();
        break;
      case "b":
        e.preventDefault();
        formatText("bold");
        break;
      case "i":
        e.preventDefault();
        formatText("italic");
        break;
      case "u":
        e.preventDefault();
        formatText("underline");
        break;
    }
  }
});

// Handle drag and drop of files
const editor = document.getElementById("editor");

editor.addEventListener("dragover", (e) => {
  e.preventDefault();
  editor.classList.add("border-blue-500");
});

editor.addEventListener("dragleave", () => {
  editor.classList.remove("border-blue-500");
});

editor.addEventListener("drop", (e) => {
  e.preventDefault();
  editor.classList.remove("border-blue-500");

  const files = e.dataTransfer.files;
  if (files.length > 0) {
    const reader = new FileReader();
    reader.onload = (e) => {
      editor.innerHTML += e.target.result;
      showNotification("Content imported successfully!");
    };
    reader.readAsText(files[0]);
  }
});

// Initialize editor with placeholder text
if (editor.innerHTML === "") {
  editor.innerHTML =
    '<p class="text-gray-400 dark:text-gray-500">Start typing your note here...</p>';
  editor.addEventListener("focus", function clearPlaceholder() {
    if (
      editor.innerHTML ===
      '<p class="text-gray-400 dark:text-gray-500">Start typing your note here...</p>'
    ) {
      editor.innerHTML = "";
    }
    editor.removeEventListener("focus", clearPlaceholder);
  });
}

function saveNotephp(cho, note_id) {
  $.ajax({
    type: "POST",
    // Our sample url to make request
    url: "savenote.php",
    data: {
      c: cho,
      id: note_id,
    },
    success: function (response) {
        console.log(response);

      if (response === "yes") {
        showNotification("Note saved successfully!");
      } else {
        showNotification("Error saving note!", "error");
      }
    },
  });
}

// code to edit the name of notes and save it to the database
let edit = document.getElementsByClassName("fa-pen");
let inputc = document.getElementById("ei");
for (let i = 0; i < edit.length; i++) {
  edit[i].addEventListener("click", function () {
    let noteWant = this.getAttribute("note_n");

    document.getElementById("editNameModal").style.display = "flex";
    // console.log(inputc);

    document
      .getElementById("saveChangesBtn")
      .addEventListener("click", function () {
        console.log(inputc.value);
        editName(noteWant, inputc.value);
      });
  });
}

// function to edit the name of notes and save it to the database
function editName(id, input) {
  $.ajax({
    type: "POST",
    // Our sample url to make request
    url: "edit_name.php",

    data: {
      id: id,
      name: input,
    },

    success: function (response) {
      // console.log(response);

      if (response == "yes") {
        window.location.reload();
      }
    },
  });
}

// function to delete the name of notes and save it to the database
function deleteNotephp(id) {
  $.ajax({
    type: "POST",
    // Our sample url to make request
    url: "delete_note.php",

    data: {
      id: id,
    },

    success: function (response) {
      if (response == "yes") {
        showNotification("Note deleted successfully!", "success");
      }
    },
  });
}
