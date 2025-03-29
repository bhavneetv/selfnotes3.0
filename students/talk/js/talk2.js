var pathArray = window.location.href.split("room_name=");
var btn_boxx = document.getElementById("box");
var back = document.getElementById("backc");
var send = document.getElementById("send");

var first = document.getElementsByClassName("chats-main");
// var fc = document.getElementById("vc");



document.getElementById("cl").onclick = () => {
  document.getElementById("ii").value = "";
}
back.onclick = () => {
  for_leave("leave");
  // document.getElementById("loader").style.display = "flex";
  back.disabled = true;

  setTimeout(() => {
    // document.getElementById("loader").style.display = "none";

    history.back();
  }, 1500);
};

function desButton() {
  var all_btn = btn_boxx.getElementsByTagName("BUTTON");

  var att = btn_boxx.getAttribute("owner");
  if (att == "no") {
    for (var n = 0; n <= all_btn.length - 1; n++) {
      // alert(all_btn[n].innerHTML)
      all_btn[n].setAttribute("disabled", "disabled");
      all_btn[n].style.opacity = "60%";
    }
  }
}

desButton();

function get_note_name() {
  var name = atob(pathArray[1]);
  document.getElementById("room_n").innerHTML = name;
}
get_note_name();

var sh = document.getElementById("sh");

sh.onclick = function () {
  var bv = window.location.href;

  window.open(
    "whatsapp://send?text=" +
      bv +
      " \n \n \n \n Hi,These is my room code use this code to join my room"
  );
};

send.onclick = () => {
  var name = pathArray[1];
  console.log(name);

  forSendMsg(name);
  // var s = document.getElementsByClassName("ab")[0].offsetHeight;
  // document.getElementsByClassName("ab")[0].scrollTop = s;
};

function forSendMsg(room_name) {
  var k = $("#ii").val();

  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      input: k,
      room: room_name,
    },
    url: "php/send.php",
    success: function (response) {
      if (response == "no") {
        alert("Enter more than 5 words ");
      }
      console.log(response)
      $("#ii").val("");
    },
  });
}

function xyz() {
  var name = pathArray[1];
  forFatch(name);
}

setInterval(xyz, 1000);

xyz()

// for fatch

function forFatch(room_name) {
  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      room: room_name,
    },
    url: "php/fatch.php",
    success: function (response) {
      // console.log(response)

      document.getElementsByClassName("ab")[0].innerHTML = response;
    },
  });
}

function for_leave(type) {
  var name = pathArray[1];

  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      input: name,
      types: type,
    },
    url: "php/join.php",
    success: function (response) {
      console.log(response);
    },
  });
}

// for del
var d = document.getElementById("del");
d.onclick = () => {
  for_delete("del");
};

// for clear
var c = document.getElementById("clear");
c.onclick = () => {
  for_delete("c");
};

function for_delete(type) {
  var name = pathArray[1];

  // alert(k)
  $.ajax({
    type: "POST",
    data: {
      input: name,
      do: type,
    },
    url: "php/del.php",
    success: function (response) {
      // location.reload(true);
      console.log(response)
    },
  });
}
