<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\ItemDistribution;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::when($request->search, function ($query) use ($request) {
            $query->where('item_name', 'like', "%{$request->search}%")
                ->orWhere('item_type', 'like', "%{$request->search}%");
        })
            ->when($request->quality, function ($query) use ($request) {
                $query->where('item_quality', $request->quality);
            })
            ->latest()
            ->paginate(20);

        return response()->json($items);
    }

    public function show(Item $item)
    {
        $item->load('distributions');
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|unique:items|integer',
            'item_name' => 'required|string|max:255',
            'item_type' => 'required|string',
            'item_quality' => 'in:normal,uncommon,rare,epic,legendary',
            'level_required' => 'integer|min:0',
            'price' => 'numeric|min:0',
            'description' => 'string',
            'is_tradeable' => 'boolean',
            'is_stackable' => 'boolean',
            'max_stack' => 'integer|min:1',
        ]);

        $item = Item::create($validated);
        return response()->json($item, 201);
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'description' => 'string',
            'is_tradeable' => 'boolean',
            'is_stackable' => 'boolean',
            'max_stack' => 'integer|min:1',
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    public function distribute(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'character_id' => 'required|exists:characters,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'string',
        ]);

        $character = Character::find($validated['character_id']);
        $validated['account_id'] = $character->account_id;
        $validated['distributed_by'] = auth()->id();
        $validated['distributed_at'] = now();

        $distribution = ItemDistribution::create($validated);
        return response()->json($distribution, 201);
    }
}
