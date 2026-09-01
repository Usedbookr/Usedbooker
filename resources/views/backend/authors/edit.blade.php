@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit User</h4><br><br>
            
  

            <form method="post" action="{{ route('users.store',$edit->id) }}" id="myForm" >
            @csrf


            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> Name </label>
                    <div class="form-group col-sm-12">
                        <input name="name" class="form-control" type="text"  value="{{ $edit->name }}"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> Email </label>
                    <div class="form-group col-sm-12">
                        <input name="email" class="form-control" type="email"  value="{{ $edit->email }}"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> Phone Number </label>
                    <div class="form-group col-sm-12">
                        <input name="phone" class="form-control" type="text"  value="{{ $edit->phone_number }}"  >
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label"> Status </label>
                    <div class="form-group col-sm-12">
                        <select class="form-select" aria-label="Default select example" name="status">
                            <option selected value="1">Active</option>
                            <option value="0">InActive</option>
                          </select>
                    </div>
                </div> --}}
            </div>

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
