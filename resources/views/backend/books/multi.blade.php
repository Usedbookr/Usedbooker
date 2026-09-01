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

            <h4 class="card-title">Edit Books </h4><br><br>
            
  

            <form method="post" action="{{ route('books.update.multi') }}" id="myForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $book_details->id }}">
                
                <h4 class="text-success">Attribute List</h4>
                <div class="col-12 text-center" id="dynamicTable">
                    
                    @if($BookVarient->isNotEmpty())
                        @foreach($BookVarient as $key => $varient)
                        <?php
                            $multiple_images = json_decode($varient->images);
                            // dd($multiple_images);
                        ?>
                        <div class="row dynamicrow mb-3">
                            
                            <div class="col-md-3">
                                <select class="form-select bookconditions" aria-label="Default select example" name="addmore[{{$key}}][condition]">
                                    <option selected>Select Book Conditions</option>
                                    @foreach($condition_types as $condition_type)
                                    <option value="{{$condition_type->name}}" {{$condition_type->name==$varient->bookconditions?'selected':''}}>{{$condition_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="addmore[{{$key}}][images][]" class="form-control" multiple>
                                @if($varient->images)
                                    <input type="hidden" name="addmore[{{$key}}][hidden]" value="{{ $varient->images }}">
                                @endif
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="addmore[{{$key}}][price]" value="{{$varient->price}}" placeholder="Price" class="form-control inputdecimal" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="addmore[{{$key}}][stock]" value="{{$varient->stock}}" placeholder="Stock" class="form-control" />
                            </div>
                            @if($key == 0)
                            <div class="col-md-2"><a href="javascript::void(0)" name="add" id="add" title="Add More"><i class="btn btn-success mdi mdi-plus"></i></a></div>
                            @else
                            <div class="col-md-2"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>
                            @endif
                            <div class="row" style="margin-top: 10px;">
                                @if($multiple_images)
                                @foreach($multiple_images as $key => $image)
                                <div class="col-md-2">
                                    <img src="{{ asset('') }}public/images/{{ $image }}" alt="" style="width: 100px;height: 100px;">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-12 text-center" id="dynamicTable">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-select bookconditions" aria-label="Default select example" name="addmore[0][condition]">
                                    <option selected>Select Book Conditions</option>
                                    @foreach($condition_types as $condition_types)
                                    <option value="{{$condition_types->name}}">{{$condition_types->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="addmore[0][images][]" class="form-control" multiple>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="addmore[0][price]" placeholder="Price" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="addmore[0][stock]" placeholder="Stock" class="form-control inputdecimal" />
                            </div>
                            <div class="col-md-2"><a href="javascript::void(0)" name="add" id="add" title="Add More"><i class="btn btn-success mdi mdi-plus"></i></a></div>
                        </div>
                    </div>
                    @endif
                    
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
    var i = "{{ count($BookVarient) }}";
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<div class="row dynamicrow mb-3">\
        <div class="col-md-3">\
            <select class="form-select bookconditions'+i+'" name="addmore['+i+'][condition]">\
                <option value="">Select Book Conditions</option>\
            </select>\
        </div>\
        <div class="col-md-3">\
            <input type="file" name="addmore['+i+'][images][]" class="form-control" multiple>\
        </div>\
        <div class="col-md-2"><input type="text" name="addmore['+i+'][price]" placeholder="Price" class="form-control inputnum" /></div>\
        <div class="col-md-2"><input type="text" name="addmore['+i+'][stock]" placeholder="Stock" class="form-control inputnum" /></div>\
        <div class="col-md-2"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>\
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

<script type="text/javascript">


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
