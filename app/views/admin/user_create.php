<form method="POST">
<h3>Create User</h3>

<input name="name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="password" required>

<select name="role">
<option value="TEACHER">Teacher</option>
<option value="STUDENT">Student</option>
</select>

<button>Create User</button>
</form>
<style>/* Container for all forms (Program, Semester, Subject, User) */
form {
    max-width: 500px;           /* Wide enough for all fields */
    margin: 50px auto;          /* Center horizontally and spacing from top */
    padding: 40px;              /* Spacious padding for taller forms */
    background-color: #1a1f3a;  /* Dark blue background */
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
    color: #f0f0f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Form Heading */
form h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #e0e0ff;
    font-size: 1.6rem;
}

/* Input fields */
form input {
    width: 100%;
    padding: 14px 15px;
    margin-bottom: 20px;
    border: 1px solid #3b3f5c;
    border-radius: 8px;
    background-color: #2a2f50;
    color: #f0f0f5;
    font-size: 1rem;
    transition: all 0.3s ease;
}

/* Input focus */
form input:focus {
    border-color: #5060a0;
    background-color: #333a60;
    outline: none;
}

/* Select fields */
form select {
    width: 100%;
    padding: 14px 15px;
    margin-bottom: 25px;
    border: 1px solid #3b3f5c;
    border-radius: 8px;
    background-color: #2a2f50;
    color: #f0f0f5;
    font-size: 1rem;
    transition: all 0.3s ease;
}

/* Select focus */
form select:focus {
    border-color: #5060a0;
    background-color: #333a60;
    outline: none;
}

/* Button */
form button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    background-color: #5060a0;
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