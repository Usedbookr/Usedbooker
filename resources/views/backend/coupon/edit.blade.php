@extends('admin.admin_master')
@section('admin')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 38px;
    }

    .date-group.disabled-dates {
        opacity: 0.4;
        pointer-events: none;
    }

    .section-divider {
        border-top: 1px dashed #dee2e6;
        margin: 24px 0 20px;
    }

    .section-heading {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 16px;
    }
</style>

@php
$productIds = $edit->product_ids
    ? json_decode($edit->product_ids, true)
    : [];

$authorIds = $edit->author_ids
    ? json_decode($edit->author_ids, true)
    : [];
@endphp

<div class="page-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Edit Coupon</h4>
                <p class="text-muted mb-4">
                    Update coupon details and applicability rules.
                </p>

                <form method="POST"
                    action="{{ route('coupons.update') }}"
                    id="myForm">

                    @csrf

                    <input type="hidden"
                        name="id"
                        value="{{ $edit->id }}">

                    {{-- BASIC INFO --}}
                    <p class="section-heading">
                        Basic Information
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Coupon Name (Internal Purpose) <span class="text-danger">*</span>
                            </label>
                            <input name="coupon_name"
                                class="form-control"
                                type="text"
                                placeholder="Enter Coupon Name"
                                style="letter-spacing:0.1em;" value="{{$edit->coupon_name}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">  
                                Coupon Code
                            </label>

                            <input name="name"
                                class="form-control text-uppercase"
                                type="text"
                                value="{{ $edit->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Discount Type
                            </label>

                            <select class="form-select"
                                name="amounttype"
                                id="amounttype">

                                <option value="A"
                                    {{ $edit->amounttype == 'A' ? 'selected' : '' }}>
                                    Flat (₹ Fixed)
                                </option>

                                <option value="P"
                                    {{ $edit->amounttype == 'P' ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Coupon Value
                            </label>

                            <div class="input-group">
                                <span class="input-group-text"
                                    id="coupon-value-prefix">
                                    {{ $edit->amounttype == 'P' ? '%' : '₹' }}
                                </span>

                                <input name="details"
                                    class="form-control"
                                    type="number"
                                    value="{{ $edit->details }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Min Order Amount
                            </label>

                            <input name="amount"
                                class="form-control"
                                type="number"
                                value="{{ $edit->amount }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Max Order Amount
                            </label>

                            <input name="maxi_discount" class="form-control" type="number" value="{{ $edit->maxi_discount }}">
                            <small class="text-muted">
                                Only applies for Percentage type. Leave 0 for no cap.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Coupon Use Limit
                            </label>

                            <input name="limit_user" class="form-control" type="number" value="{{ $edit->limit_user }}">
                            <small class="text-muted">
                                Total number of times this coupon can be used.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Coupon Limit Per User
                            </label>

                            <input name="coupon_limit_user" class="form-control" type="number" value="{{ $edit->coupon_limit_user }}">
                            <small class="text-muted">
                                Total number of times this coupon can be used per user.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status
                            </label>

                            <select class="form-select"
                                name="status">

                                <option value="1"
                                    {{ $edit->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0"
                                    {{ $edit->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- VALIDITY --}}
                    <div class="section-divider"></div>

                    <p class="section-heading">
                        Validity Period
                    </p>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Duration</label>
                        <div class="col-sm-5">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" {{ $edit->all_time ? 'checked' : '' }} type="checkbox" id="all_time" name="all_time" value="1">
                                <label class="form-check-label" for="all_time">
                                    Apply for all time (no expiry)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="date-group {{ $edit->all_time ? 'disabled-dates' : '' }}" id="dateRange">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Start Date</label>
                            <div class="form-group col-sm-5">
                                <input name="start_date" id="start_date" class="form-control" type="text"
                                    placeholder="Select start date" value="{{ $edit->start_date }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">End Date</label>
                            <div class="form-group col-sm-5">
                                <input name="end_date" id="end_date" class="form-control" type="text"
                                    placeholder="Select end date" value="{{ $edit->end_date }}">
                            </div>
                        </div>
                    </div>

                    {{-- APPLICABILITY --}}
                    <div class="section-divider"></div>

                    <p class="section-heading">
                        Coupon Applicability
                    </p>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Category</label>

                            <select class="form-select"
                                name="category_id">

                                <option value="">
                                    All Categories
                                </option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $edit->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                Leave blank to apply to all categories.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Child Category</label>

                            <select class="form-select"
                                name="childcategory_id">

                                <option value="">
                                    All Child Categories
                                </option>

                                @foreach($child_categories as $child)
                                    <option value="{{ $child->id }}"
                                        {{ $edit->childcategory_id == $child->id ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Specific Products</label>

                            <select class="form-control"
                                name="product_ids[]"
                                id="product_ids"
                                multiple>

                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ in_array($product->id, $productIds ?? []) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                Leave empty to apply coupon to 
                                <strong>all products</strong>.
                            </small>
                        </div>

                        @php
                            $selectedAuthors = json_decode($edit->author_ids, true);
                        
                            if (!is_array($selectedAuthors)) {
                                $selectedAuthors = !empty($edit->author_ids)
                                    ? [$edit->author_ids]
                                    : [];
                            }
                        
                            // Remove extra quotes
                            $selectedAuthors = array_map(function ($author) {
                                return trim(str_replace('"', '', $author));
                            }, $selectedAuthors);
                        @endphp
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Specific Authors</label>
                        
                            <select class="form-control" name="author_ids[]" multiple="multiple"
                                    id="author_ids">
                        
                                <option value="">-- Select Author --</option>
                        
                                @foreach($authors as $author)
                                    <option value="{{ $author }}"
                                        {{ in_array(trim($author), $selectedAuthors) ? 'selected' : '' }}>
                                        {{ $author }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $selectedCondition = json_decode($edit->book_condition_ids, true);
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label>Book Condition</label>

                            <select class="form-control" name="book_condition_ids[]" multiple="multiple" id="book_condition_ids" required>
                                <option value="">Select Condition</option>

                                @foreach($book_conditions as $condition)
                                    <option value="{{ $condition->name }}"
                                        {{ (is_array($selectedCondition) 
                                            ? in_array($condition->name, $selectedCondition) 
                                            : $selectedCondition == $condition->name) ? 'selected' : '' }}>
                                        {{ $condition->name }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="text-muted">
                                Leave empty to apply coupon to
                                <strong>all book conditions</strong>.
                            </small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="mt-4">
                                <input type="checkbox" name="first_time_buyer" id="first_time_buyer" value="1" {{ $edit->first_time_buyer ? 'checked' : '' }}>
                                <label for="first_time_buyer" class="fw-bold text-primary">Only for 1st Time Buyers</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mt-4">
                                <input type="checkbox" name="it_free_ship" id="it_free_ship" value="1" {{ $edit->is_free_shipping ? 'checked' : '' }}>
                                <label for="it_free_ship">Free Shipping</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mt-4">
                                <input type="checkbox" name="it_use_other_coupons" id="it_use_other_coupons" value="1" {{ $edit->is_accept_other_coupons ? 'checked' : '' }}>
                                <label for="it_use_other_coupons">Use with other Coupons</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Description</label>

                            <textarea name="description"
                                class="form-control"
                                rows="3">{{ $edit->description }}</textarea>
                        </div>
                    </div>
                    {{-- SUBMIT --}}
                    <div class="section-divider"></div>

                    <p class="section-heading">
                        Exclusion Products/Categories
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Category</label>

                            <select class="form-select"
                                name="exclusion_category_id">

                                <option value="">
                                    All Categories
                                </option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $edit->exclusion_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Specific Products --}}
                        @php
                            $selectedProducts = json_decode($edit->exclusion_product_ids, true) ?? [];
                        @endphp
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Specific Products</label>
                        
                            <select class="form-control"
                                    name="exclusion_product_ids[]"
                                    id="exclusion_product_ids"
                                    multiple="multiple">
                        
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ in_array((string)$product->id, array_map('strval', $selectedProducts)) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        
                            <small class="text-muted">
                                Leave empty to apply coupon to
                                <strong>all products</strong>.
                            </small>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn btn-info">
                        Update Coupon
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {

    // ── 1. Select2 for Products ──────────────────────────────────────────
    $('#exclusion_product_ids').select2({
        placeholder: 'Search Products',
        width: '100%'
    });
    $('#product_ids').select2({
        placeholder: 'Search and select products...',
        allowClear: true,
        width: '100%',
    });
    $('#author_ids').select2({
        placeholder: 'Search & Select Author',
        allowClear: true,
        width: '100%'
    });
    $('#book_condition_ids').select2({
        placeholder: 'Search & Select Conditions',
        allowClear: true,
        width: '100%'
    });

    // ── 2. Flatpickr date pickers ────────────────────────────────────────
    // Start Date & Time Picker
    const startPicker = flatpickr('#start_date', {
        enableTime: true,
        time_24hr: false, // true = 24hr format
        dateFormat: 'Y-m-d h:i K', // example: 2026-05-18 10:30 AM
        minDate: 'today',
        minuteIncrement: 1,
        defaultHour: 10,
        onChange: function (selectedDates) {
            endPicker.set('minDate', selectedDates[0]);
        }
    });

    // End Date & Time Picker
    const endPicker = flatpickr('#end_date', { 
        enableTime: true,
        time_24hr: false,
        dateFormat: 'Y-m-d h:i K',
        minDate: 'today',
        minuteIncrement: 1,
        defaultHour: 10,
    });

    // ── 3. All-time toggle ───────────────────────────────────────────────
    $('#all_time').on('change', function () {
        const allTime = $(this).is(':checked');
        if (allTime) {
            $('#dateRange').addClass('disabled-dates');
            $('#all-time-badge').show();
            $('#start_date, #end_date').val('');
        } else {
            $('#dateRange').removeClass('disabled-dates');
            $('#all-time-badge').hide();
        }
    });

    // ── 4. Discount type — update prefix ────────────────────────────────
    $('#amounttype').on('change', function () {
        const prefix = $(this).val() === 'P' ? '%' : '₹';
        $('#coupon-value-prefix').text(prefix);
    });

    // ── 5. Category → Subcategory (AJAX) ────────────────────────────────
    $('#category_id').on('change', function () {
        const categoryId = $(this).val();

        // Reset children
        $('#subcategory_id').html('<option value="">— All Subcategories —</option>');
        $('#childcategory_id').html('<option value="">— All Child Categories —</option>');
        $('#subcategory_row, #childcategory_row').hide();

        if (!categoryId) return;

        $.ajax({
            url: '/admin/get-subcategories',   // ← update to your route
            type: 'GET',
            data: { category_id: categoryId },
            success: function (data) {
                if (data.length > 0) {
                    $.each(data, function (i, sub) {
                        $('#subcategory_id').append(
                            $('<option>').val(sub.id).text(sub.subcategory_name)
                        );
                    });
                    $('#subcategory_row').show();
                }
            }
        });
    });

    // ── 7. Validation ────────────────────────────────────────────────────
    $('#myForm').validate({
        rules: {
            name:         { required: true },
            details:      { required: true, min: 0 },
            amount:       { required: true, min: 0 },
            maxi_discount:{ required: true, min: 0 },
            limit_user:   { required: true, min: 1 },
            start_date: {
                required: {
                    depends: function() { return !$('#all_time').is(':checked'); }
                }
            },
            end_date: {
                required: {
                    depends: function() { return !$('#all_time').is(':checked'); }
                }
            },
        },
        messages: {
            name:          { required: 'Please enter a coupon code.' },
            details:       { required: 'Please enter the coupon value.' },
            amount:        { required: 'Please enter the minimum order amount.' },
            maxi_discount: { required: 'Please enter the max discount amount.' },
            limit_user:    { required: 'Please enter the usage limit.' },
            start_date:    { required: 'Please select a start date.' },
            end_date:      { required: 'Please select an end date.' },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
    });

});
</script>

@endsection