<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>

    @if ($message = Session::get('message'))
        <p>{{ $message }}</p>
    @endif

    <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="file" name="file" id="">
        <button type="submit">Upload</button>
    </form>
</body>
</html>