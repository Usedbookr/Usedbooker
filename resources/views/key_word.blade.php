<table>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Key Word</th>
            <th>IP Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $key => $invoice)
        <tr>
            <td> {{ $key + 1 }}</td>
            <td> {{ $invoice->key_word }}</td>
            <td> {{ $invoice->ip_address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>