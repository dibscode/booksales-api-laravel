<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
</head>
<body>
    <h1>Hello world!</h1>
    <p>Selamat datang di booksales</p>

    @foreach ($books as $book)
        <ul>
            <li>{{$book['title']}}</li>
            <li>{{$book['description']}}</li>
            <li>{{$book['price']}}</li>
            <li>{{$book['stock']}}</li>
        </ul>
    @endforeach

</body>
</html>