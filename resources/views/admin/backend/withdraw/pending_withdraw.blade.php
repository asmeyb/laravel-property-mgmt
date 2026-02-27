@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Pending Withdraw </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Pending Withdraw</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">


                    <h2 class="card-title">All Pending Withdraw</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Transaction </th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Property</th>
                                    <th>Amount(W/R)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdraws as $item)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $item->payment_type))  }} <br> <strong
                                                class="text--base">{{ $item->trx ?? 'N/A' }}</strong> </td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i A') }} <br>
                                            <small>{{ $item->created_at->diffForHumans() }}</small>
                                        </td>


                                        <td>{{ $item->user->name ?? 'N/A' }} </td>
                                        <td>{{ $item->property->title ?? 'N/A' }}</td>
                                        <td>${{ $item->withdraw_amount }} <br> <strong>${{ $item->receivable_amount }} </strong>
                                        </td>


                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($item->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($item->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.withdraw.details', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm">Details</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>


@endsection