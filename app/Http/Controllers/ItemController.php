<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Exception;

class ItemController extends BaseController
{
    protected ItemService $svc;

    public function __construct(ItemService $svc)
    {
        $this->svc = $svc;
    }

    public function index(Request $request)
    {
    $request->validate([
        'category_id' => 'nullable|integer',
    ]);

    $items = collect($this->svc->all());

    if ($request->filled('category_id')) {
        $items = $items->filter(
            fn($item) => $item->category_id == $request->category_id
        )->values();
    }

    return $this->success($items, 'Berhasil menarik semua data Item');
    }

    public function store(StoreItemRequest $req)
    {
        $item = $this->svc->create($req->validated());
        return $this->success($item, 'Item berhasil dibuat', 201);
    }

    public function show($id)
    {
        try {
            $item = $this->svc->find($id);
            return $this->success($item, 'Berhasil menarik satu data Item');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function update(UpdateItemRequest $req, $id)
    {
        try {
            $item = $this->svc->update($id, $req->validated());
            return $this->success($item, 'Item berhasil diperbarui');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->svc->delete($id);
            return $this->success(null, 'Item berhasil dihapus', 204);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}