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
        <a href="{{ route('admin_property_details', $investment->id) }}" class="btn btn-outline-primary"><i
                class="fas fa-arrow-left me-2"></i> Back to Property Details </a>
    </div>

    <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-primary text-white fw-semibold">
            <h4>
                
            </h4>User Payment History - <span class="badge badge-danger badge-lg">{{ $investment->user->name ?? 'N/A' }}</span>
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
                    <th>Installment Type </th>
                    <th>Payment Amount</th>
                    <th>Paid Date</th>
                    <th>Status</th>
                </tr> 
            </thead>
<tbody>
 @php
$downPaymentAmount = $investment->property->down_payment *  $investment->share_count;
$totalInstallmentAmount = $investment->property->per_installment_amount * $investment->share_count;
$startDate = \Carbon\Carbon::parse($investment->created_at);
 @endphp

 @forelse ($investment->installments as $installment) 

    @php 
     $installmentNumber = $downPaymentAmount > 0 ? 
     $loop->index : $loop->index + 1; 

    $installmentDate = $startDate->copy()->addMonths($installmentNumber);

    if ($loop->first && $downPaymentAmount > 0){
        $type = 'Down Payment ';
    } else  {
        if ( $installmentNumber % 10 == 1 &&  $installmentNumber % 100 !== 11) {
      $suffix = 'st';
     } elseif ($installmentNumber % 10 == 2 &&  $installmentNumber % 100 !== 12) {
        $suffix = 'nd';
     }elseif ($installmentNumber % 10 == 3 &&  $installmentNumber % 100 !== 13) {
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
                {{ \Carbon\Carbon::parse($installment->paid_time)->format('Y-m-d') }}
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
    <td colspan="6" class="text-center">No Installmets found</td>
</tr>

 @endforelse


        </tbody> 
            </table>

        </div>
            @endif
        </div>
    </div>
@endsection