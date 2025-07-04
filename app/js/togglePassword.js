document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeOpenIcon = document.getElementById('eye-open-icon');
    const eyeClosedIcon = document.getElementById('eye-closed-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpenIcon.classList.add('hidden');
        eyeClosedIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpenIcon.classList.remove('hidden');
        eyeClosedIcon.classList.add('hidden');
    }
});