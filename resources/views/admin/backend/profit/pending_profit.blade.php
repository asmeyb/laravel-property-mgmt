@extends('admin.admin_dashboard')
@section('admin') 

<header class="page-header">
    <h2>Pending Profits </h2> 
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li> 
            <li><span>Pending Profits</span></li>  
        </ol>  
    </div>
</header>


<div class="row">
<div class="col">
    <section class="card">
        <header class="card-header"> 

  <h2 class="card-title">Pending Profits</h2>
        </header>
        <div class="card-body">
            <div class="table-responsive">
<table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
    <thead>
        <tr>
            <th>Property Name </th>
            <th>Total Profit Amount </th>
            <th>Total Investor </th>
            <th>Schedule </th>
            <th>Repeat Time </th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
      @foreach ($profits as $item) 
        <tr>
            <td>{{ $item->property->title }}</td>
            <td>${{ $item->monthly_profit }}</td>
            <td>{{ $item->investor_count }}</td>
            <td>{{ $item->schedule }}</td>
            <td>{{ $item->repeat_time }}</td>
            
            <td>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $item->property_id }}" >Discharge</button>
    

    <!--- Modal Stated ----> 
    <div class="modal fade" id="modal{{ $item->property_id }}" tabindex="-1" aria-labelledby="modalLable{{ $item->property_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">

    <form method="POST" action="{{ route('admin.profit.discharge') }}">
        @csrf

        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalLable{{ $item->property_id }}">
               Discharge:  {{ $item->property->title }} </h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> 
            </div>

    @php
        $thisPayout = min($item->monthly_profit * $item->investor_count, $item->remaining_total );
    @endphp

    <div class="modal-body">
        <div class="row g-3">
            <div class="col-12">
        <p class="mb-2"><strong class="fw-semibold">Total Investors:</strong> {{ $item->investor_count }} </p>

        <p class="mb-2"><strong class="fw-semibold">Profti (PerPeriod):</strong> ${{ $item->monthly_profit }} </p>

        <p class="mb-2"><strong class="fw-semibold">Repeat Time:</strong> {{ $item->repeat_time }} Months</p>

        <p class="mb-2"><strong class="fw-semibold">Total Profit to Distribute:</strong> ${{ $item->planned_total }} </p>

        <p class="mb-2"><strong class="fw-semibold">Remaining:</strong> ${{ $item->remaining_total }} </p> 
          </div>
     
        <div class="col-12">
            <label for="payoutInput{{ $item->property_id }}" class="form-label fw-semibold">This Month Payout</label>
            <div class="input-group">
                <span class="input-group-text bg-light">$</span>
            <input type="number" step="0.01" class="form-control" id="payoutInput{{ $item->property_id }}" value="{{ $thisPayout }}" readonly>
            <span class="input-group-text bg-light">USD</span> 
            </div> 
        </div> 
        </div> 
    <input type="hidden" name="property_id" value="{{ $item->property_id }}">
 
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" {{ $item->remaining_total <= 0 ? 'disabled' : '' }}>Confim Distribute</button>
      </div>  
     </div> 
    </form>
    </div>
       


    </div>
     <!--- End Modal Stated ----> 








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