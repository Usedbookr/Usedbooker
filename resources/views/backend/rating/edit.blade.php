@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Rating Review </h4><br><br>
            
  

            <form method="post" action="{{ route('ratingreview.update') }}" id="myForm"  enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="id" value="{{ $ratingreview->id }}">
                <div class="row mb-3">
                    
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Rating </label>
                            <div class="form-group col-sm-9">
                                <input name="rating" class="form-control" value="{{ $ratingreview->rating }}" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Review </label>
                            <div class="form-group col-sm-9">
                                <input name="review" class="form-control" value="{{ $ratingreview->review }}" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Status </label>
                            <div class="form-group col-sm-9">
                                <select class="form-select" aria-label="Default select example" name="status">
                                    <option value="Active" {{ $ratingreview->status=='Active'?'selected':'' }}>Active</option>
                                    <option value="Inactive" {{ $ratingreview->status=='Inactive'?'selected':'' }}>InActive</option>
                                  </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <input type="submit" class="btn btn-info waves-effect waves-light" value="UPDATE">
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



<script>  
    $(document).ready(function(){
    
        $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
        width:320,
          height:400,
          type:'square' //circle
        },
        boundary:{
          width:430,
          height:533
        }
      });
    
      // $('#upload_image').on('change', function(){
       
      // });
    
    
      $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
    
        var ID =$("#idval").val();
    
        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ route('crop-image-upload-ajax_gallery') }}",
                            data: {'_token': $('meta[name="_token"]').attr('content'), 'image': response },
                            success: function(data){
                                $('#uploadimageModal').modal('hide');
                                $('#uploaded_image').html('<img src="'+data.image_url+'" class="img-thumbnail" width="80px"/>');
                                $('#profile_images').val(data.image_name);
                            }
        });
        
    
    
    
        
         
        })
      });
    
    });  
    
    
    function preview(id)
    {
    var dc = document.getElementById("file").files;
    $("#idval").val(id);
    var reader = new FileReader();
    reader.onload = function (event) {
    $image_crop.croppie('bind', {
    url: event.target.result
    }).then(function(){
    console.log('jQuery bind complete');
    });
    }
    reader.readAsDataURL(dc[0]);
    $('#uploadimageModal').modal('show');
    }
    function modalclose(){
        $('#uploadimageModal').modal('hide');
    
    }
    function imagedelete(id,value) {
    
    if(confirm('Are you sure want to delete this image?')) {
    $.ajax({
    url: "ajax-image-delete.php", 
    type: "POST",
    data: "product_id="+id+"&imagetype="+value,
    success: function(result){
    
    $("#output"+value).html(result);
    }}); 
    }
    }
    
    
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
    
    $('#subcategory-dropdown').on('change', function () {
        var catid = this.value;
        $("#childcategory-dropdown").html('');
        $.ajax({
            url: "{{route('common.childcategories.all')}}",
            type: "POST",
            data: {
                id: catid,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#childcategory-dropdown').html('<option value="">-- Select Child Category --</option>');
                $.each(result.childcategory, function (key, value) {
                    $("#childcategory-dropdown").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
    
</script>

<script type="text/javascript">
    var i = 0;
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<div class="row dynamicrow mb-3">\
        <div class="col-md-4">\
            <select class="form-select bindingtypes'+i+'" name="addmore['+i+'][binding_type]">\
                <option value="">Select Binding Types</option>\
            </select>\
        </div>\
        <div class="col-md-4">\
            <select class="form-select bookconditions'+i+'" name="addmore['+i+'][condition]">\
                <option value="">Select Book Conditions</option>\
            </select>\
        </div>\
        <div class="col-md-2"><input type="text" name="addmore['+i+'][price]" placeholder="Price" class="form-control inputnum" /></div>\
        <div class="col-md-2"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>\
        </div>');
        $.ajax({
            url: '{{route("common.bindings.all")}}',
            dataType:'JSON',
            type: 'GET',
            success: function(resp){
                var select = $('.bindingtypes'+i).empty();
                select.append( '<option value="">Select Binding Types</option>' ); 
                $.each(resp.bindings, function(index, item) {
                    select.append('<option value="'+ item.name + '">'+item.name+'</option>' ); 
                });
            }
        });
        $.ajax({
            url: '{{route("common.bookconditions.all")}}',
            dataType:'JSON',
            type: 'GET',
            success: function(resp){
                var select = $('.bookconditions'+i).empty();
                select.append( '<option value="">Select Book Conditions</option>' ); 
                $.each(resp.condition_types, function(index, item) {
                    select.append('<option value="'+ item.name + '">'+item.name+'</option>' ); 
                });
            }
        });
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('.dynamicrow').remove();
    });
</script>




 
@endsection 
