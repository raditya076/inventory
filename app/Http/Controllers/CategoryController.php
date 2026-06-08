<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Http\Controllers\Api\BaseController;
use Exception;

class CategoryController extends BaseController
{
    protected CategoryService $svc;

    public function __construct(CategoryService $svc)
    {
        $this->svc = $svc;
    }

    public function index()
    {
        return $this->success($this->svc->all(), 'Berhasil menarik semua data Kategori');
    }

    public function store(StoreCategoryRequest $req)
    {
        $cat = $this->svc->create($req->validated());
        return $this->success($cat, 'Kategori berhasil dibuat', 201);
    }

    public function show($id)
    {
        try {
            $cat = $this->svc->find($id);
            return $this->success($cat, 'Berhasil menarik satu data Kategori');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function update(UpdateCategoryRequest $req, $id)
    {
        try {
            $cat = $this->svc->update($id, $req->validated());
            return $this->success($cat, 'Kategori berhasil diperbarui');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->svc->delete($id);
            return $this->success(null, 'Kategori berhasil dihapus', 204);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}