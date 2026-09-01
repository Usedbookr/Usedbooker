@extends('admin.admin_master')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
   .sku-input {
        background-color: #f5f5f5 !important;
        cursor: not-allowed;
        font-weight: 600;
        color: #333;
    }
    .dynamicrow {
        align-items: center !important;
    }
    #files-area {
        margin: 0 auto;
    }

    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
        font-size: 10px;
        padding: 0px 4px;
    }

    .file-block>span.name {
        padding-right: 6px;
        width: max-content;
        display: inline-flex;
        padding-top: 4px;
    }

    .file-delete {
        display: flex;
        width: 15px;
        color: initial;
        background-color: #6eb4ff00;
        font-size: 15px;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }

    .file-delete>span {
        transform: rotate(45deg);
    }

    .file-delete:hover {
        background-color: rgba(144, 163, 203, 0.2);
        border-radius: 10px;
    }
    .image-preview-wrapper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
        width: 100%;
    }
    .image-container {
        position: relative;
        display: inline-block;
        margin: 0;
    }

    .image-container img {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-delete-img {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 18px;
        cursor: pointer;
        font-weight: bold;
        font-size: 13px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        z-index: 5;
    }

    .btn-add-img {
        width: 75px;
        height: 75px;
        border: 2px dashed #0d6efd;
        border-radius: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        color: #0d6efd;
        font-size: 22px;
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    .btn-add-img:hover {
        background: #e7f1ff;
        border-color: #0a58ca;
    }
</style>


<div class="page-content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">


                        {{-- ============================================================
                        IMAGE CROP MODAL
                        ============================================================ --}}

                        <div id="uploadimageModal" class="modal" role="dialog">

                            <div class="modal-dialog cropimg">

                                <div class="modal-content">

                                    <div class="modal-body">

                                        <a href="javascript:void(0)" class="btn-cropclose" onclick="modalclose();">

                                            <img src="https://icones.pro/wp-content/uploads/2022/05/icone-fermer-et-x-rouge.png"
                                                width="25px">

                                        </a>


                                        <div class="row">

                                            <div class="col-md-12 text-center">

                                                <div id="image_demo" style="width:100%;">
                                                </div>

                                            </div>


                                            <input type="hidden" id="idval">


                                            <div class="col-md-12 text-center mb-1">

                                                <button type="button" class="btn btn-success crop_image">

                                                    Upload

                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- ============================================================
                        PAGE TITLE
                        ============================================================ --}}

                        <h4 class="card-title">
                            Edit Books
                        </h4>

                        <br>
                        <br>



                        {{-- ============================================================
                        FORM
                        ============================================================ --}}

                        <form method="post" action="{{ route('books.update') }}" id="myForm"
                            enctype="multipart/form-data">

                            @csrf


                            <input type="hidden" name="id" value="{{ $books->id }}">



                            {{-- ========================================================
                            LISTED BY
                            ========================================================= --}}

                            <div class="row mb-3">

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Listed By
                                            <span style="color:red;">*</span>

                                        </label>


                                        <div class="form-group col-sm-9" style="padding:12px 0px 0px">

                                            <input name="listed_by" value="A" type="radio" @if ($books->listed_by ==
                                            'A') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                A&nbsp;&nbsp;
                                            </span>


                                            <input name="listed_by" value="B" type="radio" @if ($books->listed_by ==
                                            'B') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                B&nbsp;&nbsp;
                                            </span>


                                            <input name="listed_by" value="C" type="radio" @if ($books->listed_by ==
                                            'C') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                C&nbsp;&nbsp;
                                            </span>


                                            <input name="listed_by" value="D" type="radio" @if ($books->listed_by ==
                                            'D') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                D&nbsp;&nbsp;
                                            </span>


                                            <input name="listed_by" value="E" type="radio" @if ($books->listed_by ==
                                            'E') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                E&nbsp;&nbsp;
                                            </span>


                                            <input name="listed_by" value="F" type="radio" @if ($books->listed_by ==
                                            'F') checked @endif required>

                                            <span style="top:-1px;position:relative;">
                                                F
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            {{-- ========================================================
                            TITLE
                            ========================================================= --}}

                            <div class="row mb-3">

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Title
                                            <span style="color:red;">*</span>

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="name" value="{{ $books->name }}" class="form-control"
                                                type="text" id="cat_id_name" onkeyup="CatogeryUrl()" required>

                                        </div>

                                    </div>

                                </div>



                                {{-- AUTHOR --}}

                                <div class="col-md-6">

                                    <div class="row">

                                        <label class="col-sm-3 col-form-label">

                                            Author

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="author" class="form-control" value="{{ $books->author }}"
                                                type="text">

                                        </div>

                                    </div>

                                </div>



                                {{-- IMAGE --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Outer cover image
                                            <span style="color:red;">*</span>

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input class="form-control" type="file" id="file" name="thumbnail_image" {{ empty($books->image) ? 'required' : '' }}>

                                            <br>


                                            @if ($books->image)
                                            <img src="{{ asset('') }}public/upload/admin_images/books/{{ $books->image }}"
                                                style="width:70px;">

                                            <input type="hidden" name="imgae_old_tump" value="{{ $books->image }}">
                                            @endif

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

                                            <input name="original_price" value="{{ $books->original_price }}"
                                                class="form-control" type="text" id="original_price">

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

                                            <input name="selling_price" class="form-control"
                                                value="{{ $books->selling_price }}" type="text" id="selling_price">

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

                                            <input name="discount" class="form-control" value="{{ $books->discount }}"
                                                type="text" id="discount">

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

                                            <input name="isbn13" value="{{ $books->isbn13 }}" class="form-control"
                                                type="text" id="isbn13" onkeyup="CatogeryUrl1()">

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

                                            <input name="title_long" value="{{ $books->title_long }}"
                                                class="form-control" type="text">

                                        </div>

                                    </div>

                                </div>



                                {{-- SECTION --}}

                                @php
                                $seller_id_check = explode(',', $books->section_id);
                                @endphp


                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Section

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="section_id[]" {{ in_array('N', $seller_id_check) ? 'checked'
                                                : '' }} value="N" type="checkbox">

                                            New Arrival&nbsp;


                                            <input name="section_id[]" {{ in_array('B', $seller_id_check) ? 'checked'
                                                : '' }} value="B" type="checkbox">

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

                                            <input name="publisher" value="{{ $books->publisher }}" class="form-control"
                                                type="text">

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

                                            <input name="date_published" value="{{ $books->date_published }}"
                                                class="form-control" type="date">

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

                                            <input name="pages" value="{{ $books->pages }}" class="form-control"
                                                type="text">

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

                                            <input name="dimensions" value="{{ $books->dimensions }}"
                                                class="form-control" type="text">

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

                                            <select class="form-control" name="format" id="format-dropdown">

                                                <option value="">
                                                    Select Format
                                                </option>

                                                <option value="Paperback" {{ $books->format == 'Paperback' ? 'selected'
                                                    : '' }}>
                                                    Paperback
                                                </option>

                                                <option value="Hardcover" {{ $books->format == 'Hardcover' ? 'selected'
                                                    : '' }}>
                                                    Hardcover
                                                </option>

                                                <option value="Board Book" {{ $books->format == 'Board Book' ?
                                                    'selected' : '' }}>
                                                    Board Book
                                                </option>

                                                <option value="Mass Market Paperback" {{ $books->format == 'Mass Market
                                                    Paperback' ? 'selected' : '' }}>
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

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <select class="form-control" name="language" id="language-dropdown"
                                                required>

                                                <option value="">
                                                    Select language
                                                </option>

                                                @if ($languages)
                                                @foreach ($languages as $language)
                                                <option value="{{ $language->name }}" @if ($books->language ==
                                                    $language->name) selected @endif>

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

                                            <select class="form-control" name="category" id="category-dropdown"
                                                required>

                                                <option value="">
                                                    Select category
                                                </option>

                                                @if ($categories)
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $books->category_id ==
                                                    $category->id ? 'selected' : '' }}>

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

                                            <select class="form-control" id="subcategory-dropdown" name="subcategory"
                                                required>

                                                <option value="">
                                                    -- Select Sub Category --
                                                </option>

                                                @if ($subcategories)
                                                @foreach ($subcategories as $category)
                                                <option value="{{ $category->id }}" {{ $books->subcategory_id ==
                                                    $category->id ? 'selected' : '' }}>

                                                    {{ $category->name }}

                                                </option>
                                                @endforeach
                                                @endif

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

                                            <select class="form-control" id="childcategory-dropdown"
                                                name="childcategory">

                                                <option value="">
                                                    -- Select Child Category --
                                                </option>

                                                @if ($childcategories)
                                                @foreach ($childcategories as $category)
                                                <option value="{{ $category->id }}" {{ $books->childcategory_id ==
                                                    $category->id ? 'selected' : '' }}>

                                                    {{ $category->name }}

                                                </option>
                                                @endforeach
                                                @endif

                                            </select>

                                        </div>

                                    </div>

                                </div>



                                {{-- ====================================================
                                BOOK SKU
                                ===================================================== --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            SKU Number

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="sku_numer" value="{{ $books->sku }}"
                                                class="form-control sku-input" type="text" readonly>

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

                                            <input name="hsn_code" value="{{ $books->hsn_code }}" class="form-control"
                                                type="text">

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

                                            <select class="form-control" name="gst_charge">

                                                <option value="0" {{ $books->gst_charge == 0 ? 'selected' : '' }}>
                                                    Without GST
                                                </option>

                                                <option value="5" {{ $books->gst_charge == 5 ? 'selected' : '' }}>
                                                    5%
                                                </option>

                                                <option value="12" {{ $books->gst_charge == 12 ? 'selected' : '' }}>
                                                    12%
                                                </option>

                                                <option value="18" {{ $books->gst_charge == 18 ? 'selected' : '' }}>
                                                    18%
                                                </option>

                                                <option value="28" {{ $books->gst_charge == 28 ? 'selected' : '' }}>
                                                    28%
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>



                                {{-- OLD IMAGES --}}

                                @if ($books->image)
                                <input type="hidden" name="old_image" value="{{ $books->image }}">

                                <input type="hidden" name="old_multiple_image" value="{{ $books->multi_image }}">
                                @endif



                                {{-- SYNOPSIS --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Synopsis

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="synopsis" value="{{ $books->synopsis }}" class="form-control"
                                                type="text">

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

                                            <select class="form-select" name="status">

                                                <option value="1" {{ $books->status == 1 ? 'selected' : '' }}>

                                                    Active

                                                </option>

                                                <option value="0" {{ $books->status == 0 ? 'selected' : '' }}>

                                                    InActive

                                                </option>
                                                <option value="2" {{ $books->status == 2 ? 'selected' : '' }}>
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

                                            <input name="meta_name" class="form-control" type="text" id="meta_name_id"
                                                value="{{ $books->meta_name }}" onkeyup="CatogeryUrl1()">

                                        </div>

                                    </div>

                                </div>

                                {{-- BOOK URL --}}

                                <div class="col-md-6">

                                    <div class="row mb-3">

                                        <label class="col-sm-3 col-form-label">

                                            Book URL
                                            <span style="color:red;">*</span>

                                        </label>


                                        <div class="form-group col-sm-9">

                                            <input name="url_slug" class="form-control" type="text"
                                                value="{{ $books->url_slug }}" id="url_slug" required>

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

                                            <input name="meta_description" class="form-control"
                                                value="{{ $books->meta_description }}" type="text">

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

                                            <input name="meta_keyword" class="form-control"
                                                value="{{ $books->meta_keyword }}" type="text">

                                        </div>

                                    </div>

                                </div>


                            </div>
                            <h4 class="text-success">
                                Attribute List
                            </h4>


                            <div class="col-12 text-center" id="dynamicTable">
                                @if ($varients->isNotEmpty())
                                @foreach ($varients as $key => $varient)
                                @php
                                $multiple_images = json_decode($varient->images);
                                @endphp


                                <div class="row dynamicrow mb-3">


                                    {{-- CONDITION --}}

                                    <div class="col-md-2">

                                        <select class="form-select bookconditions"
                                            name="addmore[{{ $key }}][condition]">

                                            <option value="">
                                                Book Conditions
                                            </option>

                                            @foreach ($condition_types as $condition_type)
                                            <option value="{{ $condition_type->name }}" {{ $condition_type->name ==
                                                $varient->bookconditions ? 'selected' : '' }}>

                                                {{ $condition_type->name }}

                                            </option>
                                            @endforeach

                                        </select>

                                    </div>



                                    {{-- IMAGES --}}

                                    <div class="col-md-2">

                                        <input type="file" name="addmore[{{ $key }}][images][]" class="form-control"
                                            multiple>


                                        @if ($varient->images)
                                        <input type="hidden" name="addmore[{{ $key }}][hidden]"
                                            value="{{ $varient->images }}">
                                        @endif

                                    </div>



                                    {{-- PRICE --}}

                                    <div class="col-md-1">

                                        <input type="text" name="addmore[{{ $key }}][price]"
                                            value="{{ $varient->price }}" placeholder="Price"
                                            class="form-control inputdecimal">

                                    </div>



                                    {{-- STOCK --}}

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[{{ $key }}][stock]"
                                            value="{{ $varient->stock }}" placeholder="Stock" class="form-control">

                                    </div>



                                    {{-- WEIGHT --}}

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[{{ $key }}][book_weight]"
                                            value="{{ $varient->book_weight }}" placeholder="Weight (gram)"
                                            class="form-control inputdecimal">

                                    </div>

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[{{ $key }}][sku_number]"
                                            id="sku_number_{{ $key }}" value="{{ $varient->sku_number }}"
                                            placeholder="SKU Number" class="form-control sku-input" readonly required>

                                    </div>



                                    {{-- ADD / REMOVE --}}

                                    @if ($key == 0)
                                    <div class="col-md-1">

                                        <a href="javascript:void(0)" name="add" id="add" title="Add More">

                                            <i class="btn btn-success mdi mdi-plus"></i>

                                        </a>

                                    </div>
                                    @else
                                    <div class="col-md-1">

                                        <a href="javascript:void(0)" class="remove-tr" title="Remove">

                                            <i class="btn btn-danger mdi mdi-close"></i>

                                        </a>

                                    </div>
                                    @endif



                                    {{-- EXISTING IMAGES --}}

                                   <div class="col-12 mt-2">
                                        <div class="image-preview-wrapper">
                                            @if ($multiple_images)
                                                @foreach ($multiple_images as $img_key => $image)
                                                    <div class="image-container" id="img_container_{{ $key }}_{{ $img_key }}">
                                                        <span class="btn-delete-img" onclick="removeExistingImage('{{ $key }}', '{{ $image }}', 'img_container_{{ $key }}_{{ $img_key }}')">&times;</span>
                                                        <img src="{{ asset('public/images/' . $image) }}" alt="Book Image">
                                                    </div>
                                                @endforeach
                                            @endif

                                            <!-- Add More Icon Box -->
                                            <div class="btn-add-img" title="Add More Image" onclick="$('#extra_file_{{ $key }}').click()">
                                                <i class="mdi mdi-plus"></i>
                                            </div>
                                            
                                            <!-- Hidden Input -->
                                            <input type="file" name="addmore[{{ $key }}][images][]" id="extra_file_{{ $key }}" class="d-none" multiple accept="image/*" onchange="previewNewImages(this, {{ $key }})">
                                            
                                            <!-- New Previews Wrapper -->
                                            <div id="new_preview_container_{{ $key }}" class="d-inline-flex flex-wrap gap-2"></div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                                @else
                                <div class="row dynamicrow mb-3">


                                    {{-- CONDITION --}}

                                    <div class="col-md-2">

                                        <select class="form-select bookconditions" name="addmore[0][condition]">

                                            <option value="">
                                                Book Conditions
                                            </option>

                                            @foreach ($condition_types as $condition_type)
                                            <option value="{{ $condition_type->name }}">

                                                {{ $condition_type->name }}

                                            </option>
                                            @endforeach

                                        </select>

                                    </div>



                                    {{-- IMAGES --}}

                                    <div class="col-md-2">

                                        <input type="file" name="addmore[0][images][]" class="form-control" multiple>

                                    </div>



                                    {{-- PRICE --}}

                                    <div class="col-md-1">

                                        <input type="text" name="addmore[0][price]" placeholder="Price"
                                            class="form-control">

                                    </div>



                                    {{-- STOCK --}}

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[0][stock]" placeholder="Stock"
                                            class="form-control inputdecimal">

                                    </div>



                                    {{-- WEIGHT --}}

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[0][book_weight]" placeholder="Weight (gram)"
                                            class="form-control inputdecimal">

                                    </div>



                                    {{-- SKU --}}

                                    <div class="col-md-2">

                                        <input type="text" name="addmore[0][sku_number]" placeholder="SKU Number"
                                            class="form-control sku-input" value="" readonly>

                                    </div>



                                    {{-- ADD --}}

                                    <div class="col-md-1">

                                        <a href="javascript:void(0)" name="add" id="add" title="Add More">

                                            <i class="btn btn-success mdi mdi-plus"></i>

                                        </a>

                                    </div>

                                </div>
                                @endif

                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="UPDATE">


                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <script>
        $(document).ready(function() {

                $('#myForm').validate({

                    rules: {

                        name: {
                            required: true,
                        },

                        status: {
                            required: true,
                        },

                    },


                    messages: {

                        name: {
                            required: 'Please Enter Your Name',
                        },

                        status: {
                            required: 'Please Select Status',
                        },

                    },


                    errorElement: 'span',


                    errorPlacement: function(error, element) {

                        error.addClass('invalid-feedback');

                        element
                            .closest('.form-group')
                            .append(error);

                    },


                    highlight: function(
                        element,
                        errorClass,
                        validClass
                    ) {

                        $(element).addClass('is-invalid');

                    },


                    unhighlight: function(
                        element,
                        errorClass,
                        validClass
                    ) {

                        $(element).removeClass('is-invalid');

                    },

                });

            });
    </script>
    <script>
        $(document).ready(function() {

                $("#selling_price").keyup(function() {

                    var original_price =
                        $("#original_price").val();

                    var selling_price =
                        $("#selling_price").val();


                    var percent = 0;


                    if (original_price) {

                        percent =
                            (
                                (original_price - selling_price) *
                                100
                            ) /
                            original_price;


                        percent =
                            parseFloat(percent).toFixed(2);

                    }

                    $("#discount").val(percent);

                });

            });
    </script>
    <script>
        $(document).ready(function() {

                $image_crop =
                    $('#image_demo').croppie({

                        enableExif: true,

                        viewport: {

                            width: 320,

                            height: 400,

                            type: 'square'

                        },

                        boundary: {

                            width: 430,

                            height: 533

                        }

                    });
                $('.crop_image').click(function(event) {

                    $image_crop
                        .croppie('result', {

                            type: 'canvas',

                            size: 'viewport'

                        })
                        .then(function(response) {
                            var ID =
                                $("#idval").val();
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "{{ route('crop-image-upload-ajax_gallery') }}",
                                data: {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'image': response
                                },
                                success: function(data) {
                                    $('#uploadimageModal')
                                        .modal('hide');
                                    $('#uploaded_image')
                                        .html(
                                            '<img src="' +
                                            data.image_url +
                                            '" class="img-thumbnail" width="80px"/>'
                                        );
                                    $('#profile_images')
                                        .val(data.image_name);

                                }

                            });

                        });

                });

            });
            function preview(id) {
                var dc =
                    document.getElementById("file").files;
                $("#idval").val(id);
                var reader =
                    new FileReader();

                reader.onload = function(event) {
                    $image_crop
                        .croppie('bind', {

                            url: event.target.result

                        })
                        .then(function() {

                            console.log(
                                'jQuery bind complete'
                            );

                        });
                };
                reader.readAsDataURL(dc[0]);
                $('#uploadimageModal')
                    .modal('show');

            }

            function modalclose() {

                $('#uploadimageModal')
                    .modal('hide');

            }

            function imagedelete(id, value) {
                if (
                    confirm(
                        'Are you sure want to delete this image?'
                    )
                ) {
                    $.ajax({
                        url: "ajax-image-delete.php",
                        type: "POST",
                        data: "product_id=" +
                            id +
                            "&imagetype=" +
                            value,
                        success: function(result) {

                            $("#output" + value)
                                .html(result);

                        }

                    });
                }
            }
    </script>

    <script>
        $('#category-dropdown').on('change', function() {
                var catid =
                    this.value;
                $("#subcategory-dropdown")
                    .html('');
                $.ajax({
                    url: "{{ route('common.subcategories.all') }}",
                    type: "POST",
                    data: {

                        id: catid,

                        _token: '{{ csrf_token() }}'

                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#subcategory-dropdown')
                            .html(
                                '<option value="">-- Select SubCategory --</option>'
                            );
                        $.each(
                            result.subcategory,
                            function(key, value) {

                                $("#subcategory-dropdown")
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

                });

            });

            $('#subcategory-dropdown').on('change', function() {
                var catid =
                    this.value;
                $("#childcategory-dropdown")
                    .html('');
                $.ajax({
                    url: "{{ route('common.childcategories.all') }}",
                    type: "POST",
                    data: {

                        id: catid,

                        _token: '{{ csrf_token() }}'

                    },
                    dataType: 'json',

                    success: function(result) {
                        $('#childcategory-dropdown')
                            .html(
                                '<option value="">-- Select Child Category --</option>'
                            );

                        $.each(
                            result.childcategory,
                            function(key, value) {

                                $("#childcategory-dropdown")
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
                });

            });
    </script>

    <script>
        let inventoryIndex =
                {{ $varients->count() > 0 ? $varients->count() - 1 : 0 }};

            let nextSkuNumber = null;
            function extractSkuNumber(sku) {

                if (!sku) {
                    return null;
                }

                sku =
                    String(sku).trim();

                let match =
                    sku.match(/^UDB-(\d+)$/i);

                if (!match) {

                    return null;

                }

                return parseInt(
                    match[1],
                    10
                );

            }
            function makeSku(number) {
                return 'UDB-' +
                    String(number).padStart(
                        9,
                        '0'
                    );
            }
            function loadNextSku() {

                $.ajax({

                    url: "{{ route('books.next.sku') }}",

                    type: "GET",

                    dataType: "json",

                    success: function(response) {
                        if (
                            response.success &&
                            response.sku
                        ) {
                            let number =
                                extractSkuNumber(
                                    response.sku
                                );


                            if (
                                number !== null
                            ) {


                                nextSkuNumber =
                                    number;


                                console.log(
                                    "Next available SKU:",
                                    makeSku(
                                        nextSkuNumber
                                    )
                                );

                            }

                        }

                    },
                    error: function(xhr) {

                        console.log(
                            "SKU API Error:",
                            xhr.responseText
                        );

                    }

                });

            }
            $(document).ready(function() {

                loadNextSku();

            });
            $(document).on(
                'click',
                '#add',
                function(e) {
                    e.preventDefault();
                    if (
                        nextSkuNumber === null
                    ) {

                        alert(
                            "SKU number is still loading. Please wait."
                        );

                        return;

                    }
                    inventoryIndex++;
                    let currentIndex =
                        inventoryIndex;

                    let newSku =
                        makeSku(
                            nextSkuNumber
                        );
                    nextSkuNumber++;
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
                    class="form-control inputnum"
                    required>

            </div>



            <!-- STOCK -->

            <div class="col-md-2">

                <input
                    type="text"
                    name="addmore[${currentIndex}][stock]"
                    placeholder="Stock"
                    class="form-control inputnum"
                    required>

            </div>



            <!-- WEIGHT -->

            <div class="col-md-2">

                <input
                    type="text"
                    name="addmore[${currentIndex}][book_weight]"
                    placeholder="Weight (gram)"
                    class="form-control inputdecimal">

            </div>



            <!-- SKU -->

            <div class="col-md-2">

                <input
                    type="text"
                    name="addmore[${currentIndex}][sku_number]"
                    id="sku_number_${currentIndex}"
                    value="${newSku}"
                    placeholder="SKU Number"
                    class="form-control sku-input"
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


                    $('#dynamicTable')
                        .append(row);

                    $.ajax({

                        url: '{{ route('common.bookconditions.all') }}',

                        type: 'GET',

                        dataType: 'json',


                        success: function(response) {


                            let select =
                                $('.bookconditions' +
                                    currentIndex
                                );

                            select.empty();
                            select.append(
                                '<option value="">Select Book Conditions</option>'
                            );

                            if (
                                response.condition_types
                            ) {

                                $.each(

                                    response.condition_types,

                                    function(
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

                        error: function(xhr) {

                            console.log(
                                "Condition API Error:",
                                xhr.responseText
                            );

                        }

                    });

                }
            );

            $(document).on(
                'click',
                '.remove-tr',
                function(e) {


                    e.preventDefault();


                    $(this)
                        .closest('.dynamicrow')
                        .remove();

                }
            );
    </script>

    <script>
        const dt =
                new DataTransfer();


            $("#images").on(
                'change',
                function(e) {


                    $('#files-area')
                        .show();


                    for (
                        var i = 0; i < this.files.length; i++
                    ) {
                        let fileBloc =
                            $('<span/>', {
                                class: 'file-block'
                            });


                        let fileName =
                            $('<span/>', {
                                class: 'name',
                                text: this.files.item(i).name
                            });
                        fileBloc
                            .append(
                                '<span class="file-delete"><span>+</span></span>'
                            )
                            .append(fileName);


                        $("#filesList > #files-names")
                            .append(fileBloc);

                    }
                    for (
                        let file of this.files
                    ) {

                        dt.items.add(file);

                    }

                    this.files =
                        dt.files;

                    $('span.file-delete')
                        .click(function() {


                            let name =
                                $(this)
                                .next('span.name')
                                .text();


                            $(this)
                                .parent()
                                .remove();


                            for (
                                let i = 0; i < dt.items.length; i++
                            ) {

                                if (
                                    name ===
                                    dt.items[i]
                                    .getAsFile()
                                    .name
                                ) {


                                    dt.items.remove(i);

                                    continue;

                                }

                            }
                            document
                                .getElementById('attachment')
                                .files =
                                dt.files;

                        });

                });
    </script>

    <script>
        function CatogeryUrl() {

                var text =
                    $("#cat_id_name").val();


                var isbn =
                    $("#isbn13").val();


                var fixed =
                    text
                    .toLowerCase()
                    .trim();


                var fixed1 =
                    fixed.replace(
                        /\s+/g,
                        '-'
                    );


                var fixedIsbn =
                    isbn.replace(
                        /\s+/g,
                        ''
                    );


                var slug =
                    fixed1 +
                    '-' +
                    fixedIsbn;


                $("#url_slug")
                    .val(slug);

            }

            function CatogeryUrl1() {

                var text =
                    $("#cat_id_name").val();


                var isbn =
                    $("#isbn13").val();


                var fixed =
                    text
                    .toLowerCase()
                    .trim();


                var fixed1 =
                    fixed.replace(
                        /\s+/g,
                        '-'
                    );


                var fixedIsbn =
                    isbn.replace(
                        /\s+/g,
                        ''
                    );


                var slug =
                    fixed1 +
                    '-' +
                    fixedIsbn;


                $("#url_slug")
                    .val(slug);

            }
            function previewNewImages(input, key) {
    let container = $('#new_preview_container_' + key);
    if (input.files) {
        $.each(input.files, function(index, file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let html = `
                    <div class="image-container new-preview">
                        <span class="btn-delete-img" onclick="$(this).parent().remove()">&times;</span>
                        <img src="${e.target.result}" style="border: 2px solid #28a745;">
                    </div>
                `;
                container.append(html);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Function to Handle Old Image Deletion from Database List
function removeExistingImage(variantIndex, imageName, elementId) {
    if (confirm('Are you sure you want to delete this image?')) {
        $('#' + elementId).remove();

        // Get the hidden input containing JSON array of existing images
        let hiddenInput = $('input[name="addmore[' + variantIndex + '][hidden]"]');
        if (hiddenInput.length) {
            let currentImages = JSON.parse(hiddenInput.val() || '[]');
            let updatedImages = currentImages.filter(img => img !== imageName);
            hiddenInput.val(JSON.stringify(updatedImages));
        }
    }
}
    </script>
    @endsection