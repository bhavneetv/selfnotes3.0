

function handleSearch() {
  const searchInput = document.getElementById('searchInput');
  const searchTerm = searchInput.value.trim().toLowerCase(); // Get the search term

  // Get all note containers currently in the notesSection div
  const notes = document.querySelectorAll('.note_box');

  for (let i = 0; i < notes.length; i++) {
    const note = notes[i];
    const title = note.querySelector('h3').textContent.toLowerCase(); // Get the note title
    const description = note.querySelector('p.text-gray-600').textContent.toLowerCase(); // Get the note description
    const author = note.querySelector('.author').textContent.toLowerCase(); // Get the note author
    const subject = note.querySelector('.subject').textContent.toLowerCase(); // Get the note subject
    const chapter = note.querySelector('.chapter').textContent.toLowerCase(); // Get the note chapter

    // Check if the title or description includes the search term
    if (title.includes(searchTerm) || description.includes(searchTerm) || author.includes(searchTerm) || subject.includes(searchTerm) || chapter.includes(searchTerm)) {
      note.style.display = 'block'; // Show the note if it matches the search term
      note.classList.add('animate-fade-in');
    } else {
      note.style.display = 'none'; // Hide the note if it doesn't match
    }
  }


}
const style = document.createElement('style');
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
document.getElementById('searchInput').addEventListener('input', handleSearch);


  

  