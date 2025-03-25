function loginUser(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(document.querySelector(".Login_form"));

    fetch("OQ_Login_php.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())  // Ensure JSON parsing
    .then(data => {
        if (data.success) {
            alert("Login Successful!"); 
            document.getElementById("login_form").style.display = "none"; // Hide login form
            document.getElementById("quiz_details").style.display = "block"; // Show Quiz Details
        } else {
            alert("Error: " + data.message); // Show error message if login fails
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Login failed! Please try again.");
    });
}
