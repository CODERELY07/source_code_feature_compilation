<x-app-layout>
    @section('title', 'Home Page')

    @section('content')
        <h3>Product List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable"></tbody>
        </table>
    @endsection

    @section('script')
    <script>
           $(document).ready(function(){
                loadProducts();

                function loadProducts(){
                    $.get('/products/list', function(products){
                        let rows = '';
                        $.each(products, function(index, product){
                            rows += `<tr>
                                <td>${product.name}</td>
                                <td>${product.description}</td>
                                <td>${product.price}</td>
                                <td>
                                    <button class="btn btn-warning edit" data-id="${product.id}">Edit</button>
                                    <button class="btn btn-danger delete" data-id="${product.id}">Delete</button>
                                </td>
                            </tr>`;
                        });
                        $("#productTable").html(rows);
                    });
                }
            });
    </script>
     
    @endsection
</x-app-layout>
