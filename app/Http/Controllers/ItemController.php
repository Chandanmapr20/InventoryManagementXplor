<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Item::get();
        return Response::json([
            'data' => $item,
            'success' => true
        ]);
    }

    /**
     * Insert the data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items',
            'desc' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);

        $item = new Item;
        $item->name = $request->name;
        $item->desc = $request->desc;
        $item->price = $request->price;
        $item->qty = $request->qty;
        $item->save();

        return Response::json([
            'data' => $item,
            'success' => true
        ], 201);
    }

    /**
     * Display the particular record.
     */
    public function show(string $id)
    {
        $item = Item::find($id);

        if ($item) {
            return Response::json([
                'data' => $item,
                'success' => true
            ]);
        } else {
            return Response::json([
                'data' => $item,
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }
    }

    /**
     * Update particular record.
     */
    public function update(string $id, Request $request,)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items',
            'desc' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);

        $item = Item::find($id);
        if ($item) {
            $item->name = $request->name;
            $item->desc = $request->desc;
            $item->price = $request->price;
            $item->qty = $request->qty;
            $item->save();

            return Response::json([
                'data' => $item,
                'success' => true
            ]);
        } else {
            return Response::json([
                'data' => $item,
                'success' => false,
                'message' => 'item not found'
            ], 404);
        }
    }

    /**
     * Delete the particular record.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return Response::json([
                'message' => 'Deleted successfully',
                'success' => true
            ]);
        } else {
            return Response::json([
                'message' => 'Deleted successfully',
                'success' => false
            ], 400);
        }
    }
}