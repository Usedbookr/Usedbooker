@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="page-content">
<div class="container-fluid">

<style type="text/css">
    body #cke_notifications_area_editor1,
    body .cke_notifications_area {
      display: none !important;
    }
</style>
<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Blog </h4><br><br>
            
  
            <form method="post" action="{{ route('blog.store') }}" id="myForm" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Select Author </label>
                            <div class="form-group col-sm-9">
                                <select class="form-select" aria-label="Default select example" name="author_id">
                                    <option value="">Select Author</option>
                                    @if(count($blog_author) > 0)
                                    @foreach($blog_author as $key => $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                    @endif

                                  </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Select Category </label>
                            <div class="form-group col-sm-9">
                                <select class="form-select" aria-label="Default select example" name="category_id">
                                    <option value="">Select Category</option>
                                    @if(count($blog_category) > 0)
                                    @foreach($blog_category as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif

                                  </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Title </label>
                            <div class="form-group col-sm-9">
                                <input name="name" class="form-control" type="text" id="cat_id_name"  onkeyup="CatogeryUrl()" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Blog Slug </label>
                            <div class="form-group col-sm-9">
                                <input name="author_slug" class="form-control" type="text"  value=""  id="url_slug" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Short Description <span style="font-size: 12px;color: red;">(Maximun 25 Charcter only)</span> </label>
                            <div class="form-group col-sm-9">
                                <input name="short_description" class="form-control" type="text"  value=""  id="short_description" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-3 col-form-label"> Blog Image </label>
                            <div class="form-group col-sm-9">
                                <input name="blog_image" class="form-control" type="file"  value=""  id="blog_image">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <label for="example-text-input" class="col-sm-3 col-form-label"> Description </label>
                        <textarea name="description" id="summernote" class="form-control" cols="200" rows="20"></textarea>
                        <!--<textarea name="editor1" id="editor1" rows="10" cols="80"></textarea>-->
                    </div>
                    
                    <div class="col-md-6">
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
                    
                    <div class="col-md-6">
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

<script>
    $('textarea#summernote').summernote({
      placeholder: 'Description',
      tabsize: 2,
      height: 250,
      toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
    ],
    });
</script>

@endsection 
