<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailContent->nom_courriel }}</title>
</head>
<body>
    <h1>{{ $emailContent->objet }}</h1>
    <p>{{ $emailContent->message }}</p>
</body>
</html>