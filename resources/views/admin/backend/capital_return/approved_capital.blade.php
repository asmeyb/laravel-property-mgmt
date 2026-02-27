@extends('admin.admin_dashboard')
@section('admin')

    <header class="page-header">
        <h2>Approved Capital </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Approved Capital</span></li>
            </ol>
        </div>
    </header>


    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">


                    <h2 class="card-title"> Approved All Capital</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-striped table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Capital Return Amount </th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Property</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedCapital as $item)
                                    <tr>
                                        <td>${{ $item->amount  }} </td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i A') }} <br>
                                            <small>{{ $item->created_at->diffForHumans() }}</small>
                                        </td>

                                        <td>{{ $item->user->name ?? 'N/A' }} </td>
                                        <td>{{ $item->property->title ?? 'N/A' }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($item->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @endif
                                        </td>
                                        <td>

                                            <form action="{{ route('admin.capital.approve', $item->id) }}" method="POST">
                                                @csrf

                                                @if ($item->status != 'approved')
                                                    <button type="submit" name="action" value="approved"
                                                        class="btn btn-success">Approve</button>
                                                @endif

                                                <button type="submit" name="action" value="rejected"
                                                    class="btn btn-danger">Reject</button>
                                            </form>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No Pending capitals found</td>
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