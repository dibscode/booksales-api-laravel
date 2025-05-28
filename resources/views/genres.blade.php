<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book_Genres</title>
</head>
<body>
    <h1>Ini adalah halaman genre dari buku ini</h1>
    <p>Selamat datang di genre buku</p>

    @foreach ($genres as $genre)
        <ul>
            <li>{{$genre['id']}}</li>
            <li>{{$genre['name']}}</li>
            <li>{{$genre['description']}}</li>
        </ul>
    @endforeach
</body>
</html>