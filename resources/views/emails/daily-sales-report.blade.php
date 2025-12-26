


<p><strong>Daily Sales Report</strong></p>
<p>Date: <strong>{{ $date }}</strong></p>

@if($items->isEmpty())
    <p>No sales recorded today.</p>
@else
    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th align="left">Product</th>
                <th align="right">Qty Sold</th>
                <th align="right">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td align="right">{{ $item->total_qty }}</td>
                    <td align="right">${{ number_format($item->total_cents / 100, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
