@extends('admin.admin_master')

@section('admin')

<div class="page-content">

    <div class="container-fluid">


        <!-- Page Title -->
        <div class="row">

            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <h4 class="mb-sm-0">
                        API Log Details
                    </h4>

                    <a href="{{ route('admin.api.logs') }}"
                       class="btn btn-secondary">

                        <i class="fa fa-arrow-left"></i>
                        Back

                    </a>

                </div>

            </div>

        </div>


        <!-- Main Information -->
        <div class="card">

            <div class="card-body">

                <h4 class="card-title mb-4">
                    Log #{{ $apiLog->id }}
                </h4>


                <div class="row">


                    <!-- Module -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Module
                        </label>

                        <div>
                            <span class="badge bg-info">

                                {{ $apiLog->module }}

                            </span>
                        </div>

                    </div>


                    <!-- Service -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Service
                        </label>

                        <div>
                            {{ $apiLog->service }}
                        </div>

                    </div>


                    <!-- Status -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Status
                        </label>

                        <div>

                            @if(strtolower($apiLog->status) == 'success')

                                <span class="badge bg-success">
                                    Success
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Failed
                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- Request Type -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Request Type
                        </label>

                        <div>
                            <code>
                                {{ $apiLog->request_type }}
                            </code>
                        </div>

                    </div>


                    <!-- Endpoint -->
                    <div class="col-md-8 mb-3">

                        <label class="fw-bold">
                            Endpoint
                        </label>

                        <div>
                            <code>
                                {{ $apiLog->endpoint }}
                            </code>
                        </div>

                    </div>


                    <!-- Request URL -->
                    <div class="col-md-12 mb-3">

                        <label class="fw-bold">
                            Request URL
                        </label>

                        <div class="bg-light p-3 rounded">

                            {{ $apiLog->request_url }}

                        </div>

                    </div>


                    <!-- IP -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            IP Address
                        </label>

                        <div>
                            {{ $apiLog->ip_address ?? '-' }}
                        </div>

                    </div>


                    <!-- User Agent -->
                    <div class="col-md-8 mb-3">

                        <label class="fw-bold">
                            User Agent
                        </label>

                        <div>
                            {{ $apiLog->user_agent ?? '-' }}
                        </div>

                    </div>


                    <!-- Reference Type -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Reference Type
                        </label>

                        <div>
                            {{ $apiLog->reference_type ?? '-' }}
                        </div>

                    </div>


                    <!-- Reference ID -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Reference ID
                        </label>

                        <div>
                            {{ $apiLog->reference_id ?? '-' }}
                        </div>

                    </div>


                    <!-- HTTP Status -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            HTTP Status
                        </label>

                        <div>

                            @if($apiLog->http_status >= 200 &&
                                $apiLog->http_status < 300)

                                <span class="badge bg-success">

                                    {{ $apiLog->http_status }}

                                </span>

                            @elseif($apiLog->http_status >= 400)

                                <span class="badge bg-danger">

                                    {{ $apiLog->http_status }}

                                </span>

                            @else

                                <span class="badge bg-warning text-dark">

                                    {{ $apiLog->http_status }}

                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- Execution Time -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Execution Time
                        </label>

                        <div>

                            {{ $apiLog->execution_time_ms ?? 0 }}
                            ms

                        </div>

                    </div>


                    <!-- Created -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Created At
                        </label>

                        <div>

                            {{ $apiLog->created_at
                                ? $apiLog->created_at->format('d M Y H:i:s')
                                : '-' }}

                        </div>

                    </div>


                    <!-- Updated -->
                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Updated At
                        </label>

                        <div>

                            {{ $apiLog->updated_at
                                ? $apiLog->updated_at->format('d M Y H:i:s')
                                : '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Error Message -->
        @if($apiLog->error_message)

        <div class="card">

            <div class="card-body">

                <h4 class="card-title text-danger">
                    Error Message
                </h4>

                <div class="alert alert-danger">

                    {{ $apiLog->error_message }}

                </div>

            </div>

        </div>

        @endif


        <!-- Request Payload -->
        <div class="card">

            <div class="card-body">

                <h4 class="card-title">
                    Request Payload
                </h4>

                <pre class="bg-dark text-light p-3 rounded"
                     style="white-space: pre-wrap; word-break: break-word;">{{ 
                        is_string($apiLog->request_payload)
                            ? $apiLog->request_payload
                            : json_encode(
                                $apiLog->request_payload,
                                JSON_PRETTY_PRINT |
                                JSON_UNESCAPED_UNICODE |
                                JSON_UNESCAPED_SLASHES
                            )
                }}</pre>

            </div>

        </div>


        <!-- Response Payload -->
        <div class="card">

            <div class="card-body">

                <h4 class="card-title">
                    Response Payload
                </h4>

                <pre class="bg-dark text-light p-3 rounded"
                     style="white-space: pre-wrap; word-break: break-word;">{{ 
                        is_string($apiLog->response_payload)
                            ? $apiLog->response_payload
                            : json_encode(
                                $apiLog->response_payload,
                                JSON_PRETTY_PRINT |
                                JSON_UNESCAPED_UNICODE |
                                JSON_UNESCAPED_SLASHES
                            )
                }}</pre>

            </div>

        </div>


    </div>

</div>

@endsection