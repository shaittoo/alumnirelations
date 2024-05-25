fetch("data.json")
  .then((response) => response.json())
  .then((data) => {
    const alumniList = document.createElement("ul");
    data.alumni.forEach((alumnus) => {
      const listItem = document.createElement("li");
      listItem.textContent = `${alumnus.name} - ${alumnus.year} - ${alumnus.degree}`;
      alumniList.appendChild(listItem);
    });
    document.querySelector("main").appendChild(alumniList);
  })
  .catch((error) => console.error("Error fetching data:", error));

  document.getElementById('profilePicture').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
