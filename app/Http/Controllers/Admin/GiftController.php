<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::latest()->get();

        return view('admin.gifts.index', compact('gifts'));
    }

    public function create()
    {
        return view('admin.gifts.create');
    }

    public function store(Request $request)
    {

        if ($request->has('price')) {
            $cleanPrice = str_replace(['.', ','], ['', '.'], $request->price);
            $request->merge(['price' => $cleanPrice]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {

            $data = $request->only(['title', 'description', 'price']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('gifts', 'public');
            }

            Gift::create($data);

            DB::commit();

            return redirect()->route('gifts.index')->with('success', 'Presente Cadastrado!');
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao cadastrar presente!')->withInput();
        }
    }

    public function destroy(Gift $gift)
    {
        DB::beginTransaction();

        try {
            $gift->delete();

            DB::commit();

            return redirect()->route('gifts.index')->with('success', 'Presente Removido!');
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao remover presente!');
        }
    }

    public function edit(Gift $gift)
    {
        return view('admin.gifts.edit', compact('gift'));
    }

    public function update(Request $request, Gift $gift)
    {

        if ($request->has('price')) {
            $cleanPrice = str_replace(['.', ','], ['', '.'], $request->price);
            $request->merge(['price' => $cleanPrice]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {

            $data = $request->only(['title', 'description', 'price']);

            if ($request->hasFile('image')) {
                if ($gift->image) {
                    Storage::disk('public')->delete($gift->image);
                }

                $data['image'] = $request->file('image')->store('gifts', 'public');
            }

            $gift->update($data);

            DB::commit();

            return redirect()->route('gifts.index')->with('success', 'Presente Atualizado!');
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar presente!')->withInput();
        }
    }
}
