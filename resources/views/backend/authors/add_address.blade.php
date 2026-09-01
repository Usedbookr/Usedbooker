<div class="modal form-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 10px;">
          <form class="row gy-4 gx-3" action="{{ route('admin.users.store.address') }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{$edit->id}}" id="user_id">
              <input type="hidden" name="address_id" value="" id="address_id">
              <div class="col-md-6">
                <label  class="form-label">First Name*</label>
                <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter Firstname" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Last Name*</label>
                <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Enter Lastname" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Phone*</label>
                <input type="phone" class="form-control" name="phone" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="phone" placeholder="Enter Phone Number" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Email*</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Flat, House No *</label>
                <input type="text" class="form-control" name="house_no" id="house_no" placeholder="Flat, House No., Building, Apartment, Company" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Street*</label>
                <input type="text" class="form-control" name="street" id="street" placeholder="Enter Street" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">City*</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">State*</label>
                <input type="text" class="form-control" name="state" id="state" placeholder="Enter State" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Country*</label>
                <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Pincode*</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" minlength="5" maxlength="8" placeholder="Enter Pincode" required>
              </div>
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="default" id="default">
                  <label class="form-check-label" for="flexCheckDefault">
                    Make this my default address
                  </label>
                </div>
                </div>
             <div class="col-md-12">
              <button type="submit" class="btn common-btn2" style="background: #FFD731;color: #000;padding: 10px 20px;border-radius: 25px;float: right;margin-bottom: 10px !important;cursor: pointer;">Save Address</button>
             </div>
            </form>
        </div>
  
      </div>
    </div>
  </div>