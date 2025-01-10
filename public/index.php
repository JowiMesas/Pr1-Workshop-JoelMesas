
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Workshop</title>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Body Styling */
body {
    background-color: #f4f4f9;
    color: #333;
    padding: 20px;
    line-height: 1.6;
}

/* Main Headings */
h1 {
    font-size: 2.5rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 10px;
}

h2 {
    font-size: 1.5rem;
    color: #34495e;
    text-align: center;
    margin-bottom: 20px;
}

/* Forms */
form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 0 auto;
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #34495e;
}

form select,
form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #2980b9;
}
    </style>
</head>
<body>
    <h1>Car Workshop</h1>
    <h2>Choose your role</h2>
    <form action="../src/View/ViewReparation.php" method="get" >
    <label for="role">
        Role:
        <select name="role" id="">
        <option value="employee">Employee</option>
        <option value="client">Client</option>
        </select>
    </label>
    <br>
    <br>
    <input type="submit" value="Send">
    </form>
</body>
</html>