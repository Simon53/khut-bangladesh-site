@extends('layout.app')

@section('title', 'My Cart')
@section('content')
<!-- ===== Checkout Section ===== -->
<div class="container">
    <div class="row">
        <div class="container py-5">
            <!-- Tabs -->
            <ul class="nav new-nav-tabs" id="checkoutTabs" role="tablist">
                <li><a class="nav-link active" id="billing-tab" data-toggle="tab" href="#billing" role="tab">Billing</a></li>
                <li><a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab">Shipping</a></li>
                <li><a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab">Order Review</a></li>
                <li><a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab">Payment</a></li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content checkoutTabLebel pt-3" id="checkoutTabContent">

                <!-- Billing Tab -->
                <div class="tab-pane fade show active" id="billing" role="tabpanel">
                    <div class="titel"><h2>Billing details</h2></div>
                    <form>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name *</label>
                                <input type="text" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name *</label>
                                <input type="text" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h6>Country *</h6>
                                <h6>Bangladesh *</h6>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Apartment address (optional)</label>
                            <input type="text" class="form-control" placeholder="Apartment, suite, unit etc. (optional)">
                        </div>
                        <div class="form-group">
                            <label>Street address *</label>
                            <input type="text" class="form-control" placeholder="Building No. Flat No. Street No. etc." required>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Town / City *</label>
                                <input type="text" class="form-control" placeholder="Town / City" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>District *</label>
                                <select class="form-control" required>
                                    <option>Select your district...</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Dhaka">Khulna</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Postcode/ZIP *</label>
                                <input type="text" class="form-control" placeholder="4-digit Number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Phone *</label>
                                <input type="text" class="form-control" placeholder="11-digit Number ei. 01xxxxxxxxx" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email address *</label>
                                <input type="email" class="form-control" placeholder="example@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Additional Note (Optional)</label>
                            <textarea class="form-control" rows="5" placeholder="Additional Note (Optional)"></textarea>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">Create an account?</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                </div>

                <!-- Shipping Tab -->
                <div class="tab-pane fade" id="shipping" role="tabpanel">
                    <div class="titel">
                        <h2><input type="checkbox" id="shipDifferent"> Ship to a different address?</h2>
                    </div>
                    <form id="shippingForm">
                        <div class="shippingHidden">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>First Name *</label>
                                    <input type="text" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name *</label>
                                    <input type="text" class="form-control" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h6>Country *</h6>
                                    <h6>Bangladesh *</h6>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Apartment address (optional)</label>
                                <input type="text" class="form-control" placeholder="Apartment, suite, unit etc. (optional)">
                            </div>
                            <div class="form-group">
                                <label>Street address *</label>
                                <input type="text" class="form-control" placeholder="Building No. Flat No. Street No. etc." required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Town / City *</label>
                                    <input type="text" class="form-control" placeholder="Town / City" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>District *</label>
                                    <select class="form-control" required>
                                        <option>Select your district...</option>
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Dhaka">Khulna</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Postcode/ZIP *</label>
                                    <input type="text" class="form-control" placeholder="4-digit Number" required>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-secondary" type="button" onclick="nextTab('billing-tab')">Back</button>
                        <button class="btn btn-dark" type="button" onclick="nextTab('review-tab')">Next</button>
                    </form>
                </div>

                <!-- Order Review Tab -->
                <div class="tab-pane fade" id="review" role="tabpanel">
                    <div id="orderSummary"></div>
                    <button class="btn btn-secondary" type="button" onclick="nextTab('shipping-tab')">Back</button>
                    <button class="btn btn-dark" type="button" onclick="nextTab('payment-tab')">Next</button>
                </div>

                <!-- Payment Tab -->
                <div class="tab-pane fade" id="payment" role="tabpanel">
                    <div class="form-group">
                        <label><strong>Select Payment Method:</strong></label><br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="cod" checked>
                            <label class="form-check-label">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="bkash">
                            <label class="form-check-label">bKash</label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-secondary" type="button" onclick="nextTab('review-tab')">Back</button>
                        <button class="btn btn-success">Place Order</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ===== End Checkout Section ===== -->
@endsection

@section('script')
<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/custom.js') }}"></script>

<script>
    function nextTab(tabId) {
        $('a[href="#' + tabId.replace('-tab','') + '"]').tab('show');
    }

    function loadOrderSummary() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        let subtotal = 0;
        let html = `
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Barcord</th>
                        <th>Price</th>
                        
                    </tr>
                </thead>
                <tbody>
        `;

        cart.forEach(item => {
            subtotal += item.qty * item.price;
            html += `
            <tr>
                <td><button class="btn btn-sm btn-danger removeItem" data-id="${item.id}">×</button></td>
                <td><img src="${item.img}" alt="${item.name}" width="50"></td>
                <td>${item.name}</td>
                <td>${item.size || '-'}</td>
                <td>${item.color || '-'}</td>
                <td>${item.qty}</td>
                <td>${item.barcode}</td>
                <td>৳ ${item.qty * item.price}</td>
              
            </tr>`;
        });

        html += `
                </tbody>
                <tfoot>
                    
                    <tr><td></td><td colspan="6">Subtotal</td><td>৳ ${subtotal}</td></tr>
                    <tr><td></td><td colspan="6">Delivery</td><td>৳ 80</td></tr>
                    <tr><td></td><td colspan="6"><strong>Total</strong></td><td><strong>৳ ${subtotal + 80}</strong></td></tr>
                </tfoot>
            </table>
        </div>`;

        document.getElementById("orderSummary").innerHTML = html;

        document.querySelectorAll(".removeItem").forEach(btn => {
            btn.addEventListener("click", e => {
                const id = e.target.dataset.id;
                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                cart = cart.filter(item => item.id != id);
                localStorage.setItem("cart", JSON.stringify(cart));
                loadOrderSummary();
                if(typeof renderCart === "function") renderCart();
                if(typeof updateCartCounts === "function") updateCartCounts();
            });
        });
    }

    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if(e.target.id === 'review-tab') {
                loadOrderSummary();
            }
        });

        // Shipping toggle
        $(".shippingHidden").hide();
        $("#shipDifferent").on("change", function() {
            if($(this).is(":checked")) {
                $(".shippingHidden").slideDown();
            } else {
                $(".shippingHidden").slideUp();
            }
        });
    });

//--------place order-----
 $(document).on("click", ".btn-success", function() {
    const cart = localStorage.getItem("cart");
    if (!cart || JSON.parse(cart).length === 0) {
        alert("Your cart is empty!");
        return;
    }

    const form = {
        first_name: $("input[placeholder='First Name']").val(),
        last_name: $("input[placeholder='Last Name']").val(),
        email: $("input[placeholder='example@email.com']").val(),
        phone: $("input[placeholder*='01']").val(),
        address: $("input[placeholder*='Building']").val(),
        district: $("select.form-control option:selected").text(),
        city: $("input[placeholder='Town / City']").val(),
        postcode: $("input[placeholder='4-digit Number']").val(),
        note: $("textarea").val(),
        payment_method: $("input[name='paymentMethod']:checked").val(),
        cart: cart
    };

    $.ajax({
        url: "{{ route('order.store') }}",
        method: "POST",
        data: form,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function(res) {
            if (res.success) {
                alert(res.message);
                localStorage.removeItem("cart");
                window.location.href = "/";
            } else {
                alert("Error: " + res.message);
            }
        },
        error: function(err) {
            alert("Failed to place order.");
        }
    });
});
</script>
@endsection
