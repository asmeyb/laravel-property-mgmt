@extends('admin.admin_dashboard')

@section('admin')

<header class="page-header">
    <h2>User Payment History</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>User Payment History</span></li>
        </ol>
    </div>
</header>

<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('admin_property_details', $investment->id) }}"
           class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Property Details
        </a>
    </div>

    {{-- ================= PAYMENT HISTORY ================= --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white fw-semibold">
            <h4 class="mb-0">
                User Payment History -
                <span class="badge badge-danger badge-lg">
                    {{ $investment->user->name ?? 'N/A' }}
                </span>
            </h4>
        </div>

        <div class="card-body">

            @if($investment->installments->isEmpty())
                <p>No payment history available.</p>
            @else

                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Property</th>
                                <th>Installment Date</th>
                                <th>Installment Type</th>
                                <th>Payment Amount</th>
                                <th>Paid Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        @php
                            $downPaymentAmount = $investment->property->down_payment * $investment->share_count;
                            $totalInstallmentAmount = $investment->property->per_installment_amount * $investment->share_count;
                            $startDate = \Carbon\Carbon::parse($investment->created_at);
                        @endphp

                        @forelse ($investment->installments as $installment)

                            @php
                                $installmentNumber = $downPaymentAmount > 0
                                    ? $loop->index
                                    : $loop->index + 1;

                                $installmentDate = $startDate->copy()->addMonths($installmentNumber);

                                if ($loop->first && $downPaymentAmount > 0) {
                                    $type = 'Down Payment';
                                } else {
                                    if ($installmentNumber % 10 == 1 && $installmentNumber % 100 !== 11) {
                                        $suffix = 'st';
                                    } elseif ($installmentNumber % 10 == 2 && $installmentNumber % 100 !== 12) {
                                        $suffix = 'nd';
                                    } elseif ($installmentNumber % 10 == 3 && $installmentNumber % 100 !== 13) {
                                        $suffix = 'rd';
                                    } else {
                                        $suffix = 'th';
                                    }

                                    $type = $installmentNumber . $suffix . ' Installment';
                                }
                            @endphp

                            <tr>
                                <td>{{ $investment->property->title ?? 'N/A' }}</td>
                                <td>{{ $installmentDate->format('Y-m-d') }}</td>
                                <td>{{ $type }}</td>

                                <td>
                                    @if ($loop->first && $investment->property->down_payment > 0)
                                        {{ (int) $investment->property->down_payment }} %
                                        (${{ $investment->total_amount * ($investment->property->down_payment / 100) }})
                                    @else
                                        ${{ $totalInstallmentAmount }}
                                    @endif
                                </td>

                                <td>
                                    @if ($installment->paid_time)
                                        {{ \Carbon\Carbon::parse($installment->paid_time)->format('d M, Y') }}
                                    @else
                                        <span class="text-muted">Not Paid</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($installment->status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif ($installment->status == 'due')
                                        <span class="badge badge-primary">Due</span>
                                    @elseif ($installment->status == 'processing')
                                        <span class="badge badge-warning">Processing</span>
                                    @else
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No Installments found
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            @endif

        </div>
    </div>


    {{-- ================= Capital Return ================= --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white fw-semibold">
            <h4 class="mb-0">
                Profit History -
                <span class="badge badge-danger badge-lg">
                    {{ $investment->property->title ?? 'N/A' }}
                </span>
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Profit Date</th>
                            <th>Amount Per Share</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse ($investment->profits as $profit)

                        <tr>
                            <td>{{ \Carbon\Carbon::parse($profit->paid_date)->format('d M Y') }}</td>
                            <td>${{ $profit->profit_amount }}</td>
                            <td>
                                @if ($profit->status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Unpaid</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No Profit records found
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

        <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white fw-semibold">
            <h4 class="mb-0">
                Capital Return History -
                <span class="badge badge-danger badge-lg">
                    {{ $investment->property->title ?? 'N/A' }}
                </span>
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Capital Return</th>                            
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                @if ($investment->capitalReturn)
                                    <div class="text-success">
                                        Capital Back
                                        ${{ $investment->capitalReturn->amount }} 
                                        on Date 
                                        {{ \Carbon\Carbon::parse($investment->capitalReturn->paid_date)->format('d M, Y') }}
                                        (Transaction ID: {{ $investment->capitalReturn->trx }})
                                    </div>
                                @else
                                    <span class="text-muted">No Capital Return record found</span>                                
                                @endif
                            </td>
                        </tr>             

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
