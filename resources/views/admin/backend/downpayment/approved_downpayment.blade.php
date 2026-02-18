@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Approved Down Payment </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Approved Down Payment</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">


                    <h2 class="card-title"> Approved All Down Payment</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Property Name </th>
                                    <th>User Name</th>
                                    <th>Downpayment Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($installments as $installment)
                                    <tr>
                                        <td>{{  $installment->investment->property->title ?? 'N/A'  }}</td>
                                        <td>{{  $installment->investment->user->name ?? 'N/A'  }} <br>
                                            <small>{{ $installment->investment->user->email }}</small>
                                        </td>

                                        <td>${{ $installment->down_payment ?? 'N/A' }} </td>

                                        <td>
                                            @if ($installment->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($installment->status == 'due')
                                                <span class="badge bg-warning">Due</span>
                                            @elseif ($installment->status == 'processing')
                                                <span class="badge bg-info">Processing</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>

                                        <td>{{ $installment->created_at->diffForHumans() ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('installment.status.update', $installment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Pending Down payments found</td>
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