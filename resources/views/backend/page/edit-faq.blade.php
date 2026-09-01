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

            <h4 class="card-title">Edit Page </h4><br><br>
            
  

            <form method="post" action="{{ route('pages.update') }}" id="myForm"  enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="id" value="{{ $edit->id }}">
                <div class="row mb-3">
                    
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-12 col-form-label"> Title </label>
                            <div class="form-group col-sm-6">
                                <input name="name" value="{{ $edit->name }}" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    <?php
                        $page_conent = json_decode($edit->details);
                        $count_section = count((array)$page_conent);
                    ?>
                    <h4 class="text-success">FAQ List</h4>
                    <div class="col-12 text-center" id="dynamicTable">
                        @if($page_conent)
                        @foreach($page_conent as $key => $conent)
                        <div class="row mb-3 @if($key != 0) dynamicrow @endif">
                            <div class="col-md-4">
                                <input type="text" name="addmore[{{$key}}][title]" placeholder="Title" value="{{$conent->title}}" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="addmore[{{$key}}][content]" placeholder="Content" value="{{$conent->content}}" class="form-control inputdecimal" />
                            </div>
                            @if($key == 0)
                            <div class="col-md-2"><a href="javascript::void(0)" name="add" id="add" title="Add More"><i class="btn btn-success mdi mdi-plus"></i></a></div>
                            @else
                            <div class="col-md-2"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Name </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_name" value="{{ $edit->meta_name }}" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Description </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_description" value="{{ $edit->meta_description }}" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Meta Keyword </label>
                            <div class="form-group col-sm-9">
                                <input name="meta_keyword" value="{{ $edit->meta_keyword }}" class="form-control" type="text"    >
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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
<script>CKEDITOR.replace( 'details' );</script>
<script type="text/javascript">
    var i = "{{ $count_section - 1 }}";
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<div class="row dynamicrow mb-3">\
        <div class="col-md-4"><input type="text" name="addmore['+i+'][title]" placeholder="Title" class="form-control inputnum" /></div>\
        <div class="col-md-6"><input type="text" name="addmore['+i+'][content]" placeholder="Content" class="form-control inputnum" /></div>\
        <div class="col-md-2"><a href="javascript::void(0)" class="remove-tr" title="Remove"><i class="btn btn-danger mdi mdi-close"></i></a></div>\
        </div>');
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('.dynamicrow').remove();
    });
</script>
 
@endsection 
