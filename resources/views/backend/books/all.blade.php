@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Header & Main Actions -->
            <div class="row align-items-center mb-3">
                <div class="col-md-6 col-12 mb-2 mb-md-0">
                    <h4 class="mb-0 fw-bold">Books</h4>
                </div>

                <div class="col-md-6 col-12 d-flex justify-content-md-end gap-2 flex-wrap">

                    <button type="button" id="approveSelectedQc" class="btn btn-success" style="display:none;">
                        <i class="fas fa-check me-1"></i> Approve Selected QC
                    </button>

                    {{-- BULK FOLDER IMAGE UPLOAD --}}
                    <button type="button" id="bulkImageUploadBtn" class="btn btn-warning text-white">
                        <i class="fas fa-images me-1"></i> Bulk Upload Images
                    </button>

                    <input type="file" id="bulkImageFolderInput" webkitdirectory directory multiple
                        style="display:none;">

                    <a href="{{ route('books.add') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Book
                    </a>

                    <a href="{{ route('books.download.books') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-file-export me-1"></i> Download Books
                    </a>

                </div>
            </div>


            {{-- ============================================================
            ERROR MESSAGE
        ============================================================ --}}

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="mdi mdi-alert-circle me-1"></i>

                    <strong>Import Failed!</strong>

                    <br>

                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>

                </div>
            @endif


            {{-- ============================================================
            IMPORT SUMMARY
        ============================================================ --}}

            @if (session('import_summary'))

                @php
                    $summary = session('import_summary');
                @endphp


                <div class="alert alert-success">

                    <h5 class="mb-3">

                        <i class="mdi mdi-check-circle"></i>

                        Excel Import Completed

                    </h5>


                    <div class="row">

                        <div class="col-md-3">

                            <strong>Total Records</strong>

                            <br>

                            <span class="fs-5">
                                {{ $summary['total'] ?? 0 }}
                            </span>

                        </div>


                        <div class="col-md-3">

                            <strong>Successfully Imported</strong>

                            <br>

                            <span class="text-success fs-5">
                                {{ $summary['successfully_imported'] ?? 0 }}
                            </span>

                        </div>


                        <div class="col-md-3">

                            <strong>Skipped</strong>

                            <br>

                            <span class="text-danger fs-5">
                                {{ $summary['skipped'] ?? 0 }}
                            </span>

                        </div>


                        <div class="col-md-3">

                            <strong>Auto Generated SKU</strong>

                            <br>

                            <span class="text-primary fs-5">
                                {{ $summary['auto_generated_sku'] ?? 0 }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- EXISTING SKU --}}

                @if (!empty($summary['existing_skus']))
                    <div class="alert alert-warning">

                        <h6 class="mb-2">

                            <i class="mdi mdi-alert"></i>

                            Existing SKUs — Skipped

                            <span class="badge bg-warning text-dark">
                                {{ count($summary['existing_skus']) }}
                            </span>

                        </h6>


                        <ul class="mb-0">

                            @foreach ($summary['existing_skus'] as $sku)
                                <li>
                                    <strong>{{ $sku }}</strong>
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                {{-- DUPLICATE SKU --}}

                @if (!empty($summary['duplicate_skus']))
                    <div class="alert alert-warning">

                        <h6 class="mb-2">

                            <i class="mdi mdi-content-duplicate"></i>

                            Duplicate SKUs in Excel — Skipped

                            <span class="badge bg-warning text-dark">
                                {{ count($summary['duplicate_skus']) }}
                            </span>

                        </h6>


                        <ul class="mb-0">

                            @foreach ($summary['duplicate_skus'] as $sku)
                                <li>
                                    <strong>{{ $sku }}</strong>
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                {{-- INVALID SKU --}}

                @if (!empty($summary['invalid_skus']))
                    <div class="alert alert-danger">

                        <h6 class="mb-2">

                            <i class="mdi mdi-close-circle"></i>

                            Invalid SKUs — Skipped

                            <span class="badge bg-danger">
                                {{ count($summary['invalid_skus']) }}
                            </span>

                        </h6>


                        <ul class="mb-0">

                            @foreach ($summary['invalid_skus'] as $sku)
                                <li>
                                    <strong>{{ $sku }}</strong>
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                {{-- OTHER VALIDATION ERRORS --}}

                @if (!empty($summary['errors']))
                    <div class="alert alert-danger">

                        <h6 class="mb-3">

                            <i class="mdi mdi-alert-circle"></i>

                            Other Validation Issues

                        </h6>


                        <div class="table-responsive">

                            <table class="table table-sm table-bordered table-hover mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th>Excel Row</th>
                                        <th>SKU</th>
                                        <th>Reason</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach ($summary['errors'] as $error)
                                        <tr>

                                            <td>
                                                {{ $error['row'] ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $error['sku'] ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $error['reason'] ?? '-' }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                @endif


                {{-- AUTO GENERATED SKU MESSAGE --}}

                @if (($summary['auto_generated_sku'] ?? 0) > 0)
                    <div class="alert alert-info">

                        <i class="mdi mdi-information"></i>

                        <strong>
                            {{ $summary['auto_generated_sku'] }}
                        </strong>

                        SKU(s) were automatically generated because SKU was empty
                        in the Excel file.

                    </div>
                @endif

            @endif


            <!-- Main Card -->
            <div class="card shadow-sm border-0">

                <div class="card-body">


                    <!-- =====================================================
                             TOOLBAR
                        ====================================================== -->

                    <div class="row g-3 align-items-end mb-4">


                        <!-- CATEGORY EXPORT -->

                        <div class="col-xl-4 col-md-6">

                            <label class="form-label text-muted small fw-semibold">
                                Export Options
                            </label>

                            <div class="input-group">

                                <select name="select_download" id="select_download" class="form-select"
                                    onchange="ExcelDownload()">

                                    <option value="">
                                        Select Export Category
                                    </option>

                                    <option value="Category">
                                        Category
                                    </option>

                                    <option value="SubCategory">
                                        Sub Category
                                    </option>

                                    <option value="ChildCategory">
                                        Child Category
                                    </option>

                                    <option value="Language">
                                        Language
                                    </option>

                                </select>


                                <a href="javascript:void(0)" id="image_url" class="btn btn-warning text-white">

                                    <i class="fas fa-download me-1"></i>
                                    Download

                                </a>

                            </div>

                        </div>


                        <!-- BULK EXCEL UPLOAD -->

                        <div class="col-xl-4 col-md-6">

                            <form action="{{ route('admin.book.multiple.upload') }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="d-flex justify-content-between align-items-center">

                                    <label class="form-label text-muted small fw-semibold mb-1">
                                        Bulk Excel Upload
                                    </label>


                                    <a href="{{ url('/') }}/public/assets/images/sample_file.xlsx" download
                                        class="small text-decoration-none text-primary fw-medium">

                                        <i class="fas fa-download me-1"></i>
                                        Sample File

                                    </a>

                                </div>


                                <div class="input-group">

                                    <input type="file" class="form-control" name="excel_file">

                                    <input type="submit" name="row_check" value="Upload" class="btn btn-success">

                                </div>

                            </form>

                        </div>


                        <!-- STATUS FILTER -->

                        <div class="col-xl-2 col-md-6">

                            <label class="form-label text-muted small fw-semibold">
                                Filter Status
                            </label>

                            <select name="status" id="statusFilter" class="form-select">

                                <option value="">
                                    All Status
                                </option>

                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>
                                    QC Pending
                                </option>

                            </select>

                        </div>


                        <!-- SEARCH -->

                        <div class="col-xl-2 col-md-6">

                            <label class="form-label text-muted small fw-semibold">
                                Search
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light text-muted border-end-0">

                                    <i class="fas fa-search"></i>

                                </span>


                                <input type="text" name="text_value_search" id="text_value_search"
                                    class="form-control border-start-0" onkeyup="text_value_search()"
                                    placeholder="Search books...">

                            </div>

                        </div>

                    </div>


                    <hr class="text-muted opacity-25 my-3">


                    <!-- =====================================================
                             BOOK TABLE CONTAINER
                        ====================================================== -->

                    <div id="booksTableContainer">

                        <div class="table-responsive" id="example">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th style="width: 40px;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="selectAllQc">
                                        </th>

                                        <th style="width: 50px;">
                                            Sl
                                        </th>

                                        <th>
                                            Book Id
                                        </th>

                                        <th>
                                            Name
                                        </th>

                                        <th>
                                            Child Category
                                        </th>

                                        <th>
                                            Listed By
                                        </th>

                                        <th>
                                            Added Date
                                        </th>

                                        <th>
                                            Last Update
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th class="text-center" style="width: 140px;">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($books as $key => $item)
                                        <tr>

                                            <!-- CHECKBOX -->

                                            <td class="text-center">

                                                @if ($item->status == 2)
                                                    <input type="checkbox" class="form-check-input qc-checkbox"
                                                        value="{{ $item->id }}">
                                                @endif

                                            </td>


                                            <!-- SL -->

                                            <td class="fw-semibold text-muted">

                                                {{ $books->firstItem() + $key }}

                                            </td>


                                            <!-- BOOK ID -->

                                            <td>

                                                <span class="badge bg-light text-dark border fw-normal fs-6">

                                                    {{ $item->book_id }}

                                                </span>

                                            </td>


                                            <!-- NAME -->

                                            <td class="fw-bold text-dark">

                                                {{ $item->name }}

                                            </td>


                                            <!-- CATEGORY -->

                                            <td>

                                                <span class="text-secondary">

                                                    {{ $item->category->name ?? '-' }}

                                                </span>

                                            </td>


                                            <!-- LISTED BY -->

                                            <td>

                                                <span class="badge bg-soft-info text-info">

                                                    {{ $item->listed_by }}

                                                </span>

                                            </td>


                                            <!-- ADDED DATE -->

                                            <td class="small text-muted">

                                                {{ date('d-m-Y h:i a', strtotime($item->created_at)) }}

                                            </td>


                                            <!-- LAST UPDATE -->

                                            <td class="small text-muted">

                                                {{ date('d-m-Y h:i a', strtotime($item->updated_at)) }}

                                            </td>


                                            <!-- STATUS -->

                                            <td>

                                                @if ($item->status == 1)
                                                    <span class="badge px-3 py-2 fw-semibold text-white"
                                                        style="background-color: #198754;">

                                                        <i class="fas fa-check-circle me-1"></i>

                                                        Active

                                                    </span>
                                                @elseif($item->status == 0)
                                                    <span class="badge px-3 py-2 fw-semibold text-white"
                                                        style="background-color: #dc3545;">

                                                        <i class="fas fa-times-circle me-1"></i>

                                                        Inactive

                                                    </span>
                                                @elseif($item->status == 2)
                                                    <span class="badge px-3 py-2 fw-semibold text-white"
                                                        style="background-color: #d97706;">

                                                        <i class="fas fa-clock me-1"></i>

                                                        QC Pending

                                                    </span>
                                                @else
                                                    <span class="badge px-3 py-2 fw-semibold text-white"
                                                        style="background-color: #6c757d;">

                                                        Unknown

                                                    </span>
                                                @endif

                                            </td>


                                            <!-- ACTION -->

                                            <td class="text-center">

                                                <div class="d-inline-flex gap-1">

                                                    @if ($item->status == 2)
                                                        <a href="{{ route('books.qc.edit', $item->id) }}"
                                                            class="btn btn-sm btn-outline-success approve-qc-btn"
                                                            title="QC Approve">

                                                            <i class="fas fa-check"></i>

                                                        </a>
                                                    @endif


                                                    @if ($item->status != 2)
                                                        <a href="{{ route('books.edit', $item->id) }}"
                                                            class="btn btn-sm btn-outline-info" title="Edit Data">

                                                            <i class="fas fa-edit"></i>

                                                        </a>
                                                    @endif


                                                    <a href="{{ route('books.delete', $item->id) }}"
                                                        data-confirm="Are you sure you want to delete this book?"
                                                        class="delete btn btn-sm btn-outline-danger" title="Delete Data">

                                                        <i class="fas fa-trash-alt"></i>

                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-warning single-book-upload-btn" 
                                                            data-book-id="{{ $item->id }}" 
                                                            data-book-code="{{ $item->book_id }}"
                                                            title="Upload Folder for this Book">
                                                            <i class="fas fa-folder-plus"></i>
                                                    </button>
                                                    

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="10" class="text-center py-4 text-muted">

                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>

                                                No books found.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>
                            <input type="file" id="singleBookFolderInput" webkitdirectory directory multiple style="display:none;" data-selected-book-id="" data-selected-book-code="">

                            <!-- PAGINATION -->

                            <div class="d-flex justify-content-between align-items-center mt-3" id="seach_hide">

                                <div class="small text-muted">

                                    Showing
                                    {{ $books->firstItem() ?? 0 }}

                                    to
                                    {{ $books->lastItem() ?? 0 }}

                                    of
                                    {{ $books->total() ?? 0 }}

                                    entries

                                </div>


                                <div>

                                    {!! $books->withQueryString()->links('pagination::bootstrap-5') !!}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <?php
    $current_route = Route::currentRouteName();
    ?>


    <script type="text/javascript">
        /*
            |--------------------------------------------------------------------------
            | DELETE CONFIRMATION
            |--------------------------------------------------------------------------
            */

        var deleteLinks = document.querySelectorAll('.delete');

        for (var i = 0; i < deleteLinks.length; i++) {

            deleteLinks[i].addEventListener('click', function(event) {

                event.preventDefault();

                var choice = confirm(
                    this.getAttribute('data-confirm')
                );

                if (choice) {

                    window.location.href =
                        this.getAttribute('href');

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | EXISTING SEARCH
        |--------------------------------------------------------------------------
        */

        function text_value_search() {

            var text_value_search =
                $("#text_value_search").val();

            if (text_value_search) {

                $.ajax({

                    url: "{{ route('admin.book.search') }}",

                    type: "POST",

                    data: {

                        text_value_search: text_value_search,

                        _token: '{{ csrf_token() }}'

                    },

                    success: function(response) {

                        if (response.status) {

                            $("#example").html(
                                response.project
                            );

                            $("#seach_hide").hide();

                        }

                    }

                });

            }

        }


        /*
        |--------------------------------------------------------------------------
        | EXCEL DOWNLOAD
        |--------------------------------------------------------------------------
        */

        function ExcelDownload() {

            var select_download =
                $("#select_download").val();

            var expert_search_url1 =
                "{{ url('/') }}/admin/book-categories/" +
                select_download;

            if (expert_search_url1) {

                $('#image_url').attr(
                    'href',
                    expert_search_url1
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER - AJAX
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'change',
            '#statusFilter',
            function() {

                var status =
                    $(this).val();

                var search =
                    $('#text_value_search').val();


                $.ajax({

                    url: "{{ route('books.all') }}",

                    type: "GET",

                    data: {

                        status: status,

                        search: search

                    },


                    beforeSend: function() {

                        $('#booksTableContainer').css({

                            'opacity': '0.5',

                            'pointer-events': 'none'

                        });

                    },


                    success: function(response) {

                        /*
                         * Full page response-ல இருந்து
                         * table container மட்டும் எடுத்துக்கொள்கிறோம்.
                         */

                        var html =
                            $('<div>')
                            .html(response)
                            .find('#booksTableContainer')
                            .html();


                        if (html) {

                            $('#booksTableContainer')
                                .html(html);

                        } else {

                            console.error(
                                'Books table container not found.'
                            );

                        }


                        /*
                         * URL update
                         */

                        var newUrl =
                            "{{ route('books.all') }}";

                        var params = new URLSearchParams();


                        if (status !== '') {

                            params.set(
                                'status',
                                status
                            );

                        }


                        if (search !== '') {

                            params.set(
                                'search',
                                search
                            );

                        }


                        if (params.toString() !== '') {

                            newUrl += '?' +
                                params.toString();

                        }


                        window.history.pushState({},
                            '',
                            newUrl
                        );


                        /*
                         * QC button state update
                         */

                        toggleQcApproveButton();

                    },


                    error: function(xhr) {

                        console.log(
                            xhr.responseText
                        );

                        alert(
                            'Unable to filter books.'
                        );

                    },


                    complete: function() {

                        $('#booksTableContainer').css({

                            'opacity': '1',

                            'pointer-events': 'auto'

                        });

                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | BULK QC APPROVAL LOGIC
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'change',
            '#selectAllQc',
            function() {

                let checked =
                    $(this).is(':checked');

                $('.qc-checkbox').prop(
                    'checked',
                    checked
                );

                toggleQcApproveButton();

            });


        $(document).on(
            'change',
            '.qc-checkbox',
            function() {

                toggleQcApproveButton();

                let total =
                    $('.qc-checkbox').length;

                let checked =
                    $('.qc-checkbox:checked').length;

                $('#selectAllQc').prop(
                    'checked',
                    total > 0 &&
                    total === checked
                );

            });


        function toggleQcApproveButton() {

            let checked =
                $('.qc-checkbox:checked').length;

            if (checked > 0) {

                $('#approveSelectedQc').show();

            } else {

                $('#approveSelectedQc').hide();

            }

        }


        $('#approveSelectedQc').on(
            'click',
            function() {

                let ids = [];

                $('.qc-checkbox:checked').each(
                    function() {

                        ids.push(
                            $(this).val()
                        );

                    });


                if (ids.length === 0) {

                    alert(
                        'Please select at least one QC Pending book.'
                    );

                    return;

                }


                let choice = confirm(
                    'Are you sure you want to approve ' +
                    ids.length +
                    ' selected book(s)?'
                );


                if (!choice) {

                    return;

                }


                $.ajax({

                    url: "{{ route('books.qc.approve.selected') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        select_all: false,

                        ids: ids

                    },


                    beforeSend: function() {

                        $('#approveSelectedQc')
                            .prop(
                                'disabled',
                                true
                            )
                            .html(
                                '<i class="fas fa-spinner fa-spin"></i> Approving...'
                            );

                    },


                    success: function(response) {

                        if (response.status) {

                            alert(
                                response.message
                            );

                            location.reload();

                        }

                    },


                    error: function(xhr) {

                        let message =
                            'Unable to approve books.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }

                        alert(message);


                        $('#approveSelectedQc')
                            .prop(
                                'disabled',
                                false
                            )
                            .html(
                                '<i class="fas fa-check"></i> Approve Selected QC'
                            );

                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | SINGLE QC APPROVAL
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.approve-qc',
            function() {

                let button =
                    $(this);

                let bookId =
                    button.data('id');


                let choice = confirm(
                    'Are you sure you want to approve this book?'
                );


                if (!choice) {

                    return;

                }


                $.ajax({

                    url: "{{ route('books.qc.approve') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        id: bookId

                    },


                    beforeSend: function() {

                        button
                            .prop(
                                'disabled',
                                true
                            )
                            .html(
                                '<i class="fas fa-spinner fa-spin"></i>'
                            );

                    },


                    success: function(response) {

                        if (response.status) {

                            alert(
                                response.message
                            );

                            location.reload();

                        }

                    },


                    error: function(xhr) {

                        let message =
                            'Unable to approve book.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }

                        alert(message);


                        button
                            .prop(
                                'disabled',
                                false
                            )
                            .html(
                                '<i class="fas fa-check"></i>'
                            );

                    }

                });

            });

        /*
        |--------------------------------------------------------------------------
        | BULK FOLDER IMAGE UPLOAD SCRIPT
        |--------------------------------------------------------------------------
        */

        $(document).ready(function() {

            // Trigger Hidden Folder Input Click
            $('#bulkImageUploadBtn').on('click', function() {
                $('#bulkImageFolderInput').click();
            });

            // Handle Folder Selection
            $(document).on('change', '#bulkImageFolderInput', function() {

                let files = this.files;

                if (!files || files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Folder Selected',
                        text: 'Please select a folder containing SKU images.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                let formData = new FormData();
                let totalImages = 0;

                for (let i = 0; i < files.length; i++) {
                    let file = files[i];

                    /*
                    |--------------------------------------------------------------------------
                    | Process Only Image Files
                    |--------------------------------------------------------------------------
                    */
                    if (!file.type || !file.type.startsWith('image/')) {
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Extract Relative Path (preserves folder hierarchy: Parent/SKU/image.jpg)
                    |--------------------------------------------------------------------------
                    */
                    let relativePath = file.webkitRelativePath || file.name;

                    formData.append('images[]', file);
                    formData.append('relative_paths[]', relativePath);

                    totalImages++;
                }

                if (totalImages === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Images Found',
                        text: 'The selected folder does not contain any valid image files.',
                        confirmButtonText: 'OK'
                    });
                    $('#bulkImageFolderInput').val('');
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Append CSRF Token
                |--------------------------------------------------------------------------
                */
                formData.append('_token', '{{ csrf_token() }}');

                /*
                |--------------------------------------------------------------------------
                | Confirmation Dialog Before Upload
                |--------------------------------------------------------------------------
                */
                Swal.fire({
                    title: 'Upload Images?',
                    text: totalImages +
                        ' image(s) found in selected folder(s). Do you want to process and upload them?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Upload',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {

                    if (!result.isConfirmed) {
                        $('#bulkImageFolderInput').val('');
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | AJAX Upload
                    |--------------------------------------------------------------------------
                    */
                    $.ajax({
                        url: "{{ route('books.bulk.images.upload') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,

                        beforeSend: function() {
                            Swal.fire({
                                title: 'Uploading Images...',
                                html: 'Processing <strong>' + totalImages +
                                    '</strong> image(s).<br><small class="text-muted">Matching SKUs and saving to storage...</small>',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: function() {
                                    Swal.showLoading();
                                }
                            });

                            $('#bulkImageUploadBtn')
                                .prop('disabled', true)
                                .html(
                                    '<i class="fas fa-spinner fa-spin me-1"></i> Uploading...'
                                    );
                        },

                        /*
                        |--------------------------------------------------------------------------
                        | SUCCESS RESPONSE
                        |--------------------------------------------------------------------------
                        */
                        success: function(response) {
                            console.log('Bulk Upload Response:', response);

                            if (response.status) {
                                let uploaded = response.uploaded || 0;
                                let skipped = response.skipped || 0;
                                let unmatched = response.unmatched_skus || [];
                                let errors = response.errors || [];

                                let html =
                                    '<div class="text-start" style="max-height: 350px; overflow-y: auto;">';

                                html +=
                                    '<div class="d-flex justify-content-between mb-2 p-2 bg-light rounded border">';
                                html +=
                                    '<span><i class="fas fa-check-circle text-success me-1"></i> <strong>Uploaded:</strong> ' +
                                    uploaded + '</span>';
                                html +=
                                    '<span><i class="fas fa-times-circle text-danger me-1"></i> <strong>Skipped:</strong> ' +
                                    skipped + '</span>';
                                html += '</div>';

                                /*
                                |--------------------------------------------------------------------------
                                | Display Unmatched SKUs / Paths
                                |--------------------------------------------------------------------------
                                */
                                if (unmatched.length > 0) {
                                    html += '<hr class="my-2">';
                                    html +=
                                        '<strong class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i> Unmatched SKU / Paths (' +
                                        unmatched.length + '):</strong>';
                                    html +=
                                        '<div class="mt-1 p-2 bg-light rounded border text-monospace small" style="max-height: 100px; overflow-y: auto;">';
                                    unmatched.forEach(function(sku) {
                                        html += '<div class="text-danger">• ' +
                                            sku + '</div>';
                                    });
                                    html += '</div>';
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Display Specific File Errors
                                |--------------------------------------------------------------------------
                                */
                                if (errors.length > 0) {
                                    html += '<hr class="my-2">';
                                    html +=
                                        '<strong class="text-danger"><i class="fas fa-info-circle me-1"></i> Detailed Error Log:</strong>';
                                    html +=
                                        '<div class="mt-1 p-2 bg-light rounded border small" style="max-height: 120px; overflow-y: auto;">';

                                    errors.slice(0, 15).forEach(function(err) {
                                        html +=
                                            '<div class="mb-1 pb-1 border-bottom">';
                                        html +=
                                            '<div class="fw-bold text-dark">' +
                                            (err.file || 'Unknown file') +
                                            '</div>';
                                        html += '<div class="text-danger">' + (
                                                err.reason || 'Unknown error') +
                                            '</div>';
                                        html += '</div>';
                                    });

                                    if (errors.length > 15) {
                                        html +=
                                            '<div class="text-muted text-center pt-1"><small>+' +
                                            (errors.length - 15) +
                                            ' more error(s)</small></div>';
                                    }
                                    html += '</div>';
                                }

                                html += '</div>';

                                Swal.fire({
                                    icon: uploaded > 0 ? 'success' : 'warning',
                                    title: uploaded > 0 ? 'Upload Completed' :
                                        'No Images Uploaded',
                                    html: html,
                                    confirmButtonText: 'OK',
                                    width: 600
                                }).then(function() {
                                    if (uploaded > 0) {
                                        location.reload();
                                    }
                                });

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Upload Failed',
                                    text: response.message ||
                                        'Unable to upload images.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },

                        /*
                        |--------------------------------------------------------------------------
                        | ERROR RESPONSE (Server/Validation Issues)
                        |--------------------------------------------------------------------------
                        */
                        error: function(xhr) {
                            console.log('HTTP STATUS:', xhr.status);
                            console.log('RESPONSE:', xhr.responseText);

                            let message = 'Unable to upload images.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Error',
                                html: '<div class="text-start"><p>' + message +
                                    '</p><small class="text-muted">HTTP Status: ' +
                                    xhr.status + '</small></div>',
                                confirmButtonText: 'OK'
                            });
                        },

                        /*
                        |--------------------------------------------------------------------------
                        | ALWAYS EXECUTED (Reset State)
                        |--------------------------------------------------------------------------
                        */
                        complete: function() {
                            $('#bulkImageUploadBtn')
                                .prop('disabled', false)
                                .html(
                                    '<i class="fas fa-images me-1"></i> Bulk Upload Images'
                                    );

                            $('#bulkImageFolderInput').val('');
                        }
                    });
                });
            });
        });
        $(document).ready(function() {

    // Dynamic Action Click Trigger
    $(document).on('click', '.single-book-upload-btn', function() {
        let bookId = $(this).data('book-id');
        let bookCode = $(this).data('book-code');

        let $folderInput = $('#singleBookFolderInput');
        $folderInput.data('selected-book-id', bookId);
        $folderInput.data('selected-book-code', bookCode);
        $folderInput.val('');
        $folderInput.click();
    });

    // Dedicated Handler for Single Book Action Upload
    $(document).on('change', '#singleBookFolderInput', function() {

        let files = this.files;
        let bookId = $(this).data('selected-book-id');
        let bookCode = $(this).data('selected-book-code');

        if (!files || files.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Folder Selected',
                text: 'Please select an image folder for Book Code: ' + bookCode,
                confirmButtonText: 'OK'
            });
            return;
        }

        let formData = new FormData();
        let totalImages = 0;

        for (let i = 0; i < files.length; i++) {
            let file = files[i];

            if (!file.type || !file.type.startsWith('image/')) {
                continue;
            }

            let relativePath = file.webkitRelativePath || file.name;
            formData.append('images[]', file);
            formData.append('relative_paths[]', relativePath);
            totalImages++;
        }

        if (totalImages === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Images Found',
                text: 'The selected folder does not contain any valid image files.',
                confirmButtonText: 'OK'
            });
            return;
        }

        formData.append('book_id', bookId);
        formData.append('_token', '{{ csrf_token() }}');

        Swal.fire({
            title: 'Upload Images?',
            text: totalImages + ' image(s) selected for Book: ' + bookCode + '. Do you want to process?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Upload',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('books.single.bulk.images.upload') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    Swal.fire({
                        title: 'Uploading Images...',
                        html: 'Processing <strong>' + totalImages + '</strong> image(s) for Book Code: <strong>' + bookCode + '</strong>...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                },

                success: function(response) {
                    if (response.status) {
                        let uploaded = response.uploaded || 0;
                        let skipped = response.skipped || 0;
                        let errors = response.errors || [];

                        let html = '<div class="text-start" style="max-height: 350px; overflow-y: auto;">';
                        html += '<div class="d-flex justify-content-between mb-2 p-2 bg-light rounded border">';
                        html += '<span><i class="fas fa-check-circle text-success me-1"></i> <strong>Uploaded:</strong> ' + uploaded + '</span>';
                        html += '<span><i class="fas fa-times-circle text-danger me-1"></i> <strong>Skipped:</strong> ' + skipped + '</span>';
                        html += '</div>';

                        if (errors.length > 0) {
                            html += '<hr class="my-2"><strong class="text-danger"><i class="fas fa-info-circle me-1"></i> Details:</strong>';
                            html += '<div class="mt-1 p-2 bg-light rounded border small" style="max-height: 150px; overflow-y: auto;">';
                            errors.forEach(function(err) {
                                html += '<div class="mb-1 pb-1 border-bottom">';
                                html += '<div class="fw-bold text-dark">' + (err.file || 'Unknown file') + '</div>';
                                html += '<div class="text-danger">' + (err.reason || 'Error') + '</div>';
                                html += '</div>';
                            });
                            html += '</div>';
                        }
                        html += '</div>';

                        Swal.fire({
                            icon: uploaded > 0 ? 'success' : 'warning',
                            title: uploaded > 0 ? 'Upload Complete' : 'Process Completed with Warnings',
                            html: html,
                            confirmButtonText: 'OK',
                            width: 600
                        }).then(function() {
                            if (uploaded > 0) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: response.message || 'Unable to upload images.',
                            confirmButtonText: 'OK'
                        });
                    }
                },

                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Upload failed due to server error.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
});
    </script>

@endsection
