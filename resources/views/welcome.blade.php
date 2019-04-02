<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <div class="text-center mt-5">
                <h2>Coalition Test</h2>
            </div>

            <form id="product-form">
                @csrf
                <div class="form-group">
                    <label for="product_name"> Product Name </label>
                    <input type="text" class="form-control" name="product_name" id="product_name" required>
                </div>
                <div class="form-group">
                    <label for="quantity"> Quantity in stock</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" required>
                </div>
                <div class="form-group">
                    <label for="price"> Price per item </label>
                    <input type="text" class="form-control" name="price" id="price" required>
                </div>

                <div class="form-group">
                    <button type="button" onclick="addProduct()">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            function addProduct () {
                $.ajax({
                    'type': 'POST',
                    'url': '{{ route() }}'
                });
            }
        });
    </script>
    </body>
</html>
