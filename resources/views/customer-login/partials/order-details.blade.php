<div>
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ৳{{ number_format($order->total, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->size ?? '-' }}</td>
                        <td>{{ $item->color ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->price, 2) }}</td>
                        <td>৳{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
