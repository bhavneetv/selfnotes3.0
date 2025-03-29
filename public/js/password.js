$("#otpButton").click(function () {
  check_mail();
});

function check_mail() {
  var k = $("#reset-email").val();
  //   console.log(k)
  $.ajax({
    type: "POST",
    url: "js/check_mail.php",
    data: {
      email: k,
    },
    beforeSend: function () {
      $("#loader-email").removeClass("hidden");
    },
    success: function (response) {
      // console.log(response)
      if (response == "yes") {
        alert("Otp Sended");
        $("#loader-email").addClass("hidden");
        $("#forgotPasswordEmailModal").css("display", "none");
        $("#otpVerificationModal").css("display", "flex");
      } else {
        alert("User Not Found");
        alert(response);
        $("#loader-email").addClass("hidden");
      }
    },
  });
}

$("#verifyButton").click(function () {
  check_otp();
});

function check_otp() {
  var k = $("#otp").val();
  console.log(k);
  $.ajax({
    type: "POST",
    url: "js/otp.php",
    data: {
      otp: k,
      //   mail: mp
    },
    beforeSend: function () {
      $("#loader-email").removeClass("hidden");
    },
    success: function (response) {
      console.log(response);
      if (response == "yes") {
        $("#loader-otp").addClass("hidden");
        $("#otpVerificationModal").css("display", "none");
        $("#newPasswordModal").css("display", "flex");
      } else if (response == "e") {
        $("#loader-otp").addClass("hidden");
        $("#forgotPasswordEmailModal").css("display", "flex");
        $("#otpVerificationModal").css("display", "none");
      } else {
        $("#loader-otp").addClass("hidden");

        alert(response);
      }
    },
  });
}



function change_password() {
  // var m = $('#mail-i').val();
  var pass1 = $("#pass-i1").val();
  var pass2 = $("#pass-i2").val();
  if (pass1 == pass2) {
    // var kk = $('#code-i').html();
    $.ajax({
      type: "POST",
      url: "js/pass_u.php",
      data: {
        // mail:m,
        pass: pass1,
      },
      beforeSend: function () {
        $("#loader-new").removeClass("hidden");
      },
      success: function (response) {
        console.log(response);
        if (response == "yes") {
          alert("Password Reset");
          $("#loader-new").addClass("hidden");
          $("#newPasswordModal").css("display", "none");
          $("#black").css("display", "none");
        } else if (response == "e") {
          // alert("Failed")
          $("#loader-new").addClass("hidden");
        } else {
          $("#loader-new").addClass("hidden");

          alert(response);
        }
      },
    });
  } else {
    alert("Password Not Matched");
  }
}

$("#resetButton").on("click", function () {
  change_password();
});


document.getElementById("forgot-password").addEventListener("click", function() {
  document.getElementById("black").style.display = "block";
});

let close = document.getElementsByClassName("close")

for (let i = 0; i < close.length; i++) {
  close[i].addEventListener("click", function() {
    document.getElementById("black").style.display = "none";
  });
}
