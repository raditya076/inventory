<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ItemService
{
    public function all(): Collection
    {
        return Item::with('category')->get();
    }

    public function find(int $id): Item
    {
        return Item::with('category')->findOrFail($id);
    }

    public function create(array $data): Item
    {
        $item = Item::create($data);
        Log::info('Item created', ['id' => $item->id, 'data' => $data]);
        return $item;
    }

    public function update(int $id, array $data): Item
    {
        $item = Item::findOrFail($id);
        $item->update($data);
        Log::info('Item updated', ['id' => $id, 'changes' => $data]);
        return $item;
    }

    public function delete(int $id): void
    {
        $item = Item::findOrFail($id);
        $item->delete();
        Log::info('Item deleted', ['id' => $id]);
    }
}