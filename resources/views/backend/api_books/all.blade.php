@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Books</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{ route('books.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Book </a> <br>  <br>               

                    <h4 class="card-title"> Books</h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th> 
                            <th>ISBN</th> 
                            <th>Action</th>
                        </tr>
                            
                        </thead>


                        <tbody>
                        	 
                            
                        	@foreach($books as $key => $item)
                           
                                
                           
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{substr($item['title'],0,20) }}...</td>
                                <td>{{ $item['isbn'] }}</td>
                                <td>
                               
                                    <a href="{{ route('book_api.edit',$item['isbn']) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>
                                 
                                 
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
 

@endsection