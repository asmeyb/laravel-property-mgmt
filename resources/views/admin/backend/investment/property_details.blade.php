@extends('admin.admin_dashboard')
@section('admin')

<header class="page-header">
    <h2> Investment Property Details</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Investment Property Details</span></li>
        </ol>
    </div>
</header>

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('running.investment') }}" class="btn btn-outline-primary"><i
                class="fas fa-arrow-left me-2"></i> Back to Investments </a>
    </div>

    <div class="row g-4">
        <!-- Property Details --->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    Property Details
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 fw-semibold">Property Name: </dt>
                        <dd class="col-sm-7">{{ $investment->property->title ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Investment Type: </dt>
                        <dd class="col-sm-7">{{ $investment->property->investment_type ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Total Share: </dt>
                        <dd class="col-sm-7">{{ $investment->property->total_share ?? 'N/A' }}</dd>


                        <dt class="col-sm-5 fw-semibold">Per Share Amount: </dt>
                        <dd class="col-sm-7">{{ $investment->per_share_price ?? 'N/A' }}</dd>


                        <dt class="col-sm-5 fw-semibold">Capital Back: </dt>
                        <dd class="col-sm-7">{{ $investment->property->capital_back ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Profit Type : </dt>
                        <dd class="col-sm-7">{{ $investment->property->profit_type ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Profit Amount : </dt>
                        <dd class="col-sm-7">${{ $investment->property->profit_amount ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Profit Schedule : </dt>
                        <dd class="col-sm-7">{{ $investment->property->profit_schedule ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Profit Repeted Time : </dt>
                        <dd class="col-sm-7">{{ $investment->property->repeat_time ?? 'N/A' }}</dd>

                    </dl>

                </div>
            </div>
        </div>


        <!-- Investment Details --->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    Investment Details
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 fw-semibold">Invested Amount : </dt>
                        <dd class="col-sm-7">${{ $investment->property->per_share_amount ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Per Installment Amount: </dt>
                        <dd class="col-sm-7">${{ $investment->property->per_installment_amount ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 fw-semibold">Investement Status: </dt>
                        <dd class="col-sm-7">Running</dd>


                    </dl>

                </div>
            </div>
        </div>
    </div>


    <!-- User Information History --->

    <div class="mt-5">
        <h5 class="fw-bold text-dark mb-3">User History</h5>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">User Name </th>
                                <th scope="col">Email </th>
                                <th scope="col">Paid Amount</th>
                                <th scope="col">Due Amount </th>
                                <th scope="col">Details </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allInvestments as $inv)
                            @php
                            $downPayment = $inv->down_payment ?? 0;
                            $paidInstallments = $inv->installments->where('status','paid')->sum('amount');
                            $paid = $inv->payment_type === 'installment'
                            ? $downPayment + $paidInstallments
                            : $inv->total_amount;
                            $due = $inv->total_amount - $paid;
                            @endphp

                            <tr>
                                <td>{{ $inv->user->name }}</td>
                                <td>{{ $inv->user->email }}</td>
                                <td> ${{ $paid }}</td>
                                <td>${{ $due }}</td>
                                <td>
                                    <a href="{{ route('user.pay.history', $inv->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No user found for this property</td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


</div>

@endsection