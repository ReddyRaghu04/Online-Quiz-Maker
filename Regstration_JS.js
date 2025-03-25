function registerUser(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(document.getElementById("reg"));

    fetch("OQ_Registration_php.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())  // Ensure JSON parsing
    .then(data => {
        if (data.success) {
            alert(data.message); // Show success message
            document.getElementById('reg_form').style.display = "none";
            document.getElementById('login_form').style.display = "block";
        } else {
            alert("Error: " + data.message); // Show error message if registration fails
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Registration failed! Please try again.");
    });
}
