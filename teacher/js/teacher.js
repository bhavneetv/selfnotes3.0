
window.addEventListener("load", () => {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.add("-translate-x-full");
    setTimeout(() => {
      document.getElementById("loadingScreen").style.opacity = "0";
      setTimeout(() => {
        document.getElementById("loadingScreen").style.display = "none";
      }, 500);
    }, 1500);
  });
  
  // Mobile menu functionality
  
  document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.add("-translate-x-full");
    const menuBtn = document.getElementById("menuBtn");
  
    // Function to check if device width is less than 1500px
    function isMobileView() {
      return window.innerWidth < 1500;
    }
  
    // Toggle sidebar
    menuBtn.addEventListener("click", function () {
      sidebar.classList.toggle("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    });
  
    // Handle window resize
    window.addEventListener("resize", function () {
      if (!isMobileView()) {
        sidebar.classList.remove("-translate-x-full");
        document.getElementById("closeSidebar").style.display = "block";
      } else {
        sidebar.classList.add("-translate-x-full");
        document.getElementById("closeSidebar").style.display = "block";
      }
    });
  
    // Initial state check
    if (!isMobileView()) {
      sidebar.classList.remove("-translate-x-full");
      document.getElementById("closeSidebar").style.display = "block";
    }
  
  
    document
      .getElementById("closeSidebar")
      .addEventListener("click", function () {
        sidebar.classList.add("-translate-x-full");
        document.getElementById("closeSidebar").style.display = "none";
      });
  });
    document.getElementById("menuBtn").addEventListener("click", function() {
        sidebar.classList.toggle("-translate-x-full");
        document.getElementById("closeSidebar").style.display = "block";
    });  