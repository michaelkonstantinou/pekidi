<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Services\DeclarationTotalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DeclarationPdfController extends Controller
{
    public function download(Request $request, int $id)
    {
        // 2. Compute summarized totals
        $service = new DeclarationTotalService($id);

        // 2. Authorization Check: Ensure authenticated user owns this declaration
        if ($service->declarationUnderReview()->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized action. You do not own this declaration.'
            ], 403);
        }

        $totals = $service->calculateTotalValues();

        // 3. Render the target Blade view: resources/views/documents/official2017.blade.php
        $pdf = Pdf::loadView('documents.official2017', [
            'declaration' => $service->declarationUnderReview(),
            'totals' => $totals,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("declaration_{$service->declarationUnderReview()->id}.pdf");
    }
}
