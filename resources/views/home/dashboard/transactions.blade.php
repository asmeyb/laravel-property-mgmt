@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Transactions </h3>
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
                        <div class="show-filter mb-4 text-end">
                            <button type="button" class="btn btn--base showFilterBtn btn-sm">
                                <i class="las la-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex-end mb-4 responsive-filter-card">
                        <form>
                            <div class="d-flex flex-wrap gap-4">
                                <div class="flex-grow-1">
                                    <label class="form--label">Transaction Number</label>
                                    <input type="text" name="search" value="" class="form--control">
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form--label">Type</label>
                                    <select name="trx_type" class="form--control">
                                        <option value="">All</option>
                                        <option value="+">Plus</option>
                                        <option value="-">Minus</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form--label">Remark</label>
                                    <select class="form--control" name="remark">
                                        <option value="">Any</option>
                                        <option value="balance_add">
                                            Balance add</option>
                                        <option value="capital_back">
                                            Capital back</option>
                                        <option value="deposit">
                                            Deposit</option>
                                        <option value="down_payment">
                                            Down payment</option>
                                        <option value="installment">
                                            Installment</option>
                                        <option value="installment_late_fee">
                                            Installment late fee</option>
                                        <option value="profit">
                                            Profit</option>
                                        <option value="withdraw">
                                            Withdraw</option>
                                        <option value="withdraw_reject">
                                            Withdraw reject</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1 align-self-end">
                                    <button class="btn btn--base btn--md w-100"><i class="las la-filter"></i>
                                        Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="table-responsive table--responsive--xl">
                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>Trx</th>
                                            <th>Amount</th>
                                            <th>Post Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>OF8J6OQE3DCA</strong>
                                            </td>
                                            <td class="budget">
                                                <span class="fw-bold  text--danger ">
                                                    $6,000.00
                                                </span>
                                            </td>
                                            <td class="budget">
                                                $29,000.00
                                            </td>
                                            <td>
                                                <button class="action--btn btn btn-outline--base detailBtn"
                                                    data-transaction="{&quot;id&quot;:446,&quot;user_id&quot;:1494,&quot;invest_id&quot;:94,&quot;installment_id&quot;:0,&quot;profit_id&quot;:0,&quot;amount&quot;:&quot;6000.00000000&quot;,&quot;charge&quot;:&quot;0.00000000&quot;,&quot;post_balance&quot;:&quot;29000.00000000&quot;,&quot;trx_type&quot;:&quot;-&quot;,&quot;trx&quot;:&quot;OF8J6OQE3DCA&quot;,&quot;details&quot;:&quot;Investment payment on Stylish Apartment property&quot;,&quot;remark&quot;:&quot;down_payment&quot;,&quot;created_at&quot;:&quot;2025-05-12T08:51:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-05-12T08:51:48.000000Z&quot;}"
                                                    data-transacted="2025-05-12 08:51 AM<br>2 weeks ago">
                                                    <i class="las la-desktop"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>L7IIX8DNNXR6</strong>
                                            </td>
                                            <td class="budget">
                                                <span class="fw-bold  text--danger ">
                                                    $20,000.00
                                                </span>
                                            </td>
                                            <td class="budget">
                                                $35,000.00
                                            </td>
                                            <td>
                                                <button class="action--btn btn btn-outline--base detailBtn"
                                                    data-transaction="{&quot;id&quot;:401,&quot;user_id&quot;:1494,&quot;invest_id&quot;:90,&quot;installment_id&quot;:0,&quot;profit_id&quot;:0,&quot;amount&quot;:&quot;20000.00000000&quot;,&quot;charge&quot;:&quot;0.00000000&quot;,&quot;post_balance&quot;:&quot;35000.00000000&quot;,&quot;trx_type&quot;:&quot;-&quot;,&quot;trx&quot;:&quot;L7IIX8DNNXR6&quot;,&quot;details&quot;:&quot;Investment payment on Stylish Apartment property&quot;,&quot;remark&quot;:&quot;down_payment&quot;,&quot;created_at&quot;:&quot;2025-02-20T09:01:50.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-02-20T09:01:50.000000Z&quot;}"
                                                    data-transacted="2025-02-20 09:01 AM<br>3 months ago">
                                                    <i class="las la-desktop"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>8I9KDLA42M9K</strong>
                                            </td>
                                            <td class="budget">
                                                <span class="fw-bold  text--success ">
                                                    $50,000.00
                                                </span>
                                            </td>
                                            <td class="budget">
                                                $55,000.00
                                            </td>
                                            <td>
                                                <button class="action--btn btn btn-outline--base detailBtn"
                                                    data-transaction="{&quot;id&quot;:378,&quot;user_id&quot;:1494,&quot;invest_id&quot;:0,&quot;installment_id&quot;:0,&quot;profit_id&quot;:0,&quot;amount&quot;:&quot;50000.00000000&quot;,&quot;charge&quot;:&quot;501.00000000&quot;,&quot;post_balance&quot;:&quot;55000.00000000&quot;,&quot;trx_type&quot;:&quot;+&quot;,&quot;trx&quot;:&quot;8I9KDLA42M9K&quot;,&quot;details&quot;:&quot;Deposit Via Stripe Hosted - USD&quot;,&quot;remark&quot;:&quot;deposit&quot;,&quot;created_at&quot;:&quot;2025-01-16T22:19:59.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-01-16T22:19:59.000000Z&quot;}"
                                                    data-transacted="2025-01-16 10:19 PM<br>4 months ago">
                                                    <i class="las la-desktop"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>X19C4NC796BM</strong>
                                            </td>
                                            <td class="budget">
                                                <span class="fw-bold  text--success ">
                                                    $5,000.00
                                                </span>
                                            </td>
                                            <td class="budget">
                                                $5,000.00
                                            </td>
                                            <td>
                                                <button class="action--btn btn btn-outline--base detailBtn"
                                                    data-transaction="{&quot;id&quot;:377,&quot;user_id&quot;:1494,&quot;invest_id&quot;:0,&quot;installment_id&quot;:0,&quot;profit_id&quot;:0,&quot;amount&quot;:&quot;5000.00000000&quot;,&quot;charge&quot;:&quot;51.00000000&quot;,&quot;post_balance&quot;:&quot;5000.00000000&quot;,&quot;trx_type&quot;:&quot;+&quot;,&quot;trx&quot;:&quot;X19C4NC796BM&quot;,&quot;details&quot;:&quot;Deposit Via Stripe Hosted - USD&quot;,&quot;remark&quot;:&quot;deposit&quot;,&quot;created_at&quot;:&quot;2025-01-16T22:16:00.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-01-16T22:16:00.000000Z&quot;}"
                                                    data-transacted="2025-01-16 10:16 PM<br>4 months ago">
                                                    <i class="las la-desktop"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade custom--modal" id="detailModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Transaction Details</h5>
                                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                                        <i class="las fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-form__header">
                                        <ul class="list-group list-group-flush userData mb-2"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


@endsection