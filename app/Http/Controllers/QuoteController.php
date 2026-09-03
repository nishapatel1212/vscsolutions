<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with('items')
            ->with('invoiceCopy')
            ->where('type', '!=', 'invoice') // or where('type', 'quote')
            ->latest()
            ->get();

        return view(
            'admin_panel.quote.index',
            compact('quotes')
        );
    }


    public function create()
    {
        // Example: 20082026A
        $quoteNumber = now()->format('dmY') . 'A';

        return view(
            'admin_panel.quote.create',
            compact('quoteNumber')
        );
    }


    public function store(Request $request)
    {
        $request->validate([

            'quote_date' => 'required|date',

            'customer_name' => 'required|string|max:255',

            'customer_email' => 'nullable|email',

            'customer_phone' => 'nullable|string|max:50',

            'customer_address' => 'nullable|string',

            'description' => 'required|array|min:1',
            'description.*' => 'required|string',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:0',

            'amount' => 'required|array|min:1',
            'amount.*' => 'required|numeric|min:0',

            'notes' => 'nullable|string',

        ]);


        DB::beginTransaction();

        try {

            /*
             * Generate Quote Number
             *
             * Example:
             * 20082026A
             * 20082026B
             * 20082026C
             */

            $datePrefix = Carbon::parse(
                $request->quote_date
            )
                ->timezone('Australia/Melbourne')
                ->format('dmY');


            $lastQuote = Quote::where(
                'quote_number',
                'like',
                $datePrefix . '%'
            )
                ->orderByDesc('id')
                ->first();


            if ($lastQuote) {

                $lastLetter = substr(
                    $lastQuote->quote_number,
                    -1
                );

                $nextLetter = chr(
                    ord($lastLetter) + 1
                );
            } else {

                $nextLetter = 'A';
            }


            $quoteNumber = $datePrefix . $nextLetter;


            /*
             * Calculate Subtotal
             */

            $subtotal = 0;


            foreach (
                $request->description as $key => $description
            ) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $subtotal += $quantity * $amount;
            }


            /*
             * GST
             *
             * Currently GST = 0
             */

            $tax = 0;

            $total = $subtotal + $tax;


            /*
             * Create Quote
             */

            $quote = Quote::create([

                'quote_number' => $quoteNumber,

                'quote_date' => $request->quote_date,

                'customer_name' => $request->customer_name,

                'customer_email' => $request->customer_email,

                'customer_phone' => $request->customer_phone,

                'customer_address' => $request->customer_address,

                'subtotal' => $subtotal,

                'tax' => $tax,

                'total' => $total,

                'notes' => $request->notes,

            ]);


            /*
             * Create Quote Items
             */

            foreach (
                $request->description as $key => $description
            ) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $itemTotal = $quantity * $amount;


                $quote->items()->create([

                    'description' => $description,

                    'quantity' => $quantity,

                    'amount' => $amount,

                    'total' => $itemTotal,

                ]);
            }


            DB::commit();


            return redirect()
                ->route('quote.index')
                ->with(
                    'success',
                    'Quote ' . $quoteNumber . ' created successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function edit($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        return view(
            'admin_panel.quote.edit',
            compact('quote')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'quote_date' => 'required|date',

            'customer_name' => 'required|string|max:255',

            'customer_email' => 'nullable|email',

            'customer_phone' => 'nullable|string|max:50',

            'customer_address' => 'nullable|string',

            'description' => 'required|array|min:1',
            'description.*' => 'required|string',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',

            'amount' => 'required|array|min:1',
            'amount.*' => 'required|numeric|min:0',

            'notes' => 'nullable|string',

        ]);


        DB::beginTransaction();

        try {

            /*
            * Find Quote
            */

            $quote = Quote::with('items')
                ->findOrFail($id);


            /*
            * Calculate Subtotal
            */

            $subtotal = 0;


            foreach ($request->description as $key => $description) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $subtotal += $quantity * $amount;
            }


            /*
            * GST
            *
            * Currently 0
            */

            $tax = 0;

            $total = $subtotal + $tax;


            /*
            * Update Quote
            */

            $quote->update([

                'quote_date' => $request->quote_date,

                'customer_name' => $request->customer_name,

                'customer_email' => $request->customer_email,

                'customer_phone' => $request->customer_phone,

                'customer_address' => $request->customer_address,

                'subtotal' => $subtotal,

                'tax' => $tax,

                'total' => $total,

                'notes' => $request->notes,

            ]);


            /*
            * Delete Existing Items
            */

            $quote->items()->delete();


            /*
            * Create Updated Items
            */

            foreach ($request->description as $key => $description) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $itemTotal = $quantity * $amount;


                $quote->items()->create([

                    'description' => $description,

                    'quantity' => $quantity,

                    'amount' => $amount,

                    'total' => $itemTotal,

                ]);
            }


            DB::commit();


            return redirect()
                ->route('quote.index')
                ->with(
                    'success',
                    'Quote ' . $quote->quote_number .
                        ' updated successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    public function show($id)
    {
        $quote = Quote::with('items')
            ->findOrFail($id);

        return view(
            'admin_panel.quote.show',
            compact('quote')
        );
    }

    public function downloadPdf($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('admin_panel.quote.quote-pdf', compact('quote'))
            ->setPaper('a4', 'portrait');

        return $pdf->download(($quote->type === 'invoice' ? 'Invoice-' : 'Quote-') . $quote->quote_number . '.pdf');

        // Or to open inline in the browser instead of forcing a download:
        // return $pdf->stream('Quote-' . $quote->quote_number . '.pdf');
    }

    public function makeInvoice($id)
    {
        $original = Quote::with('items')->findOrFail($id);

        // Safety net: never allow an invoice to be turned into another invoice
        if ($original->type === 'invoice') {
            return redirect()->route('quote.showInvoice', $original->id);
        }

        $existing = Quote::where('source_quote_id', $original->id)
            ->where('type', 'invoice')
            ->first();

        if ($existing) {
            return redirect()->route('quote.editInvoice', $existing->id);
        }

        $invoice = Quote::create([
            'quote_number' => 'INV-' . $original->quote_number,
            'type' => 'invoice',
            'source_quote_id' => $original->id,
            'quote_date' => now()->format('Y-m-d'),
            'customer_name' => $original->customer_name,
            'customer_email' => $original->customer_email,
            'customer_phone' => $original->customer_phone,
            'customer_address' => $original->customer_address,
            'subtotal' => $original->subtotal,
            'tax' => $original->tax,
            'total' => $original->total,
            'notes' => $original->notes,
        ]);

        foreach ($original->items as $item) {
            $invoice->items()->create([
                'description' => $item->description,
                'quantity' => $item->quantity,
                'amount' => $item->amount,
                'total' => $item->total ?? ($item->amount * $item->quantity),
            ]);
        }

        return redirect()->route('quote.editInvoice', $invoice->id);
    }

    public function editInvoice($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        if ($quote->type !== 'invoice') {
            abort(404);
        }

        return view('admin_panel.quote.invoice-edit', compact('quote'));
    }

    public function updateInvoice(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        if ($quote->type !== 'invoice') {
            abort(404);
        }

        $request->validate([
            'quote_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'description' => 'required|array|min:1',
            'description.*' => 'required|string',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
            'amount' => 'required|array',
            'amount.*' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        $itemsData = [];

        foreach ($request->description as $i => $desc) {
            $qty = (float) $request->quantity[$i];
            $amt = (float) $request->amount[$i];
            $lineTotal = $qty * $amt;
            $subtotal += $lineTotal;

            $itemsData[] = [
                'description' => $desc,
                'quantity' => $qty,
                'amount' => $amt,
                'total' => $lineTotal,
            ];
        }

        $tax = 0;
        $grandTotal = $subtotal + $tax;

        $quote->update([
            'quote_date' => $request->quote_date,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $grandTotal,
            'notes' => $request->notes,
        ]);

        $quote->items()->delete();
        foreach ($itemsData as $item) {
            $quote->items()->create($item);
        }

        return redirect()->route('quote.showInvoice', $quote->id)
            ->with('success', 'Invoice updated successfully.');
    }

    public function showInvoice($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        if ($quote->type !== 'invoice') {
            abort(404);
        }

        return view('admin_panel.quote.show', ['quote' => $quote]); // reuse your existing Show page as-is
    }
}
