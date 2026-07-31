<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationPdfRequest;
use App\Models\Declaration;
use App\Services\DeclarationTotalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DeclarationPdfController extends Controller
{
    public function download(DeclarationPdfRequest $request, int $id)
    {
        // 2. Compute summarized totals
        $service = new DeclarationTotalService($id);
        $declarationToDownload = $service->declarationUnderReview();

        // 2. Authorization Check: Ensure authenticated user owns this declaration
        if ($declarationToDownload->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized action. You do not own this declaration.'
            ], 403);
        }

        $totals = $service->calculateTotalValues();

        // 3. Render the target Blade view: resources/views/documents/official2017.blade.php
        $pdf = Pdf::loadView('documents.official2017', [
            'declaration' => $declarationToDownload,
            'totals' => $totals,
            'includePersonalAssets' => $request->boolean('include_personal', true),
            'includeSpouseAssets' => $request->boolean('include_spouse') && $declarationToDownload->hasSpouse(),
            'includeChildrenAssets' => $request->boolean('include_children') && $declarationToDownload->minorChildrenCount() > 0
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("declaration_{$service->declarationUnderReview()->id}.pdf");
    }
}
