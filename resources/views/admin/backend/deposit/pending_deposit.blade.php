@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Pending Deposit </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Pending Deposit</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">


                    <h2 class="card-title"> Pending All Deposit</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Gateway </th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Property</th>
                                    <th>Amount</th>
                                    <th>Installment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingDeposits as $key => $item)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $item->payment_type))  }} <br> <strong
                                                class="text--base">{{ $item->trx ?? 'N/A' }}</strong> </td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i A') }} <br>
                                            <small>{{ $item->created_at->diffForHumans() }}</small>
                                        </td>


                                        <td>{{ $item->user->name ?? 'N/A' }} </td>
                                        <td>{{ $item->property->title ?? 'N/A' }}</td>
                                        <td>${{ $item->amount }} <br> <strong>${{ $item->total_amount }} </strong> </td>

                                        <td>
                                            @if ($item->installment)
                                                @php
                                                    $investment = $item->installment->investment;
                                                    $property = $investment->property;

                                                    $hasDownPayment = $property->down_payment > 0;

                                                    // get installment position in collection
                                                    $installmentIndex = $investment->installments->search(function ($deposit) use ($item) {
                                                        return $deposit->id === $item->installment->id;
                                                    });

                                                    $effectiveIndex = $hasDownPayment ? $installmentIndex : $installmentIndex + 1;

                                                    if ($installmentIndex === 0 && $hasDownPayment) {
                                                        $installmentType = 'Down Payment';
                                                    } else {
                                                        if ($effectiveIndex % 10 == 1 && $effectiveIndex % 100 != 11) {
                                                            $suffix = 'st';
                                                        } elseif ($effectiveIndex % 10 == 2 && $effectiveIndex % 100 != 12) {
                                                            $suffix = 'nd';
                                                        } elseif ($effectiveIndex % 10 == 3 && $effectiveIndex % 100 != 13) {
                                                            $suffix = 'rd';
                                                        } else {
                                                            $suffix = 'th';
                                                        }

                                                        $installmentType = $effectiveIndex . $suffix . ' Installment';
                                                    }         
                                                @endphp

                                                {{ $installmentType }}
                                            @else
                                                <span class="text-muted">N\A</span>
                                            @endif

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
                                            <a href="{{ route('deposit.details', $item->id) }}"
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