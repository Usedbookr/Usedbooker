@extends('admin.admin_master')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body"><h4 class="card-title">
                            Add Books
                        </h4>

                        <br>
                        <br>
                        <form
                            method="post"
                            action="{{ route('books.store') }}"
                            id="myForm"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="row mb-3">

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Listed By
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div
                                            class="form-group col-sm-9"
                                            style="padding:12px 0px 0px;">

                                            <input
                                                name="listed_by"
                                                value="A"
                                                type="radio"
                                                required
                                            >
                                            <span>A&nbsp;&nbsp;</span>

                                            <input
                                                name="listed_by"
                                                value="B"
                                                type="radio"
                                                required
                                            >
                                            <span>B&nbsp;&nbsp;</span>

                                            <input
                                                name="listed_by"
                                                value="C"
                                                type="radio"
                                                required
                                            >
                                            <span>C&nbsp;&nbsp;</span>

                                            <input
                                                name="listed_by"
                                                value="D"
                                                type="radio"
                                                required
                                            >
                                            <span>D&nbsp;&nbsp;</span>

                                            <input
                                                name="listed_by"
                                                value="E"
                                                type="radio"
                                                required
                                            >
                                            <span>E&nbsp;&nbsp;</span>

                                            <input
                                                name="listed_by"
                                                value="F"
                                                type="radio"
                                                required
                                            >
                                            <span>F</span>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="row mb-3">


                                {{-- TITLE --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Title
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="name"
                                                class="form-control"
                                                type="text"
                                                id="cat_id_name"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Author
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="author"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>
                                {{-- THUMBNAIL --}}
                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Outer Cover Image
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                class="form-control"
                                                type="file"
                                                id="file"
                                                name="thumbnail_image"
                                                accept="image/jpeg,image/jpg,image/png,image/webp"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>
                                {{-- MRP --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            MRP
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="original_price"
                                                class="form-control"
                                                type="text"
                                                id="original_price"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- SELLING PRICE --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Selling Price
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="selling_price"
                                                class="form-control"
                                                type="text"
                                                id="selling_price"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- DISCOUNT --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Discount (%)
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="discount"
                                                class="form-control"
                                                type="text"
                                                id="discount"
                                                readonly
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- ISBN13 --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            ISBN13
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="isbn13"
                                                class="form-control"
                                                type="text"
                                                id="isbn13"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- DESCRIPTION --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Description
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="title_long"
                                                class="form-control"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- SECTION --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Section
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="section_id[]"
                                                value="N"
                                                type="checkbox"
                                            >
                                            New Arrival&nbsp;&nbsp;
                                            <input
                                                name="section_id[]"
                                                value="B"
                                                type="checkbox"
                                            >
                                            Best Seller
                                        </div>
                                    </div>
                                </div>
                                {{-- PUBLISHER --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Publisher
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="publisher"
                                                class="form-control"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- DATE PUBLISHED --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Date Published
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="date_published"
                                                class="form-control"
                                                type="date"
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- PAGES --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Pages
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="pages"
                                                class="form-control"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- DIMENSIONS --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Dimensions
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <input
                                                name="dimensions"
                                                class="form-control"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                </div>
                                {{-- FORMAT --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Format
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <select
                                                class="form-control"
                                                name="format"
                                                id="format">

                                                <option value="">
                                                    Select Format
                                                </option>

                                                <option value="Paperback">
                                                    Paperback
                                                </option>

                                                <option value="Hardcover">
                                                    Hardcover
                                                </option>

                                                <option value="Board Book">
                                                    Board Book
                                                </option>

                                                <option value="Mass Market Paperback">
                                                    Mass Market Paperback
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>
                                {{-- LANGUAGE --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Language
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <select
                                                class="form-control"
                                                name="language"
                                                id="language-dropdown"
                                                required>
                                                <option value="">
                                                    Select language
                                                </option>
                                                @if($languages)
                                                    @foreach($languages as $language)
                                                        <option value="{{ $language->name }}">
                                                            {{ $language->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- CATEGORY --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Category
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <select
                                                class="form-control"
                                                name="category"
                                                id="category-dropdown"
                                                required>
                                                <option value="">
                                                    Select category
                                                </option>
                                                @if($categories)
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- SUB CATEGORY --}}
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">
                                            Sub Category
                                            <span style="color:red;">*</span>
                                        </label>
                                        <div class="form-group col-sm-9">
                                            <select
                                                class="form-control"
                                                id="subcategory-dropdown"
                                                name="subcategory"
                                                required>

                                                <option value="">
                                                    -- Select Sub Category --
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                {{-- CHILD CATEGORY --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Child Category
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <select
                                                class="form-control"
                                                id="childcategory-dropdown"
                                                name="childcategory"
                                                required>

                                                <option value="">
                                                    -- Select Child Category --
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                {{-- HSN CODE --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            HSN Code
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="hsn_code"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- GST --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            GST Charge
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <select
                                                class="form-control"
                                                name="gst_charge">

                                                <option value="0" selected>
                                                    Without GST
                                                </option>

                                                <option value="5">
                                                    5%
                                                </option>

                                                <option value="12">
                                                    12%
                                                </option>

                                                <option value="18">
                                                    18%
                                                </option>

                                                <option value="28">
                                                    28%
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                {{-- SYNOPSIS --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Synopsis
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="synopsis"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- STATUS --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Status
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <select
                                                class="form-select"
                                                name="status"
                                                required>

                                                <option value="1" selected>
                                                    Active
                                                </option>

                                                <option value="0">
                                                    InActive
                                                </option>
                                                 <option value="2">
                                                    Qc Pending
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                {{-- META NAME --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Meta Name
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="meta_name"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- URL SLUG --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Book URL
                                            <span style="color:red;">*</span>
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="url_slug"
                                                class="form-control"
                                                type="text"
                                                id="url_slug"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- META DESCRIPTION --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Meta Description
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="meta_description"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{-- META KEYWORD --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">
                                            Meta Keyword
                                        </label>

                                        <div class="form-group col-sm-9">

                                            <input
                                                name="meta_keyword"
                                                class="form-control"
                                                type="text"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ========================================================
                                 ATTRIBUTE LIST
                            ========================================================= --}}

                            <h4 class="text-success">
                                Attribute List
                            </h4>

                            <div
                                class="col-12 text-center"
                                id="dynamicTable">

                                {{-- FIRST INVENTORY ROW --}}

                                <div class="row mb-3 inventory-row">


                                    {{-- CONDITION --}}

                                    <div class="col-md-2">

                                        <select
                                            class="form-select bookconditions"
                                            name="addmore[0][condition]"
                                            required>

                                            <option value="">
                                                Book Conditions
                                            </option>

                                            @foreach($condition_types as $condition)

                                                <option value="{{ $condition->name }}">
                                                    {{ $condition->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- IMAGES --}}

                                    <div class="col-md-2">

                                        <input
                                            type="file"
                                            name="addmore[0][images][]"
                                            class="form-control"
                                            accept="image/jpeg,image/jpg,image/png,image/webp"
                                            multiple>

                                    </div>


                                    {{-- PRICE --}}

                                    <div class="col-md-1">

                                        <input
                                            type="text"
                                            name="addmore[0][price]"
                                            placeholder="Price"
                                            class="form-control"
                                            required>

                                    </div>


                                    {{-- STOCK --}}

                                    <div class="col-md-2">

                                        <input
                                            type="text"
                                            name="addmore[0][stock]"
                                            placeholder="Stock"
                                            class="form-control"
                                            required>

                                    </div>


                                    {{-- WEIGHT --}}

                                    <div class="col-md-2">

                                        <input
                                            type="text"
                                            name="addmore[0][book_weight]"
                                            placeholder="Weight (gram)"
                                            class="form-control">

                                    </div>


                                    {{-- SKU --}}

                                    <div class="col-md-2">

                                        <input
                                            type="text"
                                            name="addmore[0][sku_number]"
                                            id="sku_number_0"
                                            placeholder="SKU Number"
                                            class="form-control sku-input"
                                            readonly
                                            required>

                                    </div>


                                    {{-- ADD --}}

                                    <div class="col-md-1">

                                        <a
                                            href="javascript:void(0)"
                                            id="add"
                                            title="Add More">

                                            <i class="btn btn-success mdi mdi-plus"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>


                            {{-- ========================================================
                                 SUBMIT BUTTON
                            ========================================================= --}}

                            <div class="mt-3">

                                <button
                                    type="submit"
                                    id="submitBtn"
                                    class="btn btn-info waves-effect waves-light">

                                    <span id="submitText">
                                        Add
                                    </span>

                                    <span
                                        id="submitLoader"
                                        style="display:none;">

                                        <i class="fa fa-spinner fa-spin"></i>
                                        Saving...

                                    </span>

                                </button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


{{-- ================================================================
     STYLES
================================================================ --}}

<style>

.sku-input {

    background-color: #f5f5f5 !important;

    cursor: not-allowed;

    font-weight: 600;

    color: #333;

}

.dynamicrow {

    margin-bottom: 15px;

}

.ajax-error {

    display: block;

    width: 100%;

}

#submitBtn {

    min-width: 100px;

}

</style>


{{-- ================================================================
     JQUERY VALIDATION
================================================================ --}}

<script>

$(document).ready(function () {

    $('#myForm').validate({

        rules: {

            listed_by: {
                required: true
            },

            name: {
                required: true
            },

            thumbnail_image: {
                required: true
            },

            original_price: {
                required: true,
                number: true,
                min: 0
            },

            selling_price: {
                required: true,
                number: true,
                min: 0
            },

            isbn13: {
                required: true
            },

            language: {
                required: true
            },

            category: {
                required: true
            },

            subcategory: {
                required: true
            },

            childcategory: {
                required: true
            },

            url_slug: {
                required: true
            },

            'addmore[0][condition]': {
                required: true
            },

            'addmore[0][price]': {
                required: true,
                number: true,
                min: 0
            },

            'addmore[0][stock]': {
                required: true,
                number: true,
                min: 1
            },

            'addmore[0][sku_number]': {
                required: true
            }

        },

        messages: {

            listed_by: {
                required: 'Please select Listed By.'
            },

            name: {
                required: 'Please enter book title.'
            },

            thumbnail_image: {
                required: 'Please upload outer cover image.'
            },

            original_price: {
                required: 'Please enter MRP.',
                number: 'Please enter valid MRP.'
            },

            selling_price: {
                required: 'Please enter selling price.',
                number: 'Please enter valid selling price.'
            },

            isbn13: {
                required: 'Please enter ISBN13.'
            },

            language: {
                required: 'Please select language.'
            },

            category: {
                required: 'Please select category.'
            },

            subcategory: {
                required: 'Please select sub category.'
            },

            childcategory: {
                required: 'Please select child category.'
            },

            url_slug: {
                required: 'Book URL is required.'
            },

            'addmore[0][condition]': {
                required: 'Please select book condition.'
            },

            'addmore[0][price]': {
                required: 'Please enter inventory price.'
            },

            'addmore[0][stock]': {
                required: 'Please enter stock.'
            },

            'addmore[0][sku_number]': {
                required: 'SKU is required.'
            }

        },

        errorElement: 'span',

        errorPlacement: function (error, element) {

            error.addClass('invalid-feedback');

            if (element.closest('.form-group').length) {

                element.closest('.form-group').append(error);

            } else {

                error.insertAfter(element);

            }

        },

        highlight: function (element) {

            $(element).addClass('is-invalid');

        },

        unhighlight: function (element) {

            $(element).removeClass('is-invalid');

        }

    });

});

</script>


{{-- ================================================================
     DISCOUNT CALCULATION
================================================================ --}}

<script>

$(document).ready(function () {

    $('#original_price, #selling_price').on(
        'keyup change',
        function () {

            let originalPrice =
                parseFloat($('#original_price').val());

            let sellingPrice =
                parseFloat($('#selling_price').val());

            if (
                !isNaN(originalPrice) &&
                !isNaN(sellingPrice) &&
                originalPrice > 0
            ) {

                let discount =
                    (
                        (originalPrice - sellingPrice) * 100
                    ) / originalPrice;

                if (discount < 0) {
                    discount = 0;
                }

                $('#discount').val(
                    discount.toFixed(2)
                );

            } else {

                $('#discount').val('');

            }

        }
    );

});

</script>


{{-- ================================================================
     SLUG GENERATION
================================================================ --}}

<script>

function generateBookSlug()
{

    let text =
        $('#cat_id_name')
        .val()
        .toLowerCase()
        .trim();

    let isbn =
        $('#isbn13')
        .val()
        .replace(/\s+/g, '')
        .trim();

    text =
        text.replace(
            /[^a-z0-9\s-]/g,
            ''
        );

    text =
        text.replace(
            /\s+/g,
            '-'
        );

    text =
        text.replace(
            /-+/g,
            '-'
        );

    let slug = '';

    if (text && isbn) {

        slug = text + '-' + isbn;

    } else if (text) {

        slug = text;

    } else if (isbn) {

        slug = isbn;

    }

    $('#url_slug').val(slug);

}


$('#cat_id_name').on(
    'keyup change',
    function () {

        generateBookSlug();

    }
);


$('#isbn13').on(
    'keyup change',
    function () {

        generateBookSlug();

    }
);

</script>


{{-- ================================================================
     CATEGORY -> SUB CATEGORY
================================================================ --}}

<script>

$(document).on(
    'change',
    '#category-dropdown',
    function () {

        let catid = $(this).val();

        $('#subcategory-dropdown').html(
            '<option value="">Loading...</option>'
        );

        $('#childcategory-dropdown').html(
            '<option value="">-- Select Child Category --</option>'
        );

        if (!catid) {

            $('#subcategory-dropdown').html(
                '<option value="">-- Select Sub Category --</option>'
            );

            return;

        }

        $.ajax({

            url: "{{ route('common.subcategories.all') }}",

            type: 'POST',

            data: {

                id: catid,

                _token: '{{ csrf_token() }}'

            },

            dataType: 'json',

            success: function (result) {

                $('#subcategory-dropdown').html(
                    '<option value="">-- Select Sub Category --</option>'
                );

                if (
                    result.subcategory &&
                    result.subcategory.length > 0
                ) {

                    $.each(
                        result.subcategory,
                        function (key, value) {

                            $('#subcategory-dropdown')
                                .append(
                                    '<option value="' +
                                    value.id +
                                    '">' +
                                    value.name +
                                    '</option>'
                                );

                        }
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    'Subcategory Error:',
                    xhr.responseText
                );

                $('#subcategory-dropdown').html(
                    '<option value="">Unable to load</option>'
                );

            }

        });

    }
);

</script>


{{-- ================================================================
     SUB CATEGORY -> CHILD CATEGORY
================================================================ --}}

<script>

$(document).on(
    'change',
    '#subcategory-dropdown',
    function () {

        let subcatid = $(this).val();

        $('#childcategory-dropdown').html(
            '<option value="">Loading...</option>'
        );

        if (!subcatid) {

            $('#childcategory-dropdown').html(
                '<option value="">-- Select Child Category --</option>'
            );

            return;

        }

        $.ajax({

            url: "{{ route('common.childcategories.all') }}",

            type: 'POST',

            data: {

                id: subcatid,

                _token: '{{ csrf_token() }}'

            },

            dataType: 'json',

            success: function (result) {

                $('#childcategory-dropdown').html(
                    '<option value="">-- Select Child Category --</option>'
                );

                if (
                    result.childcategory &&
                    result.childcategory.length > 0
                ) {

                    $.each(
                        result.childcategory,
                        function (key, value) {

                            $('#childcategory-dropdown')
                                .append(
                                    '<option value="' +
                                    value.id +
                                    '">' +
                                    value.name +
                                    '</option>'
                                );

                        }
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    'Child Category Error:',
                    xhr.responseText
                );

                $('#childcategory-dropdown').html(
                    '<option value="">Unable to load</option>'
                );

            }

        });

    }
);

</script>


{{-- ================================================================
     SKU GENERATION
================================================================ --}}

<script>

let inventoryIndex = 0;

let nextSkuNumber = null;


/*
|--------------------------------------------------------------------------
| Extract Numeric Part
|--------------------------------------------------------------------------
*/

function extractSkuNumber(sku)
{

    if (!sku) {
        return null;
    }

    let match =
        sku.match(/(\d+)$/);

    if (!match) {
        return null;
    }

    return parseInt(
        match[1],
        10
    );

}


/*
|--------------------------------------------------------------------------
| Generate SKU Format
|--------------------------------------------------------------------------
*/

function makeSku(number)
{
    return 'UDB-' +
        String(number).padStart(9, '0');
}


/*
|--------------------------------------------------------------------------
| Set SKU
|--------------------------------------------------------------------------
*/

function setSku(index, number)
{

    $('#sku_number_' + index).val(
        makeSku(number)
    );

}


/*
|--------------------------------------------------------------------------
| Get Next SKU From Backend
|--------------------------------------------------------------------------
*/

function loadFirstSku()
{

    $.ajax({

        url: "{{ route('books.next.sku') }}",

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            if (
                response.success &&
                response.sku
            ) {

                let number =
                    extractSkuNumber(
                        response.sku
                    );

                if (number !== null) {

                    nextSkuNumber =
                        number;

                    setSku(
                        0,
                        nextSkuNumber
                    );

                }

            }

        },

        error: function (xhr) {

            console.log(
                'SKU API Error:',
                xhr.responseText
            );

            $('#sku_number_0').val('');

        }

    });

}


/*
|--------------------------------------------------------------------------
| Load First SKU On Page Load
|--------------------------------------------------------------------------
*/

$(document).ready(function () {

    loadFirstSku();

});


/*
|--------------------------------------------------------------------------
| Add More Inventory
|--------------------------------------------------------------------------
*/

$(document).on(
    'click',
    '#add',
    function (e) {

        e.preventDefault();

        if (nextSkuNumber === null) {

            alert(
                'SKU number is still loading. Please wait.'
            );

            return;

        }

        inventoryIndex++;

        let currentIndex =
            inventoryIndex;

        let newSkuNumber =
            nextSkuNumber +
            currentIndex;

        let newSku =
            makeSku(
                newSkuNumber
            );


        let row = `

            <div class="row dynamicrow mb-3">


                <!-- CONDITION -->

                <div class="col-md-2">

                    <select
                        class="form-select bookconditions${currentIndex}"
                        name="addmore[${currentIndex}][condition]"
                        required>

                        <option value="">
                            Select Book Conditions
                        </option>

                    </select>

                </div>


                <!-- IMAGES -->

                <div class="col-md-2">

                    <input
                        type="file"
                        name="addmore[${currentIndex}][images][]"
                        class="form-control"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        multiple>

                </div>


                <!-- PRICE -->

                <div class="col-md-1">

                    <input
                        type="text"
                        name="addmore[${currentIndex}][price]"
                        placeholder="Price"
                        class="form-control"
                        required>

                </div>


                <!-- STOCK -->

                <div class="col-md-2">

                    <input
                        type="text"
                        name="addmore[${currentIndex}][stock]"
                        placeholder="Stock"
                        class="form-control"
                        required>

                </div>


                <!-- WEIGHT -->

                <div class="col-md-2">

                    <input
                        type="text"
                        name="addmore[${currentIndex}][book_weight]"
                        placeholder="Weight (gram)"
                        class="form-control">

                </div>


                <!-- SKU -->

                <div class="col-md-2">

                    <input
                        type="text"
                        name="addmore[${currentIndex}][sku_number]"
                        id="sku_number_${currentIndex}"
                        placeholder="SKU Number"
                        class="form-control sku-input"
                        value="${newSku}"
                        readonly
                        required>

                </div>


                <!-- REMOVE -->

                <div class="col-md-1">

                    <a
                        href="javascript:void(0)"
                        class="remove-tr"
                        title="Remove">

                        <i class="btn btn-danger mdi mdi-close"></i>

                    </a>

                </div>

            </div>

        `;


        $('#dynamicTable').append(row);


        /*
        |--------------------------------------------------------------------------
        | Load Book Conditions
        |--------------------------------------------------------------------------
        */

        $.ajax({

            url: '{{ route("common.bookconditions.all") }}',

            type: 'GET',

            dataType: 'json',

            success: function (response) {

                let select =
                    $('.bookconditions' +
                      currentIndex);

                select.empty();

                select.append(
                    '<option value="">' +
                    'Select Book Conditions' +
                    '</option>'
                );

                if (
                    response.condition_types
                ) {

                    $.each(
                        response.condition_types,
                        function (
                            index,
                            item
                        ) {

                            select.append(

                                '<option value="' +
                                item.name +
                                '">' +
                                item.name +
                                '</option>'

                            );

                        }
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    'Condition API Error:',
                    xhr.responseText
                );

            }

        });

    }
);


/*
|--------------------------------------------------------------------------
| Remove Inventory Row
|--------------------------------------------------------------------------
*/

$(document).on(
    'click',
    '.remove-tr',
    function (e) {

        e.preventDefault();

        $(this)
            .closest('.dynamicrow')
            .remove();

    }
);

</script>


{{-- ================================================================
     AJAX BOOK STORE
================================================================ --}}

<script>

$(document).ready(function () {

    $('#myForm').on(
        'submit',
        function (e) {

            e.preventDefault();

            let form =
                this;


            /*
            |--------------------------------------------------------------------------
            | Client Side Validation
            |--------------------------------------------------------------------------
            */

            if (!$(form).valid()) {

                return false;

            }


            /*
            |--------------------------------------------------------------------------
            | Remove Previous AJAX Errors
            |--------------------------------------------------------------------------
            */

            $('.ajax-error').remove();

            $('.is-invalid').removeClass(
                'is-invalid'
            );


            /*
            |--------------------------------------------------------------------------
            | Validate All Dynamic Rows
            |--------------------------------------------------------------------------
            */

            let dynamicValidation =
                true;


            $('#dynamicTable')
                .find('.inventory-row, .dynamicrow')
                .each(function () {

                    let condition =
                        $(this).find(
                            'select[name*="[condition]"]'
                        );

                    let price =
                        $(this).find(
                            'input[name*="[price]"]'
                        );

                    let stock =
                        $(this).find(
                            'input[name*="[stock]"]'
                        );

                    let sku =
                        $(this).find(
                            'input[name*="[sku_number]"]'
                        );


                    if (!condition.val()) {

                        condition.addClass(
                            'is-invalid'
                        );

                        dynamicValidation =
                            false;

                    }


                    if (!price.val()) {

                        price.addClass(
                            'is-invalid'
                        );

                        dynamicValidation =
                            false;

                    }


                    if (!stock.val()) {

                        stock.addClass(
                            'is-invalid'
                        );

                        dynamicValidation =
                            false;

                    }


                    if (!sku.val()) {

                        sku.addClass(
                            'is-invalid'
                        );

                        dynamicValidation =
                            false;

                    }

                });


            if (!dynamicValidation) {

                alert(
                    'Please complete all inventory details.'
                );

                return false;

            }


            /*
            |--------------------------------------------------------------------------
            | FormData
            |--------------------------------------------------------------------------
            */

            let formData =
                new FormData(form);


            /*
            |--------------------------------------------------------------------------
            | Disable Button
            |--------------------------------------------------------------------------
            */

            $('#submitBtn')
                .prop(
                    'disabled',
                    true
                );

            $('#submitText')
                .hide();

            $('#submitLoader')
                .show();


            /*
            |--------------------------------------------------------------------------
            | AJAX REQUEST
            |--------------------------------------------------------------------------
            */

            $.ajax({

                url:
                    $(form).attr('action'),

                type:
                    'POST',

                data:
                    formData,

                processData:
                    false,

                contentType:
                    false,

                dataType:
                    'json',

                headers: {

                    'X-Requested-With':
                        'XMLHttpRequest'

                },


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                success: function (
                    response
                ) {

                    if (
                        response.status === true
                    ) {

                        if (
                            typeof toastr !==
                            'undefined'
                        ) {

                            toastr.success(
                                response.message ||
                                'Book added successfully.'
                            );

                        } else {

                            alert(
                                response.message ||
                                'Book added successfully.'
                            );

                        }


                        setTimeout(
                            function () {

                                if (
                                    response.redirect_url
                                ) {

                                    window.location.href =
                                        response.redirect_url;

                                } else {

                                    window.location.reload();

                                }

                            },
                            700
                        );

                    } else {

                        let message =
                            response.message ||
                            'Unable to save book.';

                        if (
                            typeof toastr !==
                            'undefined'
                        ) {

                            toastr.error(
                                message
                            );

                        } else {

                            alert(
                                message
                            );

                        }

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | ERROR
                |--------------------------------------------------------------------------
                */

                error: function (
                    xhr
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Validation Error
                    |--------------------------------------------------------------------------
                    */

                    if (
                        xhr.status === 422
                    ) {

                        let response =
                            xhr.responseJSON || {};

                        let errors =
                            response.errors || {};


                        $.each(
                            errors,
                            function (
                                field,
                                messages
                            ) {

                                /*
                                |--------------------------------------------------------------------------
                                | Convert Laravel dot notation
                                | addmore.0.price
                                | into HTML name
                                |--------------------------------------------------------------------------
                                */

                                if (
                                    field.indexOf(
                                        'addmore.'
                                    ) === 0
                                ) {

                                    let parts =
                                        field.split(
                                            '.'
                                        );

                                    let index =
                                        parts[1];

                                    let fieldName =
                                        parts[2];


                                    let selector =
                                        '[name="addmore[' +
                                        index +
                                        '][' +
                                        fieldName +
                                        ']"]';


                                    let input =
                                        $(selector);


                                    if (
                                        input.length
                                    ) {

                                        input.addClass(
                                            'is-invalid'
                                        );

                                        input.after(

                                            '<span class="ajax-error invalid-feedback">' +
                                            messages[0] +
                                            '</span>'

                                        );

                                    }

                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Normal Fields
                                |--------------------------------------------------------------------------
                                */

                                else {

                                    let input =
                                        $('[name="' +
                                        field +
                                        '"]');


                                    /*
                                    |--------------------------------------------------------------------------
                                    | For radio / checkbox groups
                                    |--------------------------------------------------------------------------
                                    */

                                    if (
                                        input.length
                                    ) {

                                        input
                                            .first()
                                            .addClass(
                                                'is-invalid'
                                            );

                                        input
                                            .last()
                                            .after(

                                                '<span class="ajax-error invalid-feedback">' +
                                                messages[0] +
                                                '</span>'

                                            );

                                    }

                                }

                            }
                        );


                        let message =
                            response.message ||
                            'Please check the form.';


                        if (
                            typeof toastr !==
                            'undefined'
                        ) {

                            toastr.error(
                                message
                            );

                        } else {

                            alert(
                                message
                            );

                        }

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Server Error
                    |--------------------------------------------------------------------------
                    */

                    else {

                        let message =
                            'Something went wrong. Please try again.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        if (
                            typeof toastr !==
                            'undefined'
                        ) {

                            toastr.error(
                                message
                            );

                        } else {

                            alert(
                                message
                            );

                        }

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | COMPLETE
                |--------------------------------------------------------------------------
                */

                complete: function () {

                    $('#submitBtn')
                        .prop(
                            'disabled',
                            false
                        );

                    $('#submitText')
                        .show();

                    $('#submitLoader')
                        .hide();

                }

            });


            return false;

        }

    );

});


</script>


@endsection