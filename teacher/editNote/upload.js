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


// Dynamic Label and Placeholder Update when load
noteTypeSelect.addEventListener("DOMContentLoaded", (e) => {
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
      
      mainTopics,
      otherCourse,
      otherSubject
    );

   
  });


function uploadInfo(
  noteType,
  subject,
  chapter,
  course,
  title,
  description,
  
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
      subOther: otherSubject,
      courseOther: otherCourse,
    },

    success: function (response) {
      console.log(response);

      let spinner = document.getElementById("spinner");
      let btnText = document.getElementById("btnText");
      let uploadBtn = document.getElementById("uploadBtn");
      alert("Note edited successfully");
      // window.location.reload();
      spinner.classList.add("hidden");
      btnText.classList.remove("hidden");
      uploadBtn.disabled = false;
      setTimeout(() => {
        window.history.back();
      },200);
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
