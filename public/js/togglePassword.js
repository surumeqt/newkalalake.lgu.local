document.getElementById('toggle-password-hide').addEventListener('click', togglePasswordVisibility);
document.getElementById('toggle-password-show').addEventListener('click', togglePasswordVisibility);

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