<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-auto">
                <h3><span class="badge bg-secondary">{{ $product->name }}</span> asociado a las ventas </h3>
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <th >VENTAS</th>
                    </thead>
                    <tbody>
                        @foreach($product->sells as $sell)
                        <tr>
                            <td>{{$sell->total_price}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h3><span class="badge bg-secondary">{{ $sell->id . ', ' . $sell->total_price . ', ' . $sell->status }}</span> asociado a los productos </h3>
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <th >productos</th>
                    </thead>
                    <tbody>
                        @foreach($sell->products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
