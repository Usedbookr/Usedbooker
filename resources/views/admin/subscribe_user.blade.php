@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Subscribe User</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Subscribe User</h4>
                    

                        <div class="example" id="example">
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Search Keys</th>
                            </tr> 
                            </thead>


                            <tbody>
                            @if($search_data)
                            @foreach($search_data as $key => $item)
                            <tr>
                                <td> {{ $key+1}} </td>
                                <td> {{ $item->email_address }} </td> 
                                    
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

     
        
    </div> <!-- container-fluid -->
</div>
 

@endsection