function validateForm(event) {
    // Prevent the form from submitting until validation is complete
    event.preventDefault();
    
    let email = document.getElementById("email");
    let password = document.getElementById("password").value;
    let message = document.getElementById("message");
    message.textContent = ""; // Clear previous message
    let isValid = true;

    // Email validation
    if (!ValidateEmail(email)) {
        isValid = false;
        message.textContent += "Invalid email address. ";
    }

    // Password validation
    let passwordMessage = checkPassword();
    if (passwordMessage !== "") {
        isValid = false;
        message.textContent += passwordMessage;
    }

    // If validation passes, submit the form
    if (isValid) {
        message.textContent = "Form submitted successfully!";
        // Uncomment this line if you want to actually submit the form
        // document.getElementById("loginForm").submit();
    }

    return isValid;
}

function checkPassword() {
    let password = document.getElementById("password").value;
    let message = "";

    if (password.length < 8) {
        message += "Password must be at least 8 characters long. ";
    }
    if (!/[A-Z]/.test(password)) {
        message += "Password must contain at least one uppercase letter. ";
    }
    if (!/[a-z]/.test(password)) {
        message += "Password must contain at least one lowercase letter. ";
    }
    if (!/[0-9]/.test(password)) {
        message += "Password must contain at least one number. ";
    }

    return message;
}

function ValidateEmail(inputText) {
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.value.match(mailformat)) {
        return true;
    } else {
        return false;
    }
}
