@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Blog Category </h4><br><br>
            
  
            <form method="post" action="{{ route('blog.category.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    
                    <div class="col-md-6">
                        <input type="hidden" name="id" value="{{ $ratingreview->id }}">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Title </label>
                                <div class="form-group col-sm-9">
                                    <input name="name" class="form-control" type="text" id="cat_id_name" value="{{ $ratingreview->name }}"  onkeyup="CatogeryUrl()" >
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Category Slug </label>
                                <div class="form-group col-sm-9">
                                    <input name="category_slug" class="form-control" type="text"  value="{{ $ratingreview->category_slug }}"  id="url_slug" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Status </label>
                                <div class="form-group col-sm-9">
                                    <select class="form-select" aria-label="Default select example" name="status">
                                        <option value="Active" @if($ratingreview->status == "Active") selected @endif>Active</option>
                                        <option value="InActive" @if($ratingreview->status == "InActive") selected @endif>InActive</option>
                                      </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    
                    {{-- <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Name </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_name" class="form-control" type="text" id="meta_name_id" onkeyup="CatogeryUrl1()"   >
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Description </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_description" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Keyword </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_keyword" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div> --}}
                    
                </div>
                                
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
    
</script>



<script>  

    $(document).ready(function(){
        $("#selling_price").keyup(function(){
            var original_price = $("#original_price").val();
            var selling_price = $("#selling_price").val();
            if(original_price)
            {
                var percent = ((original_price - selling_price)*100) / original_price;
                percent = parseFloat(percent).toFixed(2);
            }
            $("#discount").val(percent);
        });
    });
    
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
        <div class="col-md-2">\
            <select class="form-select bookconditions'+i+'" name="addmore['+i+'][condition]">\
                <option value="">Select Book Conditions</option>\
            </select>\
        </div>\
        <div class="col-md-3">\
            <input type="file" name="addmore['+i+'][images][]" class="form-control" multiple>\
        </div>\
        <div class="col-md-2"><input type="text" name="addmore['+i+'][price]" placeholder="Price" class="form-control inputnum" /></div>\
        <div class="col-md-2"><input type="text" name="addmore['+i+'][stock]" placeholder="Stock" class="form-control inputnum" /></div>\
        <div class="col-md-2">\
            <input type="text" name="addmore['+i+'][book_weight]" placeholder="Weight (gram)" class="form-control inputdecimal" />\
        </div>\
        <div class="col-md-1"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>\
        </div>');
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

<style type="text/css">
  #files-area{
  margin: 0 auto;
}
.file-block{
  border-radius: 10px;
  background-color: rgba(144, 163, 203, 0.2);
  margin: 5px;
  color: initial;
  display: inline-flex;
  font-size: 10px;
  padding: 0px 4px;
}
.file-block > span.name{
    padding-right: 6px;
    width: max-content;
    display: inline-flex;
    padding-top: 4px;
  }
.file-delete{
  display: flex;
  width: 15px;
  color: initial;
  background-color: #6eb4ff00;
  font-size: 15px;
  justify-content: center;
  margin-right: 3px;
  cursor: pointer;
}
.file-delete > span{
    transform: rotate(45deg);
  }
.file-delete:hover{
    background-color: rgba(144, 163, 203, 0.2);
    border-radius: 10px;
  }
</style>
<script type="text/javascript">
const dt = new DataTransfer();

$("#images").on('change', function(e){
  $('#files-area').show();
  for(var i = 0; i < this.files.length; i++){
    let fileBloc = $('<span/>', {class: 'file-block'}),
       fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
    fileBloc.append('<span class="file-delete"><span>+</span></span>')
      .append(fileName);
    $("#filesList > #files-names").append(fileBloc);
  };
  
  for (let file of this.files) {
    dt.items.add(file);
  }
  
  this.files = dt.files;

  $('span.file-delete').click(function(){
    let name = $(this).next('span.name').text();
    $(this).parent().remove();
    for(let i = 0; i < dt.items.length; i++){
      if(name === dt.items[i].getAsFile().name){
        dt.items.remove(i);
        continue;
      }
    }
    document.getElementById('attachment').files = dt.files;
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
