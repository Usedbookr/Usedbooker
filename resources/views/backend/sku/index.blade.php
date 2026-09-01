@extends('admin.admin_master')

@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <h4 class="mb-sm-0">
                        SKU Management
                    </h4>

                </div>

            </div>
        </div>
        <div class="card">

            <div class="card-body">

                <form method="GET"
                      action="{{ route('sku.management') }}">

                    <div class="row g-3">
                        <div class="col-md-4">

                            <label class="form-label">
                                Search
                            </label>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Book name, ISBN..."
                                value="{{ request('search') }}"
                            >

                        </div>
                        <div class="col-md-3">

                            <label class="form-label">
                                Type
                            </label>

                            <select
                                name="type"
                                class="form-control"
                            >

                                <option value="">
                                    All Types
                                </option>

                                <option
                                    value="Book"
                                    {{ request('type') == 'Book' ? 'selected' : '' }}
                                >
                                    Book
                                </option>

                                <option
                                    value="Variant"
                                    {{ request('type') == 'Variant' ? 'selected' : '' }}
                                >
                                    Variant
                                </option>

                            </select>

                        </div>
                        <div class="col-md-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-control"
                            >

                                <option value="">
                                    All Status
                                </option>

                                <option
                                    value="Pending"
                                    {{ request('status') == 'Pending' ? 'selected' : '' }}
                                >
                                    Pending SKU
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary me-2"
                            >
                                Search
                            </button>

                            <a
                                href="{{ route('sku.management') }}"
                                class="btn btn-secondary"
                            >
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="row">

            <!-- TOTAL -->

            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="avatar-sm">

                                <span class="avatar-title bg-primary rounded">

                                    <i class="mdi mdi-barcode-scan font-size-20"></i>

                                </span>

                            </div>

                            <div class="ms-3">

                                <p class="text-muted mb-1">
                                    Pending SKU
                                </p>

                                <h5 class="mb-0">
                                    {{ $totalSkus }}
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="avatar-sm">

                                <span class="avatar-title bg-info rounded">

                                    <i class="mdi mdi-book-open-page-variant font-size-20"></i>

                                </span>

                            </div>

                            <div class="ms-3">

                                <p class="text-muted mb-1">
                                    Books
                                </p>

                                <h5 class="mb-0">
                                    {{ $bookCount }}
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="avatar-sm">

                                <span class="avatar-title bg-warning rounded">

                                    <i class="mdi mdi-layers font-size-20"></i>

                                </span>
                            </div>

                            <div class="ms-3">

                                <p class="text-muted mb-1">
                                    Variants
                                </p>

                                <h5 class="mb-0">
                                    {{ $variantCount }}
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="card">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-1">
                            SKU Management
                        </h4>

                        <p class="text-muted mb-0">
                            Manage books and variants without SKU
                        </p>

                    </div>
                    <button
                        type="button"
                        id="generateSkuBtn"
                        class="btn btn-success"
                        disabled
                    >

                        <i class="mdi mdi-barcode-plus"></i>

                        Generate / Assign SKU

                    </button>

                </div>
                <div class="mb-3">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="selectAll"
                        >

                        <label
                            class="form-check-label"
                            for="selectAll"
                        >

                            Select All

                        </label>

                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>

                                <th width="40">
                                    <input
                                        type="checkbox"
                                        id="selectAllTop"
                                    >
                                </th>
                                <th> # </th>

                                <th>Book</th>

                                <th> ISBN </th>
                                <th> Type</th>
                                <th> Condition </th>
                                <th> Stock</th>
                                <th> SKU </th>
                                <th> Status </th>
                            </tr>

                        </thead>


                        <tbody>

                        @forelse($pagination as $key => $item)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="form-check-input sku-checkbox"
                                        value="{{ $item['book_id'] }}"
                                        data-type="{{ $item['type'] }}"
                                        data-variant-id="{{ $item['variant_id'] ?? '' }}"
                                    >

                                </td>

                                <td>

                                    {{ ($pagination->currentPage() - 1)
                                        * $pagination->perPage()
                                        + $key + 1 }}

                                </td>
                                <td>

                                    <strong>
                                        {{ $item['book_name'] ?? '-' }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        Book ID:
                                        {{ $item['book_id'] }}

                                    </small>

                                </td>

                                <td>

                                    {{ $item['isbn'] ?? '-' }}

                                </td>

                                <td>

                                    @if($item['type'] === 'Book')

                                        <span class="badge bg-info">
                                            Book
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Variant
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $item['condition'] ?? '-' }}

                                </td>

                                <td>

                                    {{ $item['stock'] ?? '-' }}

                                </td>

                                <td>

                                    @if(!empty($item['sku']))

                                        <code>
                                            {{ $item['sku'] }}
                                        </code>

                                    @else

                                        <span class="text-muted">
                                            Not Assigned
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-warning text-dark">
                                        Pending SKU
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        <i
                                            class="mdi mdi-barcode-off font-size-30"
                                        ></i>

                                        <br>

                                        No books or variants pending SKU assignment.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $pagination->links('pagination::bootstrap-5') }}

                </div>

            </div>

        </div>

    </div>
</div>

<script>

$(document).ready(function () {



    let selectAllRecords = false;

    $('#selectAll, #selectAllTop').on('change', function () {

        let checked = $(this).is(':checked');

        selectAllRecords = checked;

        $('#selectAll, #selectAllTop')
            .prop('checked', checked);

        $('.sku-checkbox')
            .prop('checked', checked);


        toggleGenerateButton();

    });


    $(document).on('change', '.sku-checkbox', function () {

        selectAllRecords = false;

        let total =
            $('.sku-checkbox').length;

        let checked =
            $('.sku-checkbox:checked').length;

        let allCurrentPageSelected =
            total > 0 && total === checked;


        $('#selectAll, #selectAllTop')
            .prop(
                'checked',
                allCurrentPageSelected
            );


        toggleGenerateButton();

    });
    function toggleGenerateButton()
    {

        let checked =
            $('.sku-checkbox:checked').length;
        let shouldEnable =
            selectAllRecords || checked > 0;


        $('#generateSkuBtn')
            .prop(
                'disabled',
                !shouldEnable
            );

    }
    $('#generateSkuBtn').on('click', function () {

        let selected = [];
        $('.sku-checkbox:checked').each(function () {

            selected.push({

                book_id:
                    $(this).val(),

                type:
                    $(this).data('type'),

                variant_id:
                    $(this).data('variant-id') || null

            });
        });
        if (
            !selectAllRecords &&
            selected.length === 0
        ) {
            toastr.error(
                'Please select at least one item.'
            );

            return;
        }
        let message;
        if (selectAllRecords) {
            message =
                'Are you sure you want to assign SKU to ALL matching pending items?';
        } else {
            message =
                'Are you sure you want to assign SKU to ' +
                selected.length +
                ' selected item(s)?';
        }
        if (!confirm(message)) {
            return;
        }
        let button =
            $(this);
        button
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> Assigning...'
            );

        $.ajax({
            url:
                "{{ route('sku.generate') }}",
            type:
                "POST",
            data: {

                _token:
                    "{{ csrf_token() }}",
                select_all:
                    selectAllRecords ? 1 : 0,
                items:
                    selected,
                    
                search:
                    @json(request('search', '')),

                type:
                    @json(request('type', '')),

                status:
                    @json(request('status', ''))

            },
            dataType:
                "json",
                success:
                function (response) {

                    if (
                        response.status === true
                    ) {

                        toastr.success(
                            response.message ||
                            'SKU assigned successfully.'
                        );


                        setTimeout(
                            function () {

                                window.location.reload();

                            },
                            800
                        );

                    } else {

                        toastr.error(
                            response.message ||
                            'Unable to assign SKU.'
                        );

                    }

                },
                error:
                function (xhr) {

                    let message =
                        'Something went wrong.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    toastr.error(
                        message
                    );

                },
                complete:
                function () {

                    button
                        .prop(
                            'disabled',
                            false
                        )
                        .html(
                            '<i class="mdi mdi-barcode-plus"></i> Generate / Assign SKU'
                        );

                }

        });

    });

});

</script>

@endsection