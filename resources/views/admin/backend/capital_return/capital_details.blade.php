@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Capital Return Details </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Capital Return Details</span></li>
            </ol>
        </div>
    </header>

    <div class="row g-4">

        <!--- Left Colum --->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"> {{ ucfirst($capitalreturns->payment_type) }} Withdraw</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Date:</strong> </span>
                            <span>{{ $capitalreturns->created_at->format('Y-m-d h:i A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Transaction Number:</strong> </span>
                            <span>{{ $capitalreturns->trx ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>User Name:</strong> </span>
                            <span>{{ $capitalreturns->user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Property :</strong> </span>
                            <span>{{ $capitalreturns->property->title }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Method:</strong> </span>
                            <span>{{ ucfirst(str_replace('_', ' ',$capitalreturns->payment_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Amount:</strong> </span>
                            <span>{{ $capitalreturns->withdraw_amount }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Status:</strong> </span>
                            <span class="badge bg-warning">{{ ucfirst($capitalreturns->status) }}</span>
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
                            <span>{{ $capitalreturns->user->first_name ?? 'N/A'}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Last Name:</strong> </span>
                            <span>{{ $capitalreturns->user->last_name ?? 'N/A'}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>User Image:</strong> </span>
                            <img src="{{ (!empty($capitalreturns->user->photo)) ? url('upload/profile_images/'.$capitalreturns->user->photo) : url('upload/no_image.jpg') }}"
                                class="rounded-circle avatar-xl" style="width: 100px; height:100px;">
                        </li>
                    </ul>

                    <form action="{{ route('admin.capital.approve',$capitalreturns->id) }}" method="POST">
                        @csrf

                        @if ($capitalreturns->status != 'approved' )
                        <button type="submit" name="action" value="approved" class="btn btn-success">Approve</button>
                        @endif

                        <button type="submit" name="action" value="paid" class="btn btn-danger">Reject</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection