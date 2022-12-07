<html>

<head>
    <meta charset="utf-8">
    <title>Test Task </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        main>.container {
            padding: 60px 15px 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Test Task</a>
            </div>
        </nav>
    </header>
    <main class="flex-shrink-0">
        <div class="container" id="post">
            {{-- here loads posts --}}
        </div>
        <form class="form">

            <div class="form-group">


                <select name="category" id="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->category }}" @if (request()->category == $category->category) selected @endif>
                            {{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">

                @foreach ($brands as $brand)
                    <label for="{{ $brand->brand }}">{{ $brand->brand }}</label>
                    <input type="checkbox" name="brand[]" value="{{ $brand->brand }}"
                        @if (request('brand')&& in_array($brand->brand, request('brand'))) checked @endif>
                @endforeach

            </div>

            <div class="form-group">
                <input type="text" name="searchText" value="{{ request('searchText') }}" placeholder="searchText">
            </div>

            <button type="submit">Show</button>

        </form>

        <div class="text-center m-3">
            <table id="products">
                <thead>
                    <th>#</th>
                    <th>products</th>
                    <th>category</th>
                    <th>brand</th>

                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->product }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->brand }}</td>
                        </tr>
                    @empty
                        <h4>no products</h4>
                    @endforelse

                </tbody>
            </table>

            <button class="btn btn-primary" id="load-more" data-paginate="2">Load more...</button>
            <p class="invisible">No more products...</p>
        </div>
    </main>
    <script type="text/javascript">
        var paginate = 1;
        // loadMoreData(paginate);
        $('#load-more').click(function() {
            var page = $(this).data('paginate');
            loadMoreData(page);
            $(this).data('paginate', page + 1);
        });
        // run function when user click load more button
        function loadMoreData(paginate) {
            $.ajax({
                    url: '?page=' + paginate,
                    type: 'get',
                    datatype: 'html',
                    beforeSend: function() {
                        $('#load-more').text('Loading...');
                    }
                })
                .done(function(data) {
                    console.log(data)

                    if (data.length == 0) {
                        $('.invisible').removeClass('invisible');
                        $('#load-more').hide();
                        return;
                    } else {
                        $('#load-more').text('Load more...');
                        $('#products').append(data);
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Something went wrong.');
                });
        }
    </script>
</body>

</html>
