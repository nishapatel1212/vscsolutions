@extends('layouts.app')

@section('title', 'Quotes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Quotes</h1>

        <a href="{{ route('quote.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Quote
        </a>
    </div>
@endsection

@section('css')

<style>
    .quote-card {
        border-radius: 8px;
    }

    .quote-number {
        font-weight: 600;
        color: #007bff;
    }

    .total-amount {
        font-weight: 600;
    }
</style>

@endsection


@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif


<div class="card card-warning shadow-sm quote-card">

    <div class="card-header text-white">
        <h5 class="mb-0">
            <i class="fas fa-file-invoice"></i>
            Quote List
        </h5>
    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table
                class="table table-bordered table-striped"
                id="quoteTable"
            >

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Quote No.</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th width="180">Action</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($quotes as $index => $quote)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>
                                <span class="quote-number">
                                    {{ $quote->quote_number }}
                                </span>
                            </td>


                            <td>

                                @if($quote->quote_date)
                                    {{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}
                                @endif

                            </td>


                            <td>
                                {{ $quote->customer_name }}
                            </td>


                            <td>
                                {{ $quote->address }}
                            </td>


                            <td>

                                @if(isset($quote->amount_from) && isset($quote->amount_to)
                                    && $quote->amount_from != $quote->amount_to)

                                    <span class="total-amount">
                                        AUD ${{ number_format($quote->amount_from, 2) }}
                                        to
                                        ${{ number_format($quote->amount_to, 2) }}
                                    </span>

                                @else

                                    <span class="total-amount">
                                        AUD ${{ number_format($quote->total ?? 0, 2) }}
                                    </span>

                                @endif

                            </td>


                            <td>

                                <a
                                    href="{{ route('quote.show', $quote->id) }}"
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>


                                <a
                                    href="{{ route('quote.edit', $quote->id) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted"
                            >
                                No quotes found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@section('js')

<script>

$(document).ready(function () {

    $('#quoteTable').DataTable({
        "order": [[0, "desc"]],
        "pageLength": 25
    });

});

</script>

@endsection