@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">


            <div id="uploadimageModal" class="modal" role="dialog">
                <div class="modal-dialog cropimg">
                <div class="modal-content">
                <div class="modal-body">
                    <a href="Javascript:void" class="btn-cropclose" onclick="modalclose();"><img src="https://icones.pro/wp-content/uploads/2022/05/icone-fermer-et-x-rouge.png" width="25px"></a>
                
                <div class="row">
                <div class="col-md-12 text-center">
                <div id="image_demo" style="width:100%;"></div>
                
                </div>
                <input type="hidden" id="idval">
                
                   <div class="col-md-12 text-center mb-1">
                   <button type="button" class="btn btn-success crop_image">Upload</button>
                   </div>
                
                </div>
                </div>
                
                
                </div>
                </div>
                </div>

            <h4 class="card-title">Add Books </h4><br><br>
            
  

            <form method="post" action="{{ route('books.store') }}" id="myForm" >
                @csrf
                
                <div class="row mb-3">
                    
                    <div class="col-md-6">
                        <div class="row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Category </label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" name="category" id="category-dropdown" required>
                                    <option value="">Select category</option>
                                    @if($categories)
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Sub Category </label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" id="subcategory-dropdown" name="subcategory" required>
                                    <option value="">-- Select Sub Category --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Child Category </label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" id="childcategory-dropdown" name="childcategory" required>
                                    <option value="">-- Select Child Category --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Author </label>
                            <div class="form-group col-sm-9">
                                <input name="author" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Title </label>
                            <div class="form-group col-sm-9">
                                <input name="name" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Title Long </label>
                            <div class="form-group col-sm-9">
                                <input name="title_long" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Section  </label>
                            <div class="form-group col-sm-9">
                                <input name="section_id[]" value="N" type="checkbox" >New Arrival&nbsp;
                                <input name="section_id[]" value="B" type="checkbox" >Best Seller
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> ISBN </label>
                            <div class="form-group col-sm-9">
                                <input name="isbn" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> ISBN13 </label>
                            <div class="form-group col-sm-9">
                                <input name="isbn13" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Publisher </label>
                            <div class="form-group col-sm-9">
                                <input name="publisher" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Language </label>
                            <div class="form-group col-sm-9">
                                <input name="language" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Date Published  </label>
                            <div class="form-group col-sm-9">
                                <input name="date_published" class="form-control" type="date"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Edition  </label>
                            <div class="form-group col-sm-9">
                                <input name="edition" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Original Price  </label>
                            <div class="form-group col-sm-9">
                                <input name="original_price" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Selling Price  </label>
                            <div class="form-group col-sm-9">
                                <input name="selling_price" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Discount  </label>
                            <div class="form-group col-sm-9">
                                <input name="discount" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  GST Charge  </label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" name="gst_charge">
                                    <option value="0" selected>Without GST</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Pages  </label>
                            <div class="form-group col-sm-9">
                                <input name="pages" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">  Dimensions  </label>
                            <div class="form-group col-sm-9">
                                <input name="pages" class="form-control" type="integer"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">Overview	  </label>
                            <div class="form-group col-sm-9">
                                <input name="overview" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Image</label>
                            <div class="form-group col-sm-9">
                                <input class="form-control" type="file" id="file"  onchange="preview(2)" required>
                                <input type="hidden" name="filetext"  class="form-control" id="profile_images" placeholder="profile_images" >
                                <div id="output2">
                                </div>
                                    <div id="uploaded_image"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">Excerpt	  </label>
                            <div class="form-group col-sm-9">
                                <input name="excerpt" class="form-control" type="number"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label">Synopsis	  </label>
                            <div class="form-group col-sm-9">
                                <input name="synopsis" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Status </label>
                            <div class="form-group col-sm-9">
                                <select class="form-select" aria-label="Default select example" name="status">
                                    <option selected value="1">Active</option>
                                    <option value="0">InActive</option>
                                  </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <h4 class="text-success">Attribute List</h4>
                <div class="col-12 text-center" id="dynamicTable">
                    <div class="row dynamicrow mb-3">
                        <div class="col-md-4">
                            <select class="form-select bindingtypes" aria-label="Default select example" name="addmore[0][binding_type]">
                                <option selected>Select Binding Type</option>
                                @foreach($bindings as $binding)
                                <option value="{{$binding->name}}">{{$binding->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select bookconditions" aria-label="Default select example" name="addmore[0][condition]">
                                <option selected>Select Book Conditions</option>
                                @foreach($condition_types as $condition_types)
                                <option value="{{$condition_types->name}}">{{$condition_types->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="addmore[0][price]" placeholder="Price" class="form-control inputdecimal" />
                        </div>
                        <div class="col-md-2"><a href="javascript::void(0)" name="add" id="add" title="Add More"><i class="btn btn-success mdi mdi-plus"></i></a></div>
                    </div>
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
