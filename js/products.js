$(document).ready(function() {
    // Load products when page loads
    loadProducts();

    // Handle form submission
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        const productId = $('#productId').val();
        
        const productData = {
            name: $('#name').val(),
            description: $('#description').val(),
            price: $('#price').val(),
            category_id: $('#category_id').val()
        };

        if (productId) {
            updateProduct(productId, productData);
        } else {
            addProduct(productData);
        }
    });

    // Cancel edit button
    $('#cancelEdit').on('click', function() {
        resetForm();
    });
});

// Load all products
function loadProducts() {
    $.ajax({
        url: 'api/products.php',
        method: 'GET',
        success: function(response) {
            displayProducts(response);
        },
        error: function(xhr, status, error) {
            alert('Error loading products: ' + error);
        }
    });
}

// Display products in the table
function displayProducts(products) {
    const productList = $('#productList');
    productList.empty();

    products.forEach(function(product) {
        const row = `
            <tr>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.price}</td>
                <td>${product.category_name}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editProduct(${product.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                </td>
            </tr>
        `;
        productList.append(row);
    });
}

// Add new product
function addProduct(productData) {
    $.ajax({
        url: 'api/products.php',
        method: 'POST',
        data: productData,
        success: function(response) {
            if (response.success) {
                alert('Product added successfully!');
                resetForm();
                loadProducts();
            } else {
                alert('Error adding product: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error adding product: ' + error);
        }
    });
}

// Update existing product
function updateProduct(id, productData) {
    $.ajax({
        url: 'api/products.php',
        method: 'PUT',
        data: { ...productData, id: id },
        success: function(response) {
            if (response.success) {
                alert('Product updated successfully!');
                resetForm();
                loadProducts();
            } else {
                alert('Error updating product: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error updating product: ' + error);
        }
    });
}

// Delete product
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: 'api/products.php',
            method: 'DELETE',
            data: { id: id },
            success: function(response) {
                if (response.success) {
                    alert('Product deleted successfully!');
                    loadProducts();
                } else {
                    alert('Error deleting product: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error deleting product: ' + error);
            }
        });
    }
}

// Edit product
function editProduct(id) {
    $.ajax({
        url: 'api/products.php',
        method: 'GET',
        data: { id: id },
        success: function(product) {
            $('#productId').val(product.id);
            $('#name').val(product.name);
            $('#description').val(product.description);
            $('#price').val(product.price);
            $('#category_id').val(product.category_id);
            $('#formTitle').text('Edit Product');
            $('#cancelEdit').show();
        },
        error: function(xhr, status, error) {
            alert('Error loading product: ' + error);
        }
    });
}

// Reset form
function resetForm() {
    $('#productForm')[0].reset();
    $('#productId').val('');
    $('#formTitle').text('Add New Product');
    $('#cancelEdit').hide();
} 