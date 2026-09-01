@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Page</h4><br><br>
            
  

            <form method="post" action="{{ route('book_conditions.update') }}" id="myForm" >
                @csrf

                <input type="hidden" name="id" value="{{ $edit->id }}">

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Name </label>
                <div class="form-group col-sm-5">
                    <input name="name" class="form-control" value="{{ $edit->name }}" type="text"    >
                </div>
            </div>
            <!-- end row -->


         
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Status </label>
                <div class="form-group col-sm-5">
                    <select class="form-select" aria-label="Default select example" name="status">
                        <option  value="1" {{($edit->status == 1) ? 'selected' :''}}>Active</option>
                        <option value="0" {{($edit->status == 0) ? 'selected' :''}}>InActive</option>
                      </select>
                </div>
            </div>
            <!-- end row -->





 
 


        
<input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
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
    
</script>

 
@endsection 
