@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Child Category Page </h4><br><br>
            
  

            <form method="post" action="{{ route('childcategories.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Category </label>
                <div class="form-group col-sm-5">
                    <select class="form-control" id="category-dropdown" required>
                        <option value="">Select category</option>
                        @if($categories)
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <!-- end row -->
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Sub Category </label>
                <div class="form-group col-sm-5">
                    <select class="form-control" id="subcategory-dropdown" name="category" required>
                        <option value="">-- Select SubCategory --</option>
                    </select>
                </div>
            </div>
            <!-- end row -->
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Name </label>
                <div class="form-group col-sm-5">
                    <input name="name" class="form-control" type="text"  id="cat_id_name"  onkeyup="CatogeryUrl()"   >
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Images </label>
                <div class="form-group col-sm-5">
                    <input name="userfile" class="form-control" type="file"    >
                </div>
            </div>
            <!-- end row -->


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Status </label>
                <div class="form-group col-sm-5">
                    <select class="form-select" aria-label="Default select example" name="status">
                        <option selected value="1">Active</option>
                        <option value="0">InActive</option>
                      </select>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Meta Name </label>
                <div class="form-group col-sm-5">
                    <input name="meta_name" class="form-control" type="text" id="meta_name_id" onkeyup="CatogeryUrl1()"   >
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Category URL </label>
                <div class="form-group col-sm-5">
                    <input name="url_slug" class="form-control" type="text"  id="url_slug"  >
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Meta Description </label>
                <div class="form-group col-sm-5">
                    <input name="meta_description" class="form-control" type="text"    >
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Meta Keyword </label>
                <div class="form-group col-sm-5">
                    <input name="meta_keyword" class="form-control" type="text"    >
                </div>
            </div>
          
            <!--<div class="row mb-3">-->
            <!--    <label for="example-text-input" class="col-sm-2 col-form-label"> Best Seller display in home page  </label>-->
            <!--    <div class="form-group col-sm-5" style="display: flex;">-->
            <!--        <input name="section_id" type="checkbox" >-->
            <!--    </div>-->
            <!--</div>-->

            <!--<div class="row mb-3">-->
            <!--    <label for="example-text-input" class="col-sm-2 col-form-label"> Before Content  </label>-->
            <!--    <div class="form-group col-sm-5" style="display: flex;">-->
            <!--        <input name="before_content" type="checkbox" >-->
            <!--    </div>-->
            <!--</div>-->




 
 


        
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
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                 status: {
                    required : true,
                },
            },
            messages :{
                name: {
                    required : 'Please Enter Your Name',
                },
                status: {
                    required : 'Please Select Status',
                },
                
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
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
    $('#category-dropdown').on('change', function () {
        var catid = this.value;
        $("#subcategory-dropdown").html('');
        $.ajax({
            url: "{{route('common.subcategories.all')}}",
            type: "POST",
            data: {
                id: catid,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#subcategory-dropdown').html('<option value="">-- Select SubCategory --</option>');
                $.each(result.subcategory, function (key, value) {
                    $("#subcategory-dropdown").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
    
    function CatogeryUrl()
    {
        
        var text = $("#cat_id_name").val();
        var fixed = text.toLowerCase();
        var fixed1 = fixed.replace(/\s+/g, '-');
        
        $("#url_slug").val(fixed1);
    }
    function CatogeryUrl1()
    {
        
        var text = $("#meta_name_id").val();
        var fixed = text.toLowerCase();
        var fixed1 = fixed.replace(/\s+/g, '-');
        
        $("#url_slug").val(fixed1);
    }
</script>


 
@endsection 
