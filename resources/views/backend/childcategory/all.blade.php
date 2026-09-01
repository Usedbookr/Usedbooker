@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Child Categories</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{ route('childcategories.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Child Category </a> <br>  <br>               

                    <h4 class="card-title">Categories </h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Sub Category</th> 
                            <th>Name</th> 
                            <th>Image</th> 
                            <th>Status </th>
                            <th>Action</th>
                            
                        </thead>


                        <tbody>
                        	 
                        	@foreach($categories as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td>
                                <?php
                                    $category_name = \App\Models\Category::where('parent_id', $item->parent_id)->first();
                                    // dd($category_name);
                                ?>  
                                {{ $category_name->name ?? '' }}
                            </td>
                            <td> {{ $item->name }} </td> 
                            <td> @if($item->images) <img src="{{ asset($item->images) }}" width="200" /> @endif </td> 
                              
                                @if($item->status == 1)
                            <td> 
                            <button class="btn btn-success">Active</button>
                            </td>
                                @else
                                <td> 
                                    <button class="btn btn-danger">InActive</button>
                                    </td>
                                    @endif
                                    <td>
                               
   <a href="{{ route('childcategories.edit',$item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

     <a href="{{ route('childcategories.delete',$item->id) }}" class="delete btn btn-danger sm" title="Delete Data" id="delete" data-confirm="Are you Sure Delet this Child Categories?">  <i class="fas fa-trash-alt"></i> </a>

                            </td>
                           
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        
                     
                        
                    </div> <!-- container-fluid -->
                </div>
 
<script>
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
            </script>
@endsection