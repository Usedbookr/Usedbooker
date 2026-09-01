@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Update System Setting </h4>
            
            <form method="post" action="{{ route('admin.setting.update', $admin_details->id) }}" enctype="multipart/form-data">
                @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address Line 1</label>
                    <div class="col-sm-12">
                        <input name="address_1" class="form-control" type="text" value="{{ $admin_details->address_1 }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address Line 2</label>
                    <div class="col-sm-12">
                        <input name="address_2" class="form-control" type="text" value="{{ $admin_details->address_2 }}"  id="example-text-input">
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                    <div class="col-sm-12">
                        <input name="city" class="form-control" type="text" value="{{ $admin_details->city }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                    <div class="col-sm-12">
                        <input name="state" class="form-control" type="text" value="{{ $admin_details->state }}"  id="example-text-input">
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                    <div class="col-sm-12">
                        <input name="country" class="form-control" type="text" value="{{ $admin_details->country }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Zipcode</label>
                    <div class="col-sm-12">
                        <input name="zip_code" class="form-control" type="text" value="{{ $admin_details->zip_code ?? '' }}"  id="example-text-input" required>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Phone Number</label>
                    <div class="col-sm-12">
                        <input name="phone" class="form-control" type="text" value="{{ $admin_details->phone }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Email Address</label>
                    <div class="col-sm-12">
                        <input name="email" class="form-control" type="email" value="{{ $admin_details->email }}"  id="example-text-input" required>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Facebook</label>
                    <div class="col-sm-12">
                        <input name="facebook" class="form-control" type="text" value="{{ $admin_details->facebook }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Linkedin</label>
                    <div class="col-sm-12">
                        <input name="twitter" class="form-control" type="text" value="{{ $admin_details->twitter }}"  id="example-text-input" required>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Instagram</label>
                    <div class="col-sm-12">
                        <input name="instagram" class="form-control" type="text" value="{{ $admin_details->instagram }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Youtube</label>
                    <div class="col-sm-12">
                        <input name="pinterest" class="form-control" type="text" value="{{ $admin_details->pinterest }}"  id="example-text-input" required>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">GST Number</label>
                    <div class="col-sm-12">
                        <input name="gst_number" class="form-control" type="text" value="{{ $admin_details->gst_number }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Cash on Delivery Charge</label>
                    <div class="col-sm-12">
                        <input name="cod_charge" class="form-control" type="text" value="{{ $admin_details->cod_charge }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Referral Receiver Amount</label>
                    <div class="col-sm-12">
                        <input name="referral_receiver_amount" class="form-control" type="text" value="{{ $admin_details->referral_receiver_amount }}"  id="example-text-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Referral Sender Amount</label>
                    <div class="col-sm-12">
                        <input name="referral_sender_amount" class="form-control" type="text" value="{{ $admin_details->referral_sender_amount }}"  id="example-text-input" required>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">

                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Min Weight <span style="font-size: 10px;">(Gram)</span></label>
                    <div class="col-sm-12">
                        <input name="min_weight" class="form-control" type="text" value="{{ $admin_details->min_weight }}"  id="example-text-input" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Weight Amount</label>
                    <div class="col-sm-12">
                        <input name="weight_amount" class="form-control" type="text" value="{{ $admin_details->weight_amount }}"  id="example-text-input" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Meta Name</label>
                    <div class="col-sm-12">
                        <input name="meta_name" class="form-control" type="text" value="{{ $admin_details->meta_name }}"  id="example-text-input" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Meta Description</label>
                    <div class="col-sm-12">
                        <input name="meta_description" class="form-control" type="text" value="{{ $admin_details->meta_description }}"  id="example-text-input" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Meta Keyword</label>
                    <div class="col-sm-12">
                        <input name="meta_keyword" class="form-control" type="text" value="{{ $admin_details->meta_keyword }}"  id="example-text-input" required>
                    </div>
                </div>

            </div>
            <!-- end row -->

            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Setting">

            </form>
             
        </div>
    </div>
</div> <!-- end col -->
</div>
 


</div>
</div>


<script type="text/javascript">
    
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

@endsection 
