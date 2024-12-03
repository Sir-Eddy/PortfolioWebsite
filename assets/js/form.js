document.querySelector(".form").addEventListener("submit", function (event) {
    event.preventDefault(); // Standardabsendung verhindern (optional)
    
    // AJAX-Aufruf an PHP-Skript (optional) oder leere Felder nach dem Absenden
    const form = event.target;
    
    // Formular absenden
    fetch(form.action, {
      method: form.method,
      body: new FormData(form)
    })
      .then(response => response.text())
      .then(result => {
        alert("Nachricht wurde erfolgreich gesendet!"); // Erfolgsmeldung
        form.reset(); // Formular zurücksetzen
      })
      .catch(error => {
        console.error("Fehler:", error);
      });
  });