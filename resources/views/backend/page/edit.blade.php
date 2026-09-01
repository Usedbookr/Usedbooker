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
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Title </label>
                            <div class="form-group col-sm-9">
                                <input name="name" value="{{ $edit->name }}" class="form-control" type="text"    >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">  Pages  </label>
                            <div class="form-group col-sm-9">
                                <textarea name="details" id="editor" class="form-control" rows="10"   >{{ $edit->details }}</textarea>
                            </div>
                        </div>
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

 
@endsection 
