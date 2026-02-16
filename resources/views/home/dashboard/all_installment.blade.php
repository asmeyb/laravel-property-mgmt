@extends('home.home_master')
@section('home')

<section class="breadcrumb bg-img"
    data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
    <div class="container ">
        <div class="breadcrumb__wrapper">
            <h3 class="breadcrumb__title">All Installment </h3>
        </div>
    </div>
</section>

 
    <div class="dashboard py-60 position-relative">
        <div class="container ">
            <div class="dashboard__wrapper">
 
        @include('home.body.dashboard_sidebar')

  <div class="dashboard-body">
                    <div class="flex-between breadcrumb-dashboard">
                        <div class="show-sidebar-btn mb-4">
                            <i class="fas fa-bars"></i>
                        </div>
                </div>
                        <div class="flex-end mb-4 breadcrumb-dashboard">
        <h6 class="page-title">Property: {{ $investment->property->title }}</h6>
    @php
        $perInstallment = $investment->property->per_installment_amount;
        $totalInstallmentAmount = $perInstallment * $investment->share_count;
    @endphp

        <p class="mt-2 page-title-note">Per installment amount: ${{ $totalInstallmentAmount }}
        </p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
  <div class="table-responsive table--responsive--xl">
<table class="table custom--table">
    <thead>
        <tr>
            <th>Installment Date</th>
            <th>Installment Type</th>
            <th>Payment</th>
            <th>Paid Date</th>
            <th>Late Fee</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
<tbody>
    @php
        $downPaymentAmount = $investment->property->down_payment *  $investment->share_count;
        $startDate = \Carbon\Carbon::parse($investment->created_at);
    @endphp
  @forelse ($investment->installments as $installment) 
    <tr>
    <td>
        @php
            if ($downPaymentAmount  > 0) {
                $installmentNumber = $loop->index;
            }else {
                $installmentNumber = $loop->index + 1; 
            }
            $installmentDate = $startDate->copy()->addMonths($installmentNumber);
        @endphp
        <div>
           {{ $installmentDate->format('Y-m-d') }}<br>
            <span class="small">{{ $installmentDate->diffForHumans() }}</span>
        </div>
    </td>
    <td>
        @if ($loop->first && $downPaymentAmount > 0)
          Down Payment 
        @else   
    @php
     // Orginal Suffix
     $suffix = 'th';
     if ( $installmentNumber % 10 == 1 &&  $installmentNumber % 100 !== 11) {
      $suffix = 'st';
     } elseif ($installmentNumber % 10 == 2 &&  $installmentNumber % 100 !== 12) {
        $suffix = 'nd';
     }elseif ($installmentNumber % 10 == 3 &&  $installmentNumber % 100 !== 13) {
        $suffix = 'rd';
     }
   @endphp
   {{ $installmentNumber }} {{  $suffix }} Installment <br>
   <span class="small">{{ $installmentDate->format('F') }}</span>
      @endif 
    </td>
    <td>
        @php
            $discountAmount = $investment->total_amount * ($investment->property->down_payment / 100);
        @endphp
    @if ($loop->first && $investment->property->down_payment > 0)
    {{ (int) $investment->property->down_payment }} %
    ( ${{ $investment->total_amount * ($investment->property->down_payment / 100)}} )
    @else
    ${{ $totalInstallmentAmount }}
        
    @endif
        
    </td> 
    <td>
    @php
        if ($downPaymentAmount > 0) {
           $installmentNumber = $loop->index;
        } else {
            $installmentNumber = $loop->index + 1;
        }
        $installmentDate = $startDate->copy()->addMonths($installmentNumber);
    @endphp 

        <div>{{ $installmentDate->format('Y-m-d') }} <br>
       <span class="small">{{ $installmentDate->format('F') }}</span>
         </div>
    </td>
    <td>${{ $investment->property->installment_late_fee }} </td>
    <td>
        @if ($installment->status == 'paid')
         <span class="badge badge--success">Paid</span> 
         @elseif ($installment->status == 'due')
             <span class="badge badge--primary">Due</span> 
         @elseif ($installment->status == 'processing')
             <span class="badge badge--warning">Processing</span>
         @else 
          <span class="badge badge--danger">Failed</span> 
        @endif 
      </td>
    <td>
    @if ($installment->status == 'due')
     <a href="{{ route('installment.pay',$installment->id) }}" class="action--btn btn btn-outline--primary" title="Pay Installment"><i class="las la-coins"></i></a>  

    @else 
        <span class="text-muted">--</span>
    @endif
      
    </td> 
    </tr>

    @empty
    <tr>
        <td colspan="6" class="text-center">No Installments found.</td>
    </tr> 

@endforelse

                                                                                                                                         
          </tbody>
                    </table>
                </div>
                    </div>
    </div>

    <div id="installmentModal" class="modal fade custom--modal installment-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header  mb-2">
                <div>
                    <h6 class="modal-title">Installment to  - <span
                            class="text--base"></span>
                        property                    </h6>
                </div>
                <button class="close-btn" type="button" data-bs-dismiss="modal">
                    <i class="las fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="//realvest/user/invest/installment/pay/eyJpdiI6IlFGSUxmUnJMdTJzNU52dVFMQm1mWkE9PSIsInZhbHVlIjoiRnhOMTRveVZDcEEzMTV1UUtIMUpYQT09IiwibWFjIjoiZjJlZGU0ODJmN2JkNzE1YjYxODAyM2RkZjQ5MjM1MjM4Njc3NmVmMTQ5NjEzNjJkOGQwNTgxMjNkY2U5ZTI4NyIsInRhZyI6IiJ9/eyJpdiI6InRtYi9aZ25QRDdoK001eUVsdmdQYkE9PSIsInZhbHVlIjoiK2RpZyt6bUF3eG0vbzlmTTI3U3kxdz09IiwibWFjIjoiYzU4NGFmNzE5MWU2NTVkODMwOTE2NWVlYjAxOWEzMDJhYjdkOTU3MDFmOTkzNzg2NTU0OGFkNjlmZThhZDBjNiIsInRhZyI6IiJ9"
                    class="modal-form" id="installmentForm">
                    <input type="hidden" name="_token" value="AgrQteztDPUt9ULMougURIKUlrFDk0lPkode5Rzl" autocomplete="off">                    <input type="hidden" name="method" id="paymentMethod" value="gateway">
                    <input name="currency" type="hidden">

                    <div class="modal-form__body">
                        <div class="form-group">
                            <label class="form--label">Installment Amount</label>
                            <div class="input-group--custom">
                                <input class="form--control" type="number" name="installment_amount"
                                    value="0"
                                    readonly required>
                                <span class="input-group-text p-0 border-0">
                                    <small class="px-3">USD</small>
                                </span>
                            </div>
                            <div class="mt-2 preview-details d-none">
                                <span>
                                    <span>Charge:</span>
                                    <span class="text--base">$<span class="charge ">0</span></span>,
                                </span>
                                <span>
                                    <span>Total Amount: </span> <span class="text--base">$<span
                                            class="payable ">
                                            0</span></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-form__footer flex-row   flex-wrap form-group">
                        <button type="button" class="flex-fill btn btn-outline--base active" id="payGatewayButton">
                            <span class="active-badge"> <i class="las la-check"></i> </span>
                            Pay via Gateway                        </button>
                        <button type="button" class="flex-fill btn btn-outline--base" id="payBalanceButton">
                            <span class="active-badge"> <i class="las la-check"></i> </span>
                            Pay via Balance                        </button>
                    </div>
                    <button type="submit" class="flex-fill btn btn--base w-100">
                        Paid Now                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



                </div>




            </div>
        </div>
    </div> 


@endsection