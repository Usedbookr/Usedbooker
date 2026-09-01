@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blog Comments</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    
                    <div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th style="width: 2%;">Sl</th>
                                <th style="width: 2%;">Blog Name</th>
                                <th style="width: 2%;">Name</th>
                                <th style="width: 2%;">Comments</th>
                                <th style="width: 3%;">Status </th>
                                <th style="width: 4%;">Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                 
                                @foreach($ratings as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->blog_details->name ?? '' }} </td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->comments }} </td>
                                    <td> {{ $item->status }} </td>
                                    <td>
                                        <a href="{{ route('blog.comments.edit',$item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                                        <a href="{{ route('blog.comment.delete',$item->id) }}" data-confirm="Are you delete this Comments?" class="delete btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                        </table>
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


</script>
@endsection
