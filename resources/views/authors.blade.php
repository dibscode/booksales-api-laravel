<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book_Author</title>
</head>
<body>
    <h1>Ini adalah halaman author dari buku</h1>
    <p>Selamat datang di author buku</p>

    @foreach ($authors as $author)
        <ul>
            <li>{{$author['id']}}</li>
            <li>{{$author['name']}}</li>
            <li>{{$author['description']}}</li>
            <li>{{$author['photo']}}</li>
        </ul>
    @endforeach
 
</body>
</html>