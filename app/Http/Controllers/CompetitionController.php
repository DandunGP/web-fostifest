<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Competition;
use Illuminate\Http\Request;
use App\Exports\teamCompExport;
use Maatwebsite\Excel\Facades\Excel;

class CompetitionController extends Controller
{
    public function index()
    {
        return view('form-lomba', [
            'title' => 'Registrasi CTF | FOSTIFEST'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:competitions',
                'payment' => 'image|file|required'
            ]);

            $extension = $request->payment->extension();
            $fileName = $request->name . '-CTF-' . date('dmYhis') . '.' . $extension;
            $payment = $request->file('payment')->storeAs('competition', $fileName);

            Competition::create([
                'name' => $request->name,
                'email' => $request->email,
                'payment' => $payment
            ]);

            return redirect('/')->with('success', 'Terima Kasih Telah Mendaftar');
        } catch (Throwable $e) {
            return redirect('/competition')->with('emailError',  'Email yang digunakan sudah terdaftar');
        }
    }

    public function export()
    {
        return Excel::download(new teamCompExport, 'tim_lomba.xlsx');
    }

    public function downloadRule()
    {
        $file = "rulebook/RULEBOOK_CAPTURE_THE_FLAG_FOSTIFEST_2022.pdf";
        return response()->download($file);
    }
}
