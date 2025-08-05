<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $agendas = Agenda::paginate(5);
        if ($agendas->isEmpty()) {
            return response()->json([
                'message' => 'No agenda data found',
                'data' => []
            ], 404);
        }
        $agenda = $agendas->first();
        $agendaData = [
            'judul_agenda' => $agenda->judul_agenda,
            'lokasi_agenda' => $agenda->lokasi_agenda,
            'tanggal_agenda' => $agenda->tanggal_agenda,
            'jam_mulai_agenda' => $agenda->jam_mulai_agenda,
            'jam_selesai_agenda' => $agenda->jam_selesai_agenda
        ];

        return response()->json([
            'message' => 'Agenda data retrieved successfully',
            'data' => $agendaData
        ]);
    }

    public function show($id)
    {
        $agenda = Agenda::find($id);
        if (!$agenda) {
            return response()->json([
                'message' => 'Agenda not found',
                'data' => null
            ], 404);
        }

        $agendaData = [
            'judul_agenda' => $agenda->judul_agenda,
            'lokasi_agenda' => $agenda->lokasi_agenda,
            'tanggal_agenda' => $agenda->tanggal_agenda,
            'jam_mulai_agenda' => $agenda->jam_mulai_agenda,
            'jam_selesai_agenda' => $agenda->jam_selesai_agenda
        ];

        return response()->json([
            'message' => 'Agenda data retrieved successfully',
            'data' => $agendaData
        ]);
    }
}
