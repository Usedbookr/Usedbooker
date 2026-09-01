
<table>

    <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
        </tr>
    </thead>
   
    <tbody>
    @foreach($invoices as $key => $invoice)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $invoice->name ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>