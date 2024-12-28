
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Workshop</title>
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