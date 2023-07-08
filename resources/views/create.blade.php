<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create</title>
</head>
<body>
    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Product Name</label>
            <input type="text" name="name">
        </div><br>
        <div>
            <label>Product Price</label>
            <input type="text" name="price">
        </div><br>
        <div>
            <label>Product Thumbnail</label>
            <input type="file" name="thumbnail">
        </div><br>
        <div>
            <label>Product Images</label>
            <input type="file" name="image[]" multiple>
        </div><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
