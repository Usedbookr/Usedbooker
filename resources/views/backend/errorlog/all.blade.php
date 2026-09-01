@extends('admin.admin_master')

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <h4 class="mb-sm-0">
                        API / Application Logs
                    </h4>

                </div>

            </div>
        </div>


        <!-- Filters -->
        <div class="card">
            <div class="card-body">

                <form method="GET"
                      action="{{ route('admin.api.logs') }}">

                    <div class="row g-3">

                        <!-- Search -->
                        <div class="col-md-4">

                            <label class="form-label">
                                Search
                            </label>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Module, service, endpoint, error..."
                                value="{{ request('search') }}"
                            >

                        </div>


                        <!-- Status -->
                        <div class="col-md-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                    class="form-control">

                                <option value="">
                                    All Status
                                </option>

                                <option value="Success"
                                    {{ request('status') == 'Success' ? 'selected' : '' }}>
                                    Success
                                </option>

                                <option value="Failed"
                                    {{ request('status') == 'Failed' ? 'selected' : '' }}>
                                    Failed
                                </option>

                                <option value="success"
                                    {{ request('status') == 'success' ? 'selected' : '' }}>
                                    success
                                </option>

                                <option value="failed"
                                    {{ request('status') == 'failed' ? 'selected' : '' }}>
                                    failed
                                </option>

                            </select>

                        </div>


                        <!-- Module -->
                        <div class="col-md-3">

                            <label class="form-label">
                                Module
                            </label>

                            <select name="module"
                                    class="form-control">

                                <option value="">
                                    All Modules
                                </option>

                                @foreach($modules as $module)

                                    <option value="{{ $module }}"
                                        {{ request('module') == $module ? 'selected' : '' }}>

                                        {{ $module }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- Buttons -->
                        <div class="col-md-2 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-primary me-2">

                                Search

                            </button>

                            <a href="{{ route('admin.api.logs') }}"
                               class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        <!-- Logs Table -->
        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 class="card-title mb-0">
                        Application Logs
                    </h4>

                    <span class="badge bg-primary">
                        Total: {{ $apiLogs->total() }}
                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>

                                <th>Module</th>

                                <th>Service</th>

                                <th>Method</th>

                                <th>Endpoint</th>

                                <th>Reference</th>

                                <th>HTTP</th>

                                <th>Status</th>

                                <th>Error</th>

                                <th>Date</th>

                                <th width="80">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($apiLogs as $key => $log)

                            <tr>

                                <!-- ID -->
                                <td>
                                    {{ $log->id }}
                                </td>


                                <!-- Module -->
                                <td>

                                    <span class="badge bg-info">

                                        {{ $log->module }}

                                    </span>

                                </td>


                                <!-- Service -->
                                <td>
                                    {{ $log->service }}
                                </td>


                                <!-- Method -->
                                <td>

                                    @if($log->request_type == 'GET')

                                        <span class="badge bg-primary">
                                            GET
                                        </span>

                                    @elseif($log->request_type == 'POST')

                                        <span class="badge bg-success">
                                            POST
                                        </span>

                                    @elseif($log->request_type == 'PUT')

                                        <span class="badge bg-warning text-dark">
                                            PUT
                                        </span>

                                    @elseif($log->request_type == 'DELETE')

                                        <span class="badge bg-danger">
                                            DELETE
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $log->request_type }}
                                        </span>

                                    @endif

                                </td>


                                <!-- Endpoint -->
                                <td>

                                    <code>
                                        {{ $log->endpoint }}
                                    </code>

                                </td>


                                <!-- Reference -->
                                <td>

                                    @if($log->reference_type)

                                        <strong>
                                            {{ $log->reference_type }}
                                        </strong>

                                        <br>

                                        <small>
                                            {{ $log->reference_id }}
                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>


                                <!-- HTTP Status -->
                                <td>

                                    @if($log->http_status >= 200 &&
                                        $log->http_status < 300)

                                        <span class="badge bg-success">

                                            {{ $log->http_status }}

                                        </span>

                                    @elseif($log->http_status >= 400)

                                        <span class="badge bg-danger">

                                            {{ $log->http_status }}

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            {{ $log->http_status }}

                                        </span>

                                    @endif

                                </td>


                                <!-- Status -->
                                <td>

                                    @if(
                                        strtolower($log->status) == 'success'
                                    )

                                        <span class="badge bg-success">
                                            Success
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Failed
                                        </span>

                                    @endif

                                </td>


                                <!-- Error -->
                                <td style="max-width:250px;">

                                    @if($log->error_message)

                                        <span
                                            title="{{ $log->error_message }}">

                                            {{ \Illuminate\Support\Str::limit(
                                                $log->error_message,
                                                60
                                            ) }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- Date -->
                                <td>

                                    <small>

                                        {{ $log->created_at
                                            ? $log->created_at->format('d M Y H:i:s')
                                            : '-' }}

                                    </small>

                                </td>


                                <!-- Action -->
                                <td>

                                    <a href="{{ route(
                                        'admin.api.log.details',
                                        $log->id
                                    ) }}"
                                       class="btn btn-sm btn-primary"
                                       title="View Details">

                                        <i class="fa fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11"
                                    class="text-center py-4">

                                    <div class="text-muted">

                                        No API logs found.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- Pagination -->
                <div class="mt-3">

                    {{ $apiLogs->links('pagination::bootstrap-5') }}

                </div>

            </div>

        </div>

    </div>
</div>

@endsection