<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>update</title>
</head>
<body>
    @if (session('destroy'))
        {{ session('destroy') }}
    @endif
    <form action="{{ route('update', $product_info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="old_thumbnail" value="{{ $product_info->thumbnail }}">
        <div>
            <label>Product Name</label>
            <input type="text" name="name" value="{{ $product_info->name }}">
        </div><br>
        <div>
            <label>Product Price</label>
            <input type="text" name="price" value="{{ $product_info->price }}">
        </div><br>
        <div>
            <label>Product Thumbnail</label>
            <input type="file" name="thumbnail">
            <span>previous thumbnail: <img src="{{ asset('assets/images/product-images/thumbnail/'. $product_info->thumbnail) }}" alt="" height="50" width="50"></span>
        </div><br>
        <div>
            <label>Product Images</label>
            <input type="file" name="image[]" multiple>
            <span>previous temporary images:
                @forelse ($product_info->temporaryImages as $images)
                <img src="{{ asset('assets/images/product-images/multiple-images/' . $images->image) }}" alt="" height="50" width="50"><a href="{{ route('destroyThumbnail', $images->id) }}">X</a>
                @empty
                <p>this item has no temporary image</p>
                @endforelse
            </span>
        </div><br>
        <button type="submit">Update</button>
        <a href="{{ route('index') }}" type="submit">cancle</a>
    </form>


</body>
</html>
