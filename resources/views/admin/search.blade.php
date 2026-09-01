@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Search Keys</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3">
                            <a href="{{ route('search.result.download') }}" class="btn btn-info">Download Key Word</a>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6"></div>
                    </div>
                 

                    <h4 class="card-title"> Search Keys</h4>
                    

                    <div class="example" id="example">
                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Search Keys</th>
                                        <!--<th>IP Address</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($search_data)
                                    @foreach($search_data as $key => $item)
                                    <tr>
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->key_word }} </td> 
                                        {{-- <td> {{ $item->ip_address }}</td> --}}
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="row gy-4 align-items-center" id="seach_hide" style="margin-top: 30px;">
                            <div class="col-12">
                                {!! $search_data->withQueryString()->links('pagination::bootstrap-5') !!}
                                
                            </div>
                        </div>
        
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

     
        
    </div> <!-- container-fluid -->
</div>
 

@endsection