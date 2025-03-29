
// Dark Mode
const themeToggle = document.getElementById("themeToggle");
const body = document.body

if(localStorage.getItem('darkMode') === 'true'){
    body.classList.add("dark-mode");
}else{
    body.classList.remove("dark-mode");
}


document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const menuBtn = document.getElementById('menuBtn');

  // Function to check if device width is less than 1500px
  function isMobileView() {
      return window.innerWidth < 1500;
  }

  // Toggle sidebar
  menuBtn.addEventListener('click', function() {
     
          sidebar.classList.toggle('-translate-x-full');
      document.getElementById('closeSidebar').style.display = 'block';
  });

  // Handle window resize
  window.addEventListener('resize', function() {
      if (!isMobileView()) {
          sidebar.classList.remove('-translate-x-full');
          document.getElementById('closeSidebar').style.display = 'block';
      } else {
          sidebar.classList.add('-translate-x-full');
          document.getElementById('closeSidebar').style.display = 'block';
      }
  });

  // Initial state check
  if (!isMobileView()) {
      sidebar.classList.remove('-translate-x-full');
      document.getElementById('closeSidebar').style.display = 'block';
  }

  // Close sidebar when closing button is clicked
  document.getElementById('closeSidebar').addEventListener('click', function() {
      sidebar.classList.add('-translate-x-full');
      document.getElementById('closeSidebar').style.display = 'none';
  });
});
