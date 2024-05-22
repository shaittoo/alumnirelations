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
