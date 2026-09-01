@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Blog Author </h4><br><br>
            
  
            <form method="post" action="{{ route('blog.author.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    
                    <div class="col-md-6">

                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Title </label>
                                <div class="form-group col-sm-9">
                                    <input name="name" class="form-control" type="text" id="cat_id_name"  onkeyup="CatogeryUrl()" >
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Category Slug </label>
                                <div class="form-group col-sm-9">
                                    <input name="author_slug" class="form-control" type="text"  value=""  id="url_slug" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label"> Status </label>
                                <div class="form-group col-sm-9">
                                    <select class="form-select" aria-label="Default select example" name="status">
                                        <option value="Active">Active</option>
                                        <option value="InActive">InActive</option>
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
