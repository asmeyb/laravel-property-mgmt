@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2> Withdraw Details </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Withdraw Details</span></li>
            </ol>
        </div>
    </header>

    <div class="row g-4">

        <!--- Left Colum --->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"> {{ ucfirst($details->payment_type) }} Withdraw</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Date:</strong> </span>
                            <span>{{ $details->created_at->format('Y-m-d h:i A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Transaction Number:</strong> </span>
                            <span>{{ $details->trx ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>User Name:</strong> </span>
                            <span>{{ $details->user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Property :</strong> </span>
                            <span>{{ $details->property->title }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Method:</strong> </span>
                            <span>{{ ucfirst(str_replace('_', ' ',$details->payment_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Amount:</strong> </span>
                            <span>{{ $details->withdraw_amount }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Status:</strong> </span>
                            <span class="badge bg-warning">{{ ucfirst($details->status) }}</span>
                        </li>

                    </ul>

                </div>
            </div>
        </div>

        <!--- Right Colum --->

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"> User Withdraw Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>First Name:</strong> </span>
                            <span>{{ $details->user->first_name ?? 'N/A'}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Last Name:</strong> </span>
                            <span>{{ $details->user->last_name ?? 'N/A'}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>User Image:</strong> </span>
                            <img src="{{ (!empty($details->user->photo)) ? url('upload/profile_images/'.$details->user->photo) : url('upload/no_image.jpg') }}"
                                class="rounded-circle avatar-xl" style="width: 100px; height:100px;">
                        </li>
                    </ul>

                    <form action="{{ route('admin.withdraw.approve',$details->id) }}" method="POST">
                        @csrf

                        @if ($details->status != 'approved' )
                        <button type="submit" name="action" value="approved" class="btn btn-success">Approve</button>
                        @endif

                        <button type="submit" name="action" value="rejected" class="btn btn-danger">Reject</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection