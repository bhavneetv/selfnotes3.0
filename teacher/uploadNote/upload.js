const fileUpload = document.getElementById("file-upload");
const dropArea = document.querySelector('label[for="file-upload"]');
const fileFeedback = document.getElementById("file-feedback");
const uploadForm = document.getElementById("upload-form");
const uploadedLink = document.getElementById("uploaded-link");
const fileLink = document.getElementById("file-link");
const noteTypeSelect = document.getElementById("note-type");
const othercourseContainer = document.getElementById("other-course-container");

const subjectSelect = document.getElementById("subject");
const otherSubjectContainer = document.getElementById(
  "other-subject-container"
);
const descriptionContainer = document.getElementById("description-container");
const mainTopicsContainer = document.getElementById("main-topics-container");
const chapterNumberContainer = document.getElementById(
  "chapter-number-container"
);

let othercourse = document.getElementById("course");
let courseCont = document.getElementById("other-course-container");

let uploadedFile = null;

// Handle file selection
fileUpload.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (
    file &&
    file.type === "application/pdf" &&
    file.size <= 10 * 1024 * 1024
  ) {
    uploadedFile = file;
    fileFeedback.classList.remove("hidden");
  } else {
    alert("Please upload a valid PDF file under 10MB.");
  }
});

// Dynamic Label and Placeholder Update
noteTypeSelect.addEventListener("change", (e) => {
  const selectedValue = e.target.value;

  if (selectedValue === "imp") {
    // to change the text of ch numer to year
    document.getElementById("chapter-number-label").textContent = "Year";
    document.getElementById("chapter-number").placeholder = "Enter year";

    // to change th title to board/university
    document.getElementById("title-label").textContent =
      "PYQS/Sessional/Assigment";
    document.getElementById("title").placeholder = "Enter Type";

    //to change description to name
    document.getElementById("description-label").textContent = "Chapter";
    document.getElementById("description").placeholder = "Enter Chapter";

    // to hide main topic
    mainTopicsContainer.style.display = "none";
  } else if (selectedValue === "syb") {
    // to change the text of ch numer to year
    document.getElementById("chapter-number-label").textContent = "Year";
    document.getElementById("chapter-number").placeholder = "Enter year";

    // to change th title to board/university
    document.getElementById("title-label").textContent = "Board/University";
    document.getElementById("title").placeholder = "Enter board/university";

    //to change description to name
    document.getElementById("description-label").textContent = "Name";
    document.getElementById("description").placeholder = "Enter name";

    // to hide main topic
    mainTopicsContainer.style.display = "none";
  } else {
    document.getElementById("chapter-number-label").textContent =
      "Chapter Number";
    document.getElementById("chapter-number").placeholder =
      "Enter chapter number";

    // to change th title to board/university
    document.getElementById("title-label").textContent = "Chapter Name";
    document.getElementById("title").placeholder = "Enter chapter name";

    //to change description to name
    document.getElementById("description-label").textContent = "Description";
    document.getElementById("description").placeholder = "Enter description";

    // to hide main topic
    mainTopicsContainer.style.display = "block";
  }
});

// Show/Hide Other Subject Input
subjectSelect.addEventListener("change", (e) => {
  if (e.target.value === "other") {
    otherSubjectContainer.classList.remove("hidden");
  } else {
    otherSubjectContainer.classList.add("hidden");
  }
});

othercourse.addEventListener("change", (e) => {
  if (e.target.value === "other") {
    courseCont.classList.remove("hidden");
  } else {
    courseCont.classList.add("hidden");
  }
});

//*                                                                         main Coding starts here note uploading
// Handle form submission

document
  .getElementById("upload-form")
  .addEventListener("submit", async function (event) {
    let spinner = document.getElementById("spinner");
    let btnText = document.getElementById("btnText");
    let uploadBtn = document.getElementById("uploadBtn");

    spinner.classList.remove("hidden");
    btnText.classList.add("hidden");
    uploadBtn.disabled = true;

    event.preventDefault();

    let fileInput = document.getElementById("file-upload");
    let file = fileInput.files[0];

    if (!file) {
      alert("Please select a PDF file.");
      return;
    }
    let coursecc = document.getElementById("course").value;
    let subjectcc = document.getElementById("subject").value;
    if (coursecc == "" || subjectcc == "") {
      alert("Please select a course and subject.");
      spinner.classList.add("hidden");
      btnText.classList.remove("hidden");
      uploadBtn.disabled = false;
      return;
    }

    let reader = new FileReader();
    reader.onload = async function () {
      let content = btoa(reader.result); // Convert file to Base64

      let fileName = file.name.replace(/\s+/g, "_"); // Remove spaces
    

      let apiUrl = `https://api.github.com/repos/${githubUsername}/${repoName}/contents/${fileName}`;

      // Check if the file already exists
      let fileExists = await fetch(apiUrl, {
        method: "GET",
        headers: {
          Authorization: `token ${githubToken}`,
          "Content-Type": "application/json",
        },
      });

      let newFileName = fileName;
      let counter = 1;

      // If file exists, generate a new unique name
      while (fileExists.ok) {
        let fileExtension = newFileName.substring(newFileName.lastIndexOf(".")); // Get file extension
        let fileBaseName =
          newFileName.substring(0, newFileName.lastIndexOf(".")) || newFileName; // Get name without extension

        newFileName = `${fileBaseName}(${counter})${fileExtension}`;
        apiUrl = `https://api.github.com/repos/${githubUsername}/${repoName}/contents/${newFileName}`;

        fileExists = await fetch(apiUrl, {
          method: "GET",
          headers: {
            Authorization: `token ${githubToken}`,
            "Content-Type": "application/json",
          },
        });

        counter++;
      }

      // Upload the file with new name
      let response = await fetch(apiUrl, {
        method: "PUT",
        headers: {
          Authorization: `token ${githubToken}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          message: `Uploaded ${newFileName}`,
          content: content,
        }),
      });

      if (response.ok) {
        let rawLink = `https://raw.githubusercontent.com/${githubUsername}/${repoName}/${branchName}/${newFileName}`;
        // document.getElementById("status").innerText =
        //   "PDF uploaded successfully!";
        // document.getElementById("pdfLink").innerText = rawLink;
        // document.getElementById("pdfLink").href = rawLink;

        let noteType = document.getElementById("note-type").value;
        let course = document.getElementById("course").value;
        let subject = document.getElementById("subject").value;
        let chapter = document.getElementById("chapter-number").value;
        let title = document.getElementById("title").value;
        let description = document.getElementById("description").value;
        let mainTopics = document.getElementById("main-topics").value;
        // let chapterNumber = document.getElementById("chapter-number").value;
        let otherSubject = document.getElementById("other-subject").value;
        let otherCourse = document.getElementById("other-course").value;
        uploadInfo(
          noteType,
          subject,
          chapter,
          course,
          title,
          description,
          rawLink,
          mainTopics,
          otherCourse,
          otherSubject
        );
        uploadedLink.classList.remove("hidden");
      } else {
        document.getElementById("status").innerText = "Error uploading PDF.";
      }
    };

    reader.readAsBinaryString(file);
  });

// let noteType = document.getElementById("note-type").value;
// let course = document.getElementById("course").value;
// let subject = document.getElementById("subject").value;
// let chapter = document.getElementById("chapter-number").value;
// let title = document.getElementById("title").value;
// let description = document.getElementById("description").value;
// let mainTopics = document.getElementById("main-topics").value;
// // let chapterNumber = document.getElementById("chapter-number").value;
// let otherSubject = document.getElementById("other-subject").value;
// let otherCourse = document.getElementById("other-course").value;
// uploadInfo(noteType,subject,chapter,course,title,description,rawFileUrl,mainTopics,otherCourse,otherSubject)
// uploadedLink.classList.remove("hidden");

function uploadInfo(
  noteType,
  subject,
  chapter,
  course,
  title,
  description,
  rawFileUrl,
  mainTopics,
  otherCourse,
  otherSubject
) {
  $.ajax({
    type: "POST",
    // Our sample url to make request
    url: "uploadData.php",

    data: {
      title: title,
      description: description,
      chapterNumber: chapter,
      subject: subject,
      course: course,
      type: noteType,
      mainTopics: mainTopics,
      link: rawFileUrl,
      subOther: otherSubject,
      courseOther: otherCourse,
    },

    success: function (response) {
      console.log(response);

      let spinner = document.getElementById("spinner");
      let btnText = document.getElementById("btnText");
      let uploadBtn = document.getElementById("uploadBtn");
      alert("Note uploaded successfully");
      window.location.reload();
      spinner.classList.add("hidden");
      btnText.classList.remove("hidden");
      uploadBtn.disabled = false;
    },
  });
}

// dynamically change the subject acc to course
$(document).ready(function() {
  $("#course").change(function() {

    // alert("Course changed");
    // $("#subject").prop("disabled", false);
      var selectedCourse = $(this).val();

      $.ajax({
          type: "POST",
          url: "select.php", // PHP script that handles the request
          data: { course: selectedCourse },
          dataType: "json",
          success: function(response) {
            // console.log(response);
              $("#subject").empty().append('<option value="" selected disabled>Select Subject</option>');
              $.each(response, function(index, value) {
                $("#subject").append('<option value="' + value + '" style="text-transform: capitalize">' + value + '</option>');
              });
              $("#subject").append('<option value="other">Other</option>');
          }
      });
  });
});

