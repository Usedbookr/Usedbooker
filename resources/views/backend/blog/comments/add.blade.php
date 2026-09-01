@extends('admin.index')
@section('admin')

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Blog Category </h4><br><br>
            
  
            <form method="post" action="{{ route('blog.category.store') }}" id="myForm" enctype="multipart/form-data">
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
                                    <input name="category_slug" class="form-control" type="text"  value=""  id="url_slug" required>
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
