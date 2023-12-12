<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemCategoryMapping;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemNotificationEmail;
use App\Mail\ItemNotificationUpdateEmail;
use App\Mail\ItemNotificationDeleteEmail;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category.info'])->get();
        return Response::json([
            'data' => $items,
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
            'price' => 'required|numeric|gt:0',
            'qty' => 'required|numeric|gt:0',
            'cat_id' => 'required|array|min:1',
            'cat_id.*' => 'required|numeric|exists:categories,id',
        ]);

        $item = new Item;
        $item->name = $request->name;
        $item->desc = $request->desc;
        $item->price = $request->price;
        $item->qty = $request->qty;
        $item->save();

        $itemsArray = [];
        $cat = $request->cat_id;
        foreach($cat as $value) {            
            $itemsArray[] = [
                'item_id' => $item->id,
                'cat_id' => $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        if(count($itemsArray)) {
            // multiple insert in a single query
            ItemCategoryMapping::insert($itemsArray);
        }

        $toEmail = env('TO_NOTIFICATION_EMAIL');
        $toCCEmail = env('TO_NOTIFICATION_CC_EMAIL');
        try{
            Mail::to($toEmail)
            ->cc($toCCEmail)
            ->send(new ItemNotificationEmail($item));
            $message = 'Item created and Email sent successfully!';
        }
        catch(\Exception $e){
            $message = 'Email Failed: '.$e->getMessage();
        }

        return Response::json([
            'data' => $item,
            'success' => true,
            'message' => $message
        ], 201);
    }

    /**
     * Display the particular record.
     */
    public function show(string $id)
    {
        $item = Item::with(['category.info'])->find($id);
        
        return Response::json([
            'data' => $item,
            'success' => true
        ]);
    }

    /**
     * Update particular record.
     */
    public function update(string $id, Request $request,)
    {
        $item = Item::find($id);
        $validated = $request->validate([
            'name' => 'required|max:255|unique:items,name,' . $id,
            'desc' => 'required',
            'price' => 'required|numeric|gt:0',
            'qty' => 'required|numeric|gt:0',
            'cat_id' => 'required|array|min:1',
            'cat_id.*' => 'required|numeric|exists:categories,id'
        ]);

        $item = Item::find($id);

        $item->name = $request->name;
        $item->desc = $request->desc;
        $item->price = $request->price;
        $item->qty = $request->qty;
        $item->save();

        ItemCategoryMapping::where('item_id', $item->id)->delete();

        $itemsArray = [];
        $cat = $request->cat_id;
        foreach($cat as $value) {            
            $itemsArray[] = [
                'item_id' => $item->id,
                'cat_id' => $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        if(count($itemsArray)) {
            ItemCategoryMapping::insert($itemsArray);
        }

        $toEmail = env('TO_NOTIFICATION_EMAIL');
        $toCCEmail = env('TO_NOTIFICATION_CC_EMAIL');
        try{
            Mail::to($toEmail)
            ->cc($toCCEmail)
            ->send(new ItemNotificationUpdateEmail($item));
            $message = 'Item updated and Email sent successfully!';
        }
        catch(\Exception $e){
            $message = 'Email Failed: '.$e->getMessage();
        }

        return Response::json([
            'data' => $item,
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Delete the particular record.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            $toEmail = env('TO_NOTIFICATION_EMAIL');
            $toCCEmail = env('TO_NOTIFICATION_CC_EMAIL');
            try{
                Mail::to($toEmail)
                ->cc($toCCEmail)
                ->send(new ItemNotificationDeleteEmail($item));
                $message = 'Item Deleted and Email sent successfully!';
            }
            catch(\Exception $e){
                $message = 'Email Failed: '.$e->getMessage();
            }
            
            return Response::json([
                'message' => 'Deleted successfully',
                'success' => true,
                'message' => $message
            ]);
        } else {
            return Response::json([
                'message' => 'Item not found',
                'success' => false
            ], 400);
        }
    }
}