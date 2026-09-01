
<table>
    @php $maxVariants = 5; @endphp
    <thead>
        <tr>
            <th>Book Id</th>
            <th>Book Name</th>
            <th>URL</th>
            <th>Image URL</th>
            <th>Category</th>
            <th>Sub Category </th>
            <th>Child Category</th>
            <th>Author</th>
            <th>Description</th>
            <th>Language</th>
            <th>ISBN13</th>
            <th>Publisher</th>
            <th>Date Published</th>
            <th>Edition</th>
            <th>MRP</th>
            <th>Selling Price</th>
            <th>Discount Price</th>
            <th>GST Charge</th>
            <th>SKU Number</th>
            <th>HSN Code</th>
            <th>Listed By</th>
            <th>Added Date</th>
            <th>Last Update</th>
            <th>Status</th>
            <th></th>
            @for($i = 1; $i <= $maxVariants; $i++)
                <th>Condition {{ $i }}</th>
                <th>Price {{ $i }}</th>
                <th>Stock {{ $i }}</th>
                <th>Weight {{ $i }}</th>
                <th>SKU {{ $i }}</th>
            @endfor
        </tr>
    </thead>
   
    <tbody>
    @foreach($invoices as $key => $invoice)
        <tr>
            <td>{{ $invoice->book_id ?? '' }}</td>
            <td>{{ $invoice->name ?? '' }}</td>
            <td>{{ route('product.details', [$invoice->categories->url_slug ?? '', $invoice->url_slug ?? '']) }}</td>
            <td>{{ asset('')}}public/upload/admin_images/books/{{ $invoice->image }}</td>
            <td>{{ $invoice->product_category->name ?? '' }}</td>
            <td>{{ $invoice->product_sub_category->name ?? '' }}</td>
            <td>{{ $invoice->product_child_category->name ?? '' }}</td>
            <td>{{ $invoice->author ?? '' }}</td>
            <td>{{ $invoice->title_long ?? '' }}</td>
            <td>{{ $invoice->language ?? '' }}</td>
            <td>{{ $invoice->isbn13 ?? '' }}</td>
            <td>{{ $invoice->publisher ?? '' }}</td>
            <td>
                @if($invoice->date_published)
                    {{ date('d M, Y', strtotime($invoice->date_published)) }}
                @endif
            </td>
            <td>{{ $invoice->edition ?? '' }}</td>
            <td>{{ $invoice->original_price ?? '' }}</td>
            <td>{{ $invoice->selling_price ?? '' }}</td>
            <td>{{ $invoice->discount ?? '' }}</td>
            <td>{{ $invoice->gst_charge ?? '' }}</td>
            <td>{{ $invoice->sku ?? '' }}</td>
            <td>{{ $invoice->hsn_code ?? '' }}</td>
            <td>{{ $invoice->listed_by ?? '' }}</td>
            <td>{{ date('d-m-Y h:i a', strtotime($invoice->created_at)) }}</td>
            <td>{{ date('d-m-Y h:i a', strtotime($invoice->updated_at)) }}</td>
            <td>
                @if($invoice->status == 1)
                    Active
                @else
                    In Active
                @endif
            </td>
            <td></td>
            @foreach($invoice->varients as $key => $value)
            <td>{{ $value->bookconditions ?? '' }}</td>
            <td>{{ $value->price ?? '' }}</td>
            <td>{{ $value->stock ?? '' }}</td>
            <td>{{ $value->book_weight ?? '' }}</td>
            <td>{{ $value->sku_number ?? '' }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>