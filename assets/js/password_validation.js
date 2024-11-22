function validateForm(event) {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    const passwordStrength = document.getElementById("passwordStrength");

    confirmPasswordError.textContent = ""; // Clear previous errors

    // Check password strength
    if (password.length < 8) {
        passwordStrength.textContent = "Password must be at least 8 characters.";
        passwordStrength.style.color = "red";
        event.preventDefault();
        return false;
    } else {
        passwordStrength.textContent = "Strong password.";
        passwordStrength.style.color = "green";
    }

    // Check if passwords match
    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.style.color = "red";
        event.preventDefault();
        return false;
    }

    return true; // Form is valid
}
