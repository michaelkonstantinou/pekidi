<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationPdfRequest;
use App\Models\User;
use App\Services\DeclarationTotalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DeclarationPdfController extends Controller
{
    public function download(DeclarationPdfRequest $request, int $id): Response|JsonResponse
    {
        // 1. Compute summarized totals
        $service = new DeclarationTotalService($id);
        $declarationToDownload = $service->declarationUnderReview();

        // 2. Authorization Check: Ensure authenticated user owns this declaration
        /** @var ?User $user */
        $user = Auth::user();
        if ($user === null || $user->id !== $declarationToDownload->user_id) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $totals = $service->calculateTotalValues();

        // 3. Render the target Blade view
        $pdf = Pdf::loadView('documents.official2017', [
            'declaration' => $declarationToDownload,
            'totals' => $totals,
            'hideSensitiveInfo' => $request->getDocumentType()->hideSensitiveInfo(),
            'includePersonalAssets' => $request->boolean('include_personal', true),
            'includeSpouseAssets' => $request->boolean('include_spouse') && $declarationToDownload->hasSpouse(),
            'includeChildrenAssets' => $request->boolean('include_children') && $declarationToDownload->minorChildrenCount() > 0
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("declaration_{$service->declarationUnderReview()->id}.pdf");
    }
}
