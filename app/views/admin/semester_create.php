<form method="POST">
<h3>Create Semester</h3>

<select name="program_id" required>
<?php foreach($programs as $p): ?>
<option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
<?php endforeach; ?>
</select>

<input name="name" placeholder="Semester name" required>
<button>Create</button>
</form>
<style>
    /* Container for the semester form */
form {
    max-width: 500px;        /* Wider than previous form */
    margin: 50px auto;       /* Center horizontally and some spacing from top */
    padding: 40px;           /* More padding for height */
    background-color: #1a1f3a; /* Dark blue background */
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
    color: #f0f0f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Heading */
form h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #e0e0ff;
    font-size: 1.6rem;
}

/* Select field */
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

/* Select focus effect */
form select:focus {
    border-color: #5060a0;
    background-color: #333a60;
    outline: none;
}

/* Input field */
form input {
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

/* Input focus effect */
form input:focus {
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