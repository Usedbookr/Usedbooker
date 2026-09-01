@extends('admin.admin_master')
@section('admin')

@include('backend.authors.add_address')

 <div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-6">
                
            </div>
            <div class="col-6">
                <div class="page-title-box">
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" class="mb-sm-0" style="background: #FFD731;color: #000;padding: 10px 20px;border-radius: 25px;float: right;margin-bottom: 10px !important;cursor: pointer;">Add Address</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Customer Details</h4>
                        <P>
                            <strong>Name : </strong>{{$edit->name}}<br/>
                            <strong>Email  : </strong>{{$edit->email}}<br/>
                            <strong>Mobile No. : </strong>{{$edit->phone_number}}<br/>
                        </P>
                    </div>
                </div>
            </div>
            <div class="col-6">
                
            </div>
            
        </div>
                        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Orders</h4>
    
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="width-10">Sl</th>
                                <th>Name</th>
                                <th>Phone</th> 
                                <th>Email</th>
                                <th>Flat, House No</th>
                                <th>Street</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Pincode</th>
                                <th>Default</th>
                                <th>Action</th>
                            </thead>
    
    
                            <tbody>
                            
                            @if($user_address)
                            @foreach($user_address as $key => $value)
                            
                            <tr>
                                <td> {{ $key + 1 }} </td>
                                <td> {{ $value->first_name }} {{ $value->last_name }} </td> 
                                <td> {{ $value->phone }} </td>
                                <td> {{ $value->email }} </td>
                                <td> {{ $value->house_no }} </td> 
                                <td> {{ $value->street }} </td> 
                                <td> {{ $value->city }} </td>
                                <td> {{ $value->state }} </td>
                                <td> {{ $value->country }} </td>
                                <td> {{ $value->zipcode }} </td>
                                <td> 
                                    @if($value->is_default == "on")
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>
                                    <p style="display: flex;">
                                        <a onclick="address_edit('{{ $value->id }}')" class="btn btn-info sm" title="Edit Data" style="padding: 7px 11px;margin-right: 10px;">  <i class="fas fa-edit"></i> </a>
                                        <a href="{{ route('users.address.delete',$value->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete" style="padding: 7px 11px;margin-right: 10px;">  <i class="fas fa-trash-alt"></i> </a>
                                    </p>
                                </td>
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
 
    <script>
        function address_edit(ref) {
            var SITE_URL   = "{{ url('/')}}";
            var address_id = ref;
            $.ajax({
                url: SITE_URL+"/admin/users/admin-edit-address/"+address_id,
                type: 'get',
                success: function(msg) 
                {
                    // console.log(msg.user_address.city);
                    if(msg.success == 'success'){
                        $('#address_id').val(msg.user_address.id);
                        $('#f_name').val(msg.user_address.first_name);
                        $('#l_name').val(msg.user_address.last_name);
                        $('#phone').val(msg.user_address.phone);
                        $('#email').val(msg.user_address.email);
                        $('#street').val(msg.user_address.street);
                        $('#city').val(msg.user_address.city);
                        $('#state').val(msg.user_address.state);
                        $('#country').val(msg.user_address.country);
                        $('#zipcode').val(msg.user_address.zipcode);
                        $('#house_no').val(msg.user_address.house_no);
                        if (msg.user_address.is_default == "on") {
                            $('#default').attr('checked', true);
                        }
                        else
                        {
                            $('#default').removeAttr('checked', true);
                        }
                        $('#exampleModal').modal('show');
                    }
                }
            });
        }
    </script>
@endsection