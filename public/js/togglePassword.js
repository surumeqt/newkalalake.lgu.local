document.getElementById('toggle-password-hide').addEventListener('click', togglePasswordVisibility);
document.getElementById('toggle-password-show').addEventListener('click', togglePasswordVisibility);
document.getElementById('username').addEventListener('click', removeErrorMessage);

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const hideIcon = document.getElementById('toggle-password-hide');
    const showIcon = document.getElementById('toggle-password-show');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        hideIcon.style.display = 'none';
        showIcon.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        hideIcon.style.display = 'block';
        showIcon.style.display = 'none';
    }
}

function removeErrorMessage() {
    const errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.textContent = '';
    }
}