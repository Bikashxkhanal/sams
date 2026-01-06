<form method="POST">
<h3>Create Program</h3>
<input name="name" placeholder="Program name" required>
<button>Create</button>
</form>
<style >/* Container for the form */
form {
    max-width: 400px;
    margin: 50px auto; /* Center the form vertically and horizontally */
    padding: 30px;
    background-color: #1a1f3a; /* Dark blue background */
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    color: #f0f0f5; /* Light gray text */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Heading */
form h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #e0e0ff; /* Slightly lighter than background */
    font-size: 1.5rem;
}

/* Input field */
form input {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid #3b3f5c; /* Darker border */
    border-radius: 8px;
    background-color: #2a2f50; /* Slightly lighter dark blue */
    color: #f0f0f5;
    font-size: 1rem;
    transition: all 0.3s ease;
}

/* Input focus effect */
form input:focus {
    border-color: #5060a0;
    background-color: #333a60;
    outline: none;
}

/* Button */
form button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background-color: #5060a0; /* Blue button */
    color: #f0f0f5;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Button hover */
form button:hover {
    background-color: #3d4a80;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>