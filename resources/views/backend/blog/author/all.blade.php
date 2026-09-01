@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blog Author</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{route('blog.author.add')}}" class="btn btn-info">Add Blog Author</a>
                        </div>
                        <div class="col-md-8"></div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="text_value_search" id="text_value_search" class="form-control" onkeyup="text_value_search()">
                        </div> --}}
                    </div>
                    <br>
                    <div class="example" id="example">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th style="width: 2%;">Sl</th>
                                <th style="width: 2%;">Name</th>
                                <th style="width: 3%;">Status </th>
                                <th style="width: 4%;">Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                 
                                @foreach($ratings as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->status }} </td>
                                    <td>
                                        <a href="{{ route('blog.author.edit',$item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                                        <a href="{{ route('blog.author.delete',$item->id) }}" data-confirm="Are you delete this Category?" class="delete btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                        </table>
                        {{-- <div class="row gy-4 align-items-center" id="seach_hide" style="margin-top: 30px;">
                            <div class="col-12">
                                {!! $ratings->withQueryString()->links('pagination::bootstrap-5') !!}
                                
                            </div>
                        </div> --}}
                    </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        
        
    </div> <!-- container-fluid -->
</div>
<?php
    $current_route = Route::currentRouteName();
?>
<script type="text/javascript">
    var deleteLinks = document.querySelectorAll('.delete');

    for (var i = 0; i < deleteLinks.length; i++) {
      deleteLinks[i].addEventListener('click', function(event) {
          event.preventDefault();

          var choice = confirm(this.getAttribute('data-confirm'));

          if (choice) {
            window.location.href = this.getAttribute('href');
          }
      });
    }

    function text_value_search()
    {
        var text_value_search = $("#text_value_search").val();

        if (text_value_search) {
            $.ajax({
                url: "{{ route('admin.book.search') }}",
                type: "POST",
                data: {
                    text_value_search: text_value_search,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    
                    if (response.status) 
                    {
                        $("#example").html(response.project);
                        $("#seach_hide").hide();
                    }
                }
            });
        }

    }

    function ExcelDownload()
    {

        var select_download = $("#select_download").val();
        var expert_search_url1 = "{{ url('/') }}/admin/book-categories/"+select_download;
        if (expert_search_url1) 
        {
            $('#image_url').attr('href', expert_search_url1);
        }
        

    }

</script>
@endsection