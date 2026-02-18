@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Complete Investments</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Complete Investments</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions" style="top: 8px;">

                    </div>

                    <h2 class="card-title">Complete Investments</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Total Shares</th>
                                    <th>Invest Ids</th>
                                    <th>Per Share Amounts</th>
                                    <th>Paid Amount </th>
                                    <th>Due Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($properties as $key => $property)
                                    @php
                                        $investIDs = [];
                                        $perShareAmounts = [];
                                        $totalPaid = 0;
                                        $totalDue = 0; 
                                       @endphp

                                    @foreach ($property->investments as $investment)
                                        @php
                                            $investIDs[] = '#' . $investment->id;
                                            $perShareAmounts[] = '$' . $investment->per_share_price;
                                            $downPayment = $investment->down_payment ?? 0;
                                            $paidInstallments = $investment->installments->where('status', 'paid')->sum('amount');
                                            $paid = $investment->payment_type === 'installment'
                                                ? $downPayment + $paidInstallments
                                                : $investment->total_amount;
                                            $due = $investment->total_amount - $paid;
                                            $totalPaid += $paid;
                                            $totalDue += $due; 

                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td>{{ $property->title }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                {{ $property->total_share }}
                                            </span>                                            
                                        </td>
                                        <td>{{ implode(', ', $investIDs) }}</td>
                                        <td>{{ implode(', ', $perShareAmounts) }} </td>
                                        <td>${{ $totalPaid }}</td>
                                        <td>${{ $totalDue }}</td>
                                        <td>
                                            @if (count($property->investments) > 0)
                                                <a href="{{ route('admin_property_details', $property->investments->first()->id) }}" class="btn btn-primary btn-sm">Property Details</a>                                                
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> No running Properties with inventments found..
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>


@endsection