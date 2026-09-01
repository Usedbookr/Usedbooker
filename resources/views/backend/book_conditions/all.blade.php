@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Book Conditions</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{ route('book_conditions.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Condition </a> <br>  <br>               

                    <h4 class="card-title"> Book Conditions</h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th> 
                            <th>Status </th>
                            <th>Action</th>
                            
                        </thead>


                        <tbody>
                        	 
                        	@foreach($conditions as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $item->name }} </td> 
                              
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
                               
   <a href="{{ route('book_conditions.edit',$item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

     <a href="{{ route('book_conditions.delete',$item->id) }}" class="delete btn btn-danger sm" title="Delete Data" id="delete" data-confirm="Are you Sure Delet this Book Conditions?">  <i class="fas fa-trash-alt"></i> </a>

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