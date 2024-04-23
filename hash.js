
document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault();  // Prevent the form from submitting normally

    // Get the password from the form
    const password = document.getElementById('password').value;
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    // Set the hashed password in the hidden field
    document.getElementById('hashedPassword').value = hashHex;

    // Submit the form
    this.submit();
});
