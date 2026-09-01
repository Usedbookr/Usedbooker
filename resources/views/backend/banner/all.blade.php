@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Banners</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{ route('banners.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Banner </a> <br>  <br>               

                    <h4 class="card-title">Banners </h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Banner Type</th> 
                            <th>Name</th> 
                            <th>Image</th> 
                            <th>Action</th>
                            
                        </thead>


                        <tbody>
                        	 
                        	@foreach($banners as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> @if($item->btype=='S') Slider @elseif($item->btype=='M') Mobile Banner @elseif($item->btype=='T') Top Banner @else Bottom Banner @endif </td>
                            <td> {{ $item->name }} </td> 
                            <td> @if($item->images) <img src="{{ asset($item->images) }}" width="200" /> @endif </td>
                            <td><a href="{{ route('banners.delete',$item->id) }}" class="delete btn btn-danger sm" title="Delete Data" id="delete" data-confirm="Are you Sure Delete this Banner?">  <i class="fas fa-trash-alt"></i> </a></td>
                           
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