let data= JSON.parse(localStorage.getItem("pdfViewData"))

document.getElementById("id").value = data.note;

document.title = "PDF | "+data.topic

document.getElementById('backBtn').addEventListener('click', () => {
    history.back();
});

// Mark as Read functionality
const markReadBtn = document.getElementById('markReadBtn');
markReadBtn.addEventListener('click', () => {
    addProgress(data.note);

    markReadBtn.classList.add('active');
});

function addProgress(id) {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "addProgress.php",

      data: {
        id:id
       
      },

      success: function (response) {
        if(response == "yes"){
            markReadBtn.classList.add('active');
        }
        else{
            alert("Login to Mark as Read");
            markReadBtn.classList.add('active');
        }
      },
    });
  }

function checkProgress() {
    $.ajax({
      type: "POST",
      // Our sample url to make request
      url: "checkProgress.php",

      data: {
        
       
      },

      success: function (response) {
        // console.log(response);
            if(response != "guest"){
                checkBtn(response)
            }
            else{
                
                markReadBtn.classList.add('active');
            }
      },
    });
}

function checkBtn(response){

    let id = response

    let idArray = id.split(",").map(Number);
    // console.log(idArray);
    
    for(let i = 0; i < idArray.length; i++){
        // console.log(idArray[i]);
        if(idArray[i] == data.note){
            // console.log("yes");
            markReadBtn.classList.add('active');
            markReadBtn.setAttribute('disabled', 'disabled');
            markReadBtn.style.cursor="not-allowed"
            break;
        
        } else {
            markReadBtn.classList.remove('active');
        }
        // console.log(tick);
    }
    

 } 

checkProgress();
// Modal functionality
const reportBtn = document.getElementById('reportBtn');
const reportModal = document.getElementById('reportModal');
const closeModal = document.getElementById('closeModal');
const cancelReport = document.getElementById('cancelReport');
const reportForm = document.getElementById('reportForm');

const toggleModal = () => {
    reportModal.classList.toggle('active');
};

[reportBtn, closeModal, cancelReport].forEach(btn => {
    btn.addEventListener('click', toggleModal);
});



reportModal.addEventListener('click', (e) => {
    if (e.target === reportModal) {
        toggleModal();
    }
});




function loadLink(data){


    let link = data.link;
// console.log(link)

    let iframe = document.getElementById('pdfFrame');

    iframe.src = "https://docs.google.com/gview?url="+link+"&embedded=true";

}

loadLink(data);
