@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- jQuery Validation Plugin (Ensure this is loaded if not already in admin_master) -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Banner Page </h4><br><br>

            <form method="post" action="{{ route('banners.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label"> Banner Type </label>
                    <div class="form-group col-sm-5">
                        <select class="form-control" name="btype" id="btype">
                            <option value="S" selected>Slider (Multiple)</option>
                            <option value="M">Mobile (Multiple)</option>
                            <option value="T">Top Banner (Single)</option>
                            <option value="B">Bottom Banner (Single)</option>
                        </select>
                    </div>
                    <!-- Dimension hint display -->
                    <div class="col-sm-5 d-flex align-items-center">
                        <span id="dimension_hint" class="badge bg-soft-info text-info p-2 fs-6 fw-bold" style="background-color: #e0f2fe; color: #0284c7;">
                            Recommended Size: 1500 * 500 px
                        </span>
                    </div>
                </div>
                
                <!-- end row -->
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label"> Name </label>
                    <div class="form-group col-sm-5">
                        <input name="name" class="form-control" type="text">
                    </div>
                </div>
                
                <!-- end row -->
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label"> Link </label>
                    <div class="form-group col-sm-5">
                        <input name="hreflink" class="form-control" type="text">
                    </div>
                </div>
                <!-- end row -->

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label"> Images </label>
                    <div class="form-group col-sm-5">
                        <input name="userfile" class="form-control" type="file">
                    </div>
                </div>
                <!-- end row -->

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label"> Status </label>
                    <div class="form-group col-sm-5">
                        <select class="form-select" name="status">
                            <option selected value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                </div>
                <!-- end row -->

                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add">
            </form>

        </div>
    </div>
</div> <!-- end col -->
</div>

</div>
</div>

<script type="text/javascript">
    $(document).ready(function (){

        // Object holding dimensions for each Banner Type option
        const dimensions = {
            'S': 'Recommended Size: 1500 * 500 px',
            'M': 'Recommended Size: 300 * 200 px',
           
        };

        // Function to update dynamic text
        function updateDimensionHint(selectedValue) {
            if (dimensions[selectedValue]) {
                $('#dimension_hint').text(dimensions[selectedValue]).show();
            } else {
                $('#dimension_hint').hide();
            }
        }

        // On Change Event
        $('#btype').on('change', function() {
            var selectedType = $(this).val();
            updateDimensionHint(selectedType);
        });

        // Trigger change on page load (For pre-selected default value)
        updateDimensionHint($('#btype').val());


        // jQuery Form Validation
        $('#myForm').validate({
            rules: {
                btype: {
                    required : true,
                },
                name: {
                    required : true,
                }, 
                userfile: {
                    required : true,
                },
                status: {
                    required : true,
                },
            },
            messages :{
                btype: {
                    required : 'Please Select Banner Type',
                },
                name: {
                    required : 'Please Enter Banner Name',
                },
                userfile: {
                    required : 'Please Select Banner Image',
                },
                status: {
                    required : 'Please Select Status',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection