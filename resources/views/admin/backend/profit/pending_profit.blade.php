@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Pending Profit Report</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Pending Profit Report</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    

                    <h2 class="card-title">Pending Profit Report</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Property Name</th>
                                    <th>Total Profit Amount</th>
                                    <th>Total Investors</th>
                                    <th>Schedule</th>
                                    <th>Repeated Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profits as $item)
                                    <tr>
                                        <td>{{ $item->property->title }}</td>
                                        <td>$ {{ $item->monthly_profit }}</td>
                                        <td>{{ $item->investor_count }}</td>
                                        <td>{{ $item->schedule }}</td>
                                        <td>{{ $item->repeat_time }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#dischargeModal{{ $item->property_id }}">Discharge</button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="dischargeModal{{ $item->property_id }}" tabindex="-1" aria-labelledby="dischargeModalLabel{{ $item->property_id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <form action="{{ route('admin.profit.confirm.discharge', ['property_id' => $item->property_id]) }}" method="post">
                                                        @csrf
                                                        <div class="modal-content border-0 shadow-sm">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title" id="dischargeModalLabel{{ $item->property_id }}">Confirm Discharge : {{ $item->property->title }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            @php
                                                                $thisPayout = min($item->monthly_profit * $item->investor_count, $item->remaining_total);
                                                            @endphp
                                                            <div class="modal-body">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <p class="mb-2"><strong class="fw-semibold">Total Investors: </strong> {{ $item->investor_count }}</p>
                                                                        <p class="mb-2"><strong class="fw-semibold">Profit (Per Period): </strong> $ {{ $item->monthly_profit }}</p>
                                                                        <p class="mb-2"><strong class="fw-semibold">Repeat Time: </strong> {{ $item->repeat_time }} Months</p>
                                                                        <p class="mb-2"><strong class="fw-semibold">Total Profit to Destribute: </strong>${{ $item->planned_total }}</p>
                                                                        <p class="mb-2"><strong class="fw-semibold">Remaining Profit: </strong>$ {{ $item->remaining_total }}</p>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="payoutInput{{ $item->property_id }}" class="form-label">
                                                                            This Month Payout:
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <span class="input-group-text bg-light">$</span>

                                                                            <input type="number" class="form-control" id="payoutInput{{ $item->property_id }}" value="{{ $thisPayout }}" min="0" max="{{ $item->remaining_total }}" readonly >

                                                                            <span class="input-group-text bg-light">USD</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="property_id" value="{{ $item->property_id }}">                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button {{ $item->remaining_total <= 0 ? 'disabled' : '' }} class="btn btn-success" onclick="confirmDischarge({{ $item->property_id }})">Confirm Destribution</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                    </div>                                            
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