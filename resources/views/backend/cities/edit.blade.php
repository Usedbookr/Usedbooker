@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit City Page </h4><br><br>
            
  

            <form method="post" action="{{ route('cities.update') }}" id="myForm" >
                @csrf
                <input type="hidden" name="id" value="{{ $edit->id }}">
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Name </label>
                <div class="form-group col-sm-5">
                    <input name="name" class="form-control" type="text"   value="{{$edit->name}}" >
                </div>
            </div>
            <!-- end row -->


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Choose Country </label>
                <div class="form-group col-sm-5">
                    <select class="form-select select2" aria-label="Default select example" name="country" id="country-dropdown">
                        @foreach($countries as $country)
                        <option value="{{$country->id}}" {{ ($country->id ==  $edit->country_id ) ? 'selected' : '' }}>{{$country->name}}</option>
                        @endforeach
                       
                        
                      </select>
                </div>
            </div>
            <!-- end row -->


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label"> Choose State </label>
                <div class="form-group col-sm-5">
                    <select class="form-select select2" aria-label="Default select example" name="state" id="state-dropdown">
                        
                       @foreach($states as $state)
                       <option value="{{$state->id}}" {{ ($state->id ==  $edit->state_id ) ? 'selected' : 'disabled' }}>{{$state->name}}</option>

                       @endforeach
                        
                      </select>
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


          





 
 


        
<input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
            </form>
             
           
           
        </div>
    </div>
</div> <!-- end col -->
</div>
 


</div>
</div>


<script>
    $(document).ready(function () {

        /*------------------------------------------
        --------------------------------------------
        Country Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#country-dropdown').on('change', function () {
            var idCountry = this.value;
            $("#state-dropdown").html('');
            $.ajax({
                url: "{{route('fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-dropdown').html('<option value="">-- Select State --</option>');
                    $.each(result.states, function (key, value) {
                        $("#state-dropdown").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                 
                }
            });
        });




    });
</script>


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
                country:{
                    required : true,
                }
            },
            messages :{
                name: {
                    required : 'Please Enter Your Name',
                },
                status: {
                    required : 'Please Select Status',
                },

                country: {
                    required : 'Please Select Country',
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
