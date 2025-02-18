<x-app-layout>
    @section('title', 'Home Page')

    @section('content')
        <h2 class="text-center">LARAVEL AJAX CRUD</h2>
        <form id="productForm">
            <input type="hidden" id="product_id">
            <div class="mb-3">
                <label for="name">Product Name</label>
                <input type="text" id="name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <input type="text" id="description" class="form-control">
            </div>
            <div class="mb-3">
                <label for="price">Price</label>
                <input type="text" id="price" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

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

                $("#productForm").submit(function(e){
                    e.preventDefault();
                    let id = $("#product_id").val();
                    let url = id ? `/products/${id}` : '/products';
                    let method = id ? 'PUT' : 'POST';
                    
                    $.ajax({
                        url: url,
                        method: method,
                        data: {
                            name: $("#name").val(),
                            description: $("#description").val(),
                            price: $("#price").val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(){
                            $("#productForm")[0].reset();
                            $("#product_id").val('');
                            loadProducts();
                        }
                    });
                });


            $(document).on("click", ".edit", function(){
                let id = $(this).data("id");  // Get the product ID
               
                $.get(`/products/${id}`, function(product){
                    $("#product_id").val(product.id);  // Set the product ID in the hidden field
                    $("#name").val(product.name);  // Fill the form fields with the product data
                    $("#description").val(product.description);
                    $("#price").val(product.price);
                });
            
            });



                $(document).on("click", ".delete", function(){
                    let id = $(this).data("id");
                    $.ajax({
                        url: `/products/${id}`,
                        method: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(){
                            loadProducts();
                        }
                    });
                });
            });
    </script>
     
    @endsection
</x-app-layout>
