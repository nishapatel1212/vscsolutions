<?php

namespace App\Http\Controllers;

use App\Models\QuotePriceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QuotePriceItemController extends Controller
{
    public function index()
    {
        $priceItems = QuotePriceItem::orderBy('category')->orderBy('keyword')->get();

        return view('admin_panel.settings.price_list.index', compact('priceItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255|unique:quote_price_items,keyword',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        QuotePriceItem::create([
            'keyword' => strtolower($request->keyword),
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'active' => true,
        ]);

        $this->clearPriceListCache();

        return redirect()->route('settings.price-list.index')->with('success', 'Price item added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = QuotePriceItem::findOrFail($id);

        $request->validate([
            'keyword' => 'required|string|max:255|unique:quote_price_items,keyword,' . $item->id,
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        $item->update([
            'keyword' => strtolower($request->keyword),
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'active' => $request->boolean('active'),
        ]);

        $this->clearPriceListCache();

        return redirect()->route('settings.price-list.index')->with('success', 'Price item updated successfully.');
    }

    public function destroy($id)
    {
        QuotePriceItem::findOrFail($id)->delete();

        $this->clearPriceListCache();

        return redirect()->route('settings.price-list.index')->with('success', 'Price item deleted.');
    }

    private function clearPriceListCache(): void
    {
        // Chatbot caches the price list for an hour (ChatController::loadPriceList) — bust it
        // so edits here show up immediately instead of waiting out the cache TTL.
        Cache::forget('chatbot.price_list');
    }
}
