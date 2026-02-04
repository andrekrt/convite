<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as SupportStr;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::latest()->get();
        return view('admin.guest.index', compact('guests'));
    }

    public function create()
    {
        return view('admin.guest.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'max_guests' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $code = strtoupper(SupportStr::random(5));

            Guest::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'max_guests' => $request->max_guests,
                'invite_code' => $code
            ]);

            DB::commit();

            return redirect()->route('guests.index')->with('success', 'Convidado Cadastrado');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Falha ao salvar. Nada foi alterado no banco de dados.'])->withInput();
        }
    }

    public function destroy(Guest $guest)
    {
        DB::beginTransaction();

        try {
            $guest->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Convidado Removido');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Falha ao remover. Nada foi alterado no banco de dados.']);
        }
    }

    public function edit(Guest $guest){
        return view('admin.guest.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'max_guests' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $guest->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'max_guests' => $request->max_guests,
            ]);

            DB::commit();

            return redirect()->route('guests.index')->with('success', 'Convidado Atualizado');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Falha ao atualizar. Nada foi alterado no banco de dados.'])->withInput();
        }
    }
}
