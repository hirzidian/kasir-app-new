@extends('template')

@section('title', 'product')

@section('content')
    <form action="{{ route('purchases.create') }}" method="POST">
        @csrf
        <div class="row" id="product-list">
            @foreach ($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light">
                            <img src="{{ asset($product->image) }}" class="w-50">
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3 card-title">{{ $product->name }}</h5>
                            <p>Stok {{ $product->stock }}</p>
                            <h6 class="mb-3">Rp. {{ number_format($product->price, 0, ',', '.') }}</h6>
                            <p id="price_{{ $product->id }}" hidden="">{{ $product->price }}</p>
                            <center>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0px 10px 0px 10px; cursor: pointer;" class="minus"
                                                data-id="{{ $product->id }}">
                                                <b>-</b>
                                            </td>
                                            <td style="padding: 0px 10px 0px 10px;" class="num"
                                                id="quantity_{{ $product->id }}">0</td>
                                            <td style="padding: 0px 10px 0px 10px; cursor: pointer;" class="plus"
                                                data-id="{{ $product->id }}">
                                                <b>+</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </center>
                            <br>
                            <p>Sub Total <b><span id="total_{{ $product->id }}">Rp. 0</span></b></p>
                        </div>  
                    </div>
                </div>
            @endforeach

            <div class="row fixed-bottom d-flex justify-content-end align-content-center"
                style="margin-left: 18%; width: 83%; height: 70px; border-top: 3px solid #EEE4B1; background-color: white;">
                <div class="text-center col" style="margin-right: 50px;">
                    <form action="{{ route('purchases.create') }}" method="post">
                        @csrf
                        <div id="shop"></div>
                        <button type="submit" class="btn btn-primary" id="next-button" disabled>Selanjutnya</button>
                    </form>                    
                </div>
            </div>
        </div>
    </form>

    <script>
        // Function to check if any product has been ordered
        function checkNextButtonStatus() {
            let anyOrder = false;

            // Loop through all products to check if any quantity > 0
            document.querySelectorAll('.num').forEach(function(quantityElem) {
                const productId = quantityElem.id.replace('quantity_', '');
                const quantity = parseInt(quantityElem.innerText);

                // If there's at least one quantity > 0, enable the button
                if (quantity > 0) {
                    anyOrder = true;
                }
            });

            // Enable or disable the 'Selanjutnya' button based on order status
            const nextButton = document.getElementById('next-button');
            if (anyOrder) {
                nextButton.disabled = false; // Enable button
                nextButton.removeAttribute('onclick'); // Allow clicking
            } else {
                nextButton.disabled = true; // Disable button
                nextButton.setAttribute('onclick', 'return false'); // Prevent clicking
            }
        }

        // Function to update the quantity and subtotal
        function updateQuantity(productId, maxStock) {
            var quantity = parseInt(document.getElementById('quantity_' + productId).innerText);
            var price = parseInt(document.getElementById('price_' + productId).innerText);

            // Check if quantity exceeds max stock
            if (quantity > maxStock) {
                alert('Jumlah yang dipilih melebihi stok yang tersedia.');
                document.getElementById('quantity_' + productId).innerText = maxStock; // reset to max stock
                quantity = maxStock; // update quantity to max stock
            }

            var subtotal = quantity * price;
            document.getElementById('total_' + productId).innerText = "Rp. " + subtotal.toLocaleString();
            const shopInput = document.getElementById(`shop_${productId}`);
            if (shopInput) {
                shopInput.value = `${productId};${quantity};${subtotal}`;
            } else {
                addShopInput(productId, quantity, subtotal);
            }
            // After updating, check if the button should be enabled or not
            checkNextButtonStatus();
        }

        function addShopInput(productId, quantity, subtotal) {
            const shop = document.getElementById('shop');
            const shopInput = document.createElement('input');
            shopInput.setAttribute('name', 'data[]');
            shopInput.setAttribute('type', 'hidden');
            shopInput.setAttribute('value', `${productId};${quantity};${subtotal}`);
            shopInput.setAttribute('id', `shop_${productId}`);
            shop.appendChild(shopInput);
        }

        // Event listener for all products
        document.querySelectorAll('.plus').forEach(function(button) {
            button.addEventListener('click', function() {
                var productId = this.getAttribute('data-id');
                var quantityElem = document.getElementById('quantity_' + productId);
                var currentQuantity = parseInt(quantityElem.innerText);
                var maxStock = parseInt(document.getElementById('quantity_' + productId).closest('div')
                    .querySelector('p').innerText.replace('Stok ', '').trim());

                var newQuantity = currentQuantity + 1;
                document.getElementById('quantity_' + productId).innerText = newQuantity;

                // Call the function to check and update
                updateQuantity(productId, maxStock);
            });
        });

        document.querySelectorAll('.minus').forEach(function(button) {
            button.addEventListener('click', function() {
                var productId = this.getAttribute('data-id');
                var quantityElem = document.getElementById('quantity_' + productId);
                var currentQuantity = parseInt(quantityElem.innerText);

                var newQuantity = Math.max(0, currentQuantity - 1); // Ensure quantity doesn't go below 0
                document.getElementById('quantity_' + productId).innerText = newQuantity;

                // Call the function to check and update
                updateQuantity(productId, parseInt(document.getElementById('quantity_' + productId).closest(
                    'div').querySelector('p').innerText.replace('Stok ', '').trim()));
            });
        });

        // Initial check for the 'Selanjutnya' button status
        checkNextButtonStatus();
    </script>

@endsection
