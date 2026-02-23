@extends('admin.admin_dashboard')
@section('admin')
    <header class="page-header">
        <h2>Installment Report</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Installment Report</span></li>
            </ol>
        </div>
    </header>
    <section class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-semibold">
            <h4 class="mb-0 text-center">Installment Report by property and user</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="propertyFilter" class="fw-bold">Select Property</label>
                    <select name="property_id" id="propertyFilter" class="form-control">
                        <option value="">-- All Properties --</option>
                        @php
                            $properties = collect($installments)->flatten()
                                ->map(fn($installment) => $installment->investment->property)
                                ->filter()
                                ->unique('id');
                        @endphp

                        @foreach($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->title }}</option>
                        @endforeach

                    </select>
                </div>

                {{-- User List --}}
                <div class="col-md-6" id="userFilterWrapper" style="display: none;">
                    <label for="userFilter" class="fw-bold">Select Investor/User:</label>
                    <select name="user_id" id="userFilter" class="form-control">
                        <option value="">-- Select Investor/User --</option>
                        {{-- User options will be populated dynamically based on selected property --}}
                    </select>

                </div>

            </div>
            <table class="table table-bordered table-stripped mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Property | Invest Id</th>
                        <th>Installment Date</th>
                        <th>Installment Amount</th>
                        <th>Invest Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @foreach ($installments as $userId => $userInstallments)
                        @php
                            $user = optional($userInstallments->first()->investment->user)
                        @endphp

                        @foreach ($userInstallments as $installment)
                            <tr class="installment-row" data-property="{{ $installment->investment->property->id ?? ''  }}"
                                data-user="{{ $userId }}">
                                <td> {{ $user->first_name ?? 'N/A' }} {{ $user->last_name ?? 'N/A' }} </td>

                                <td> {{ optional($installment->investment->property)->title ?? 'N/A'  }} </td>

                                <td> {{ $installment->paid_time ? \Carbon\Carbon::parse($installment->paid_time)->format('d M Y') : '-' }}
                                    <small>Next: {{ \Carbon\Carbon::parse($installment->next_time)->format('d M Y') }}</small>
                                </td>
                                <td>${{ $installment->amount }}</td>
                                <td>${{ $installment->investment->total_amount }}</td>
                                @php
                                    static $investmentTotals = []; // investment wise total amount
                                    static $investmentPaid = []; //Investment wise running paid amount

                                    $investmentId = $installment->investment->id ?? null;
                                    $total = $installment->investment->total_amount ?? 0;

                                    // first time installment
                                    if (!isset($investmentTotals[$investmentId])) {
                                        $investmentTotals[$investmentId] = $total;
                                        $investmentPaid[$investmentId] = 0;
                                    }

                                    // increament only if current installment is paid
                                    if ($installment->status == 'paid') {
                                        $investmentPaid[$investmentId] += $installment->amount;
                                    }
                                    $paid = $investmentPaid[$investmentId];
                                    $due = $investmentTotals[$investmentId] - $paid;  
                                @endphp

                                <td>${{ $paid  }}</td>
                                <td>${{ $due }}</td>
                                <td>
                                    @if ($installment->status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-danger">Due</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const propertyFilter = document.getElementById("propertyFilter");
            const userFilterWrapper = document.getElementById("userFilterWrapper");
            const userFilter = document.getElementById("userFilter");
            const rows = document.querySelectorAll(".installment-row");

            // Default rows hide
            rows.forEach(row => row.style.display = "none");

            propertyFilter.addEventListener("change", function () {
                let propertyId = this.value;

                // Reset user filter
                userFilter.innerHTML = '<option value="">-- Select User --</option>';
                userFilterWrapper.style.display = "none";

                rows.forEach(row => row.style.display = "none");

                if (propertyId) {
                    rows.forEach(row => {
                        if (row.dataset.property === propertyId) {
                            row.style.display = "";
                            let userId = row.dataset.user;
                            let userName = row.querySelector("td").innerText.trim().split("\n")[0];
                            if (!userFilter.querySelector(`option[value='${userId}']`)) {
                                let opt = document.createElement("option");
                                opt.value = userId;
                                opt.textContent = userName + " (ID: " + userId + ")";
                                userFilter.appendChild(opt);
                            }
                        }
                    });
                    userFilterWrapper.style.display = "block";
                }
            });

            userFilter.addEventListener("change", function () {
                let userId = this.value;
                let propertyId = propertyFilter.value;

                rows.forEach(row => {
                    if (
                        (!userId && row.dataset.property === propertyId) ||
                        (userId && row.dataset.user === userId && row.dataset.property === propertyId)
                    ) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>


@endsection