@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Coupons</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-end gap-2 mb-3">
                                <a href="{{ route('coupons.download')}}"
                                    class="btn btn-success btn-rounded waves-effect waves-light">
                                    <i class="fas fa-file-export me-1"></i> Export
                                </a>

                                <!-- Add Coupon Button -->
                                <a href="{{ route('coupons.add') }}"
                                    class="btn btn-dark btn-rounded waves-effect waves-light">
                                    <i class="fas fa-plus-circle me-1"></i> Add Coupons
                                </a>

                            </div>

                            <h4 class="card-title">Coupons </h4>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Code</th>
                                        <th>Min Amount</th>
                                        <th>Discount</th>
                                        <th>Max Discount Amount</th>
                                        <th>Coupon Use Limit</th>
                                        <th>Status </th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($coupons as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td> {{ $item->amount }} </td>
                                            <td>
                                                @if ($item->amounttype == 'P')
                                                    {{ $item->details }} %
                                                @else
                                                    ₹ {{ $item->details }}
                                                @endif
                                            </td>
                                            <td> {{ $item->maxi_discount }} </td>
                                            {{-- @if ($item->amounttype == 'P')
                                <td> 
                                <button class="btn btn-success">Percentage</button>
                                </td>
                                @else
                                <td> 
                                <button class="btn btn-danger">Flat</button>
                                </td>
                                @endif --}}
                                            <td> {{ $item->limit_user }} </td>
                                            @if ($item->status == 1)
                                                <td>
                                                    <button class="btn btn-success">Active</button>
                                                </td>
                                            @else
                                                <td>
                                                    <button class="btn btn-danger">InActive</button>
                                                </td>
                                            @endif
                                            <td>
                                                <a href="{{ route('coupons.edit', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>
                                                <a href="{{ route('coupons.delete', $item->id) }}"
                                                    class="delete btn btn-danger sm" title="Delete Data" id="delete"
                                                    data-confirm="Are you Sure Delet this Coupon?"> <i
                                                        class="fas fa-trash-alt"></i> </a>
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
