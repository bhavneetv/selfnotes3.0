let inp = document.getElementById("input");
let create_btn = document.getElementById("create");

create_btn.onclick = (e) => {
  e.preventDefault();
  // alert(inp)
  // for_join()
  var k = btoa(inp.value);
  let loader = document.querySelector(".c");
  loader.classList.remove("hidden");
  create_btn.disabled = true;
  // console.log(loader)
  // document.getElementById('loader').style.display='flex'
  for_create(k);
  for_join(k, "Create");

  // alert(k)
};

let join_btn = document.getElementById("join");

join_btn.onclick = (e) => {
  e.preventDefault();
  // var k = inp.value
  var k = btoa(inp.value);

  var a = "joined";
  for_join(k, a);

  let loader = document.querySelector(".j");
  loader.classList.remove("hidden");

  join_btn.disabled = true;
  create_btn.disabled = true;

  // alert(k)
  setTimeout(() => {
    // document.getElementById('loader').style.display='none'
    window.location.href = window.location = "talk2.php?room_name=" + k;
    let loader = document.querySelector(".j");
    loader.classList.add("hidden");

    join_btn.disabled = false;
    create_btn.disabled = false;
  }, 1500);
};
var pu = document.getElementById("pu");

pu.onclick = (e) => {
  e.preventDefault();

  var a = "joined";
  for_join("cHVibGlj", a);
  // document.getElementById('loader').style.display='flex'
  let loader = document.querySelector(".p");
  loader.classList.remove("hidden");
  pu.disabled = true;
  join_btn.disabled = true;
  create_btn.disabled = true;

  // alert(k)
  setTimeout(() => {
    // document.getElementById('loader').style.display='none'
    window.location.href = window.location = "talk2.php?room_name=cHVibGlj";
    let loader = document.querySelector(".p");
    loader.classList.add("hidden");

    join_btn.disabled = false;
    create_btn.disabled = false;
    // window.location.href = window.location = 'talk2.php?room_name='+k;
  }, 1500);
};

function for_join(k, type) {
  var m = type;

  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      input: k,
      types: m,
    },
    url: "php/join.php",
    success: function (response) {
      // console.log(response)
    },
  });
}

function for_del(k, type) {
  var m = type;

  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      input: k,
      do: m,
    },
    url: "php/del.php",
    success: function (response) {
      // console.log(response)
    },
  });
}

function for_create(k) {
  // var k =  btoa($('#inputc').val())

  //   alert(k)
  $.ajax({
    type: "POST",
    data: {
      inp: k,
    },
    url: "php/create.php",
    success: function (response) {
      if (response == "yes") {
        setTimeout(() => {
          window.location.href = window.location =
            "talk2.php?room_name=" + k;
          let loader = document.querySelector(".c");
          loader.classList.add("hidden");

          join_btn.disabled = false;
          create_btn.disabled = false;
        }, 1500);
      } else {
        alert(response);
        let loader = document.querySelector(".c");
        loader.classList.add("hidden");
        create_btn.disabled = false;

        return false;
      }
    },
  });
}

document.addEventListener("DOMContentLoaded", async function () {
  let totalView = 0;

  // Function to create a note container
  //   console.log(totalView)
  function createNoteContainer(data) {
    console.log(data.room_name);
    let n = data.room_name;
    let name = atob(n);
    //  console.log(name);

    totalView += 1;
    document.getElementById("roomCount").textContent =
      totalView + " Active Rooms";

    let dateString = data.cdate;
    let dateObj = new Date(dateString.replace(/-/g, "/")); // Convert to valid Date format

    let day = dateObj.getDate();
    let month = dateObj.toLocaleString("en-US", { month: "short" }); // "Feb"
    let year = dateObj.getFullYear().toString().slice(-2); // "25"

    let formattedDate = `${day} ${month} ${year}`;

    let words = name.trim().split(/\s+/);

    // Extract the first letter of each word and join them
    let initials = words.map((word) => word[0]).join("");

    let nn = initials.toUpperCase();
    // Output: "26 Feb 25"

    // console.log(b);
    // console.log(dateInput);
    // console.log(n);
    // console.log(totalView);

    return `
           <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg transition-colors duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center">
                                    <span class="text-white font-bold">${nn}</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">${name}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400"> Created ${formattedDate}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900 rounded-lg transition-colors view" room_name="${data.room_name}">
                                   <svg width="24px" class="w-5 h-5" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#4181f5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="4" fill="#4181f5"></circle> <path d="M21 12C21 12 20 4 12 4C4 4 3 12 3 12" stroke="#4181f5" stroke-width="2"></path> </g></svg>
                                </button>
                                <button class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 rounded-lg transition-colors del" noteId="${data.room_name}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
        `;
  }

  // Function to load notes into the notesSection div
  function loadNotes(data) {
    // const skeletonScreen = document.getElementById("skeletonScreen");
    const notesSection = document.getElementById("roomDiv");

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

        if (
          confirm(
            "Are you sure you want to delete this note? This action cannot be undone."
          )
        ) {
          for_del(NoteId, "del");
        }
      });
    });

    let viewBtn = notesSection.querySelectorAll(".view");
    viewBtn.forEach((btn) => {
      btn.addEventListener("click", function () {
        const room_name = btn.getAttribute("room_name");

        //  console.log(room_name);

        for_join(room_name, "joined");
        setTimeout(() => {
          // document.getElementById('loader').style.display='none'
          window.location.href = window.location =
            "talk2.php?room_name=" + room_name;
          // window.location.href = window.location = 'talk2.php?room_name='+k;
        }, 100);
      });
    });
  }

  // console.log(totalView);
  // console.log(totalView);

  // function to fetch notes by subject
  function fetchRooms() {
    fetch("php/fetchRoom.php")
      .then((response) => response.json())
      .then((data) => {
        // jsonData.push(data);
        // console.log(data);
        loadNotes(data);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }
  fetchRooms();
});
