<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <a href="{{ route('create') }}" class="btn btn-primary m-5">add a product</a>


    <section>
        <div class="container">
            <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3 m-3">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('assets/images/product-images/thumbnail/' . $product->thumbnail) }}"
                            class="card-img-top" alt="...">
                            <hr>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}</p>
                            <hr>
                            <div class="row">
                                @forelse ($product->temporaryImages as $single_temporary_image)
                                    <div class="col-md-4">
                                        <img src="{{ asset('assets/images/product-images/multiple-images/' . $single_temporary_image->image) }}" alt="" height="60" width="70">
                                    </div>
                                @empty
                                    <p>this item has no multiple images</p>
                                @endforelse
                            </div>
                            <a href="{{ route('edit', $product->id) }}" class="btn btn-warning mt-3">Edit</a>
                            <a href="{{ route('destroy', $product->id) }}" class="btn btn-danger mt-3">Delete</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-danger">No product found</p>
            @endforelse
        </div>
        </div>
    </section>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>
