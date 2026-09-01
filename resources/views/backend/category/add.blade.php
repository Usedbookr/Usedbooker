@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Category Page </h4><br><br>
            
  

            <form method="post" action="{{ route('categories.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Name </label>
                <div class="form-group col-sm-5">
                    <input name="name" class="form-control" id="cat_id_name" type="text" id="cat_id_name"  onkeyup="CatogeryUrl()"  >
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
                <label for="example-text-input" class="col-sm-2 col-form-label"> COD Enable  </label>
                <div class="form-group col-sm-5" style="display: flex;">
                    <input name="cod_disable" type="checkbox" >
                </div>
            </div>

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Best Seller display in home page  </label>
                <div class="form-group col-sm-5" style="display: flex;">
                    <input name="section_id" type="checkbox" >
                </div>
            </div>

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> After Content  </label>
                <div class="form-group col-sm-5" style="display: flex;">
                    <input name="before_content" type="checkbox" >
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Meta Name </label>
                <div class="form-group col-sm-5">
                    <input name="meta_name" class="form-control" type="text" id="meta_name_id" onkeyup="CatogeryUrl1()"  >
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
