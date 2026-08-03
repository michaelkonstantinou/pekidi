<!DOCTYPE html>
<html lang="el">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Δήλωση Περιουσιακών Στοιχείων - ΠΕΚΥΔΗ</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1.8cm 1.5cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9.5pt;
            line-height: 1.5;
            color: #334155;
            background-color: #ffffff;
        }

        /* Helper Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }

        .page-break {
            page-break-after: always;
        }

        /* Colors & Badges */
        .primary-color { color: #0f172a; }
        .muted-color { color: #64748b; }

        /* Section Headers */
        .section-header {
            margin-top: 15px;
            margin-bottom: 12px;
            border-bottom: 2px solid #334155;
            padding-bottom: 6px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
            margin: 0;
            text-transform: uppercase;
        }

        .section-subtitle {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 2px;
            margin-bottom: 0;
        }

        /* Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background-color: #ffffff;
        }

        table.data-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 10px;
            border: 1px solid #1e293b;
            text-align: left;
        }

        table.data-table td {
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 9pt;
        }

        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* Key-Value Detail Table */
        table.kv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        table.kv-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 9pt;
        }

        table.kv-table td.label {
            width: 32%;
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            border-right: 1px solid #e2e8f0;
        }

        table.kv-table td.value {
            color: #0f172a;
            background-color: #ffffff;
        }

        /* Financial Summary Highlights */
        .summary-table td {
            padding: 9px 12px !important;
        }

        .row-assets {
            background-color: #f1f5f9 !important;
            font-weight: bold;
            color: #0f172a;
        }

        .row-liabilities {
            background-color: #fef2f2 !important;
            color: #991b1b;
            font-weight: bold;
        }

        .row-networth {
            background-color: #f0fdf4 !important;
            color: #166534;
            font-weight: bold;
            font-size: 10.5pt !important;
        }

        /* Signatures Area */
        .signature-container {
            /*margin-top: 40px;*/
            width: 100%;
            page-break-inside: avoid;
            position: absolute;
            bottom: -10px; left: 0; right: 0;
            height: 40px;
        }

        .signature-box {
            border-top: 1px solid #94a3b8;
            padding-top: 6px;
            text-align: center;
            font-size: 8.5pt;
            color: #475569;
        }
    </style>
</head>
<body>

<!-- COVER PAGE -->
<div style="padding: 20px 0; text-align: center;">
    <div style="border-bottom: 2px solid #1e293b; padding-bottom: 15px; margin-bottom: 30px;">
        <h3 style="margin: 0; font-size: 16pt; color: #0f172a; font-weight: bold; letter-spacing: 1px;">
            ΠΕΚΥΔΗ
        </h3>
        <p style="margin: 4px 0 0 0; font-size: 8.5pt; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
            Πλατφόρμα Εκκαθάρισης &amp; Καταγραφής Υποχρεώσεων &amp; Δηλώσεων Ηλεκτρονικά
        </p>
    </div>

    <div style="margin-top: 90px; margin-bottom: 12px; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 30px; border-radius: 6px;">
        <span style="font-size: 8.5pt; text-transform: uppercase; letter-spacing: 1.5px; color: #0284c7; font-weight: bold;">
            ΑΝΑΦΟΡΑ ΠΕΡΙΟΥΣΙΑΚΗΣ ΚΑΤΑΣΤΑΣΗΣ
        </span>
        <h1 style="font-size: 20pt; margin: 15px 0 6px 0; color: #0f172a; letter-spacing: 0.5px;">
            ΔΗΛΩΣΗ ΠΕΡΙΟΥΣΙΑΚΩΝ ΣΤΟΙΧΕΙΩΝ
        </h1>
        <p style="margin: 0; font-size: 9.5pt; color: #475569;">
            Έκδοση Αναφοράς Εφαρμογής ΠΕΚΥΔΗ
        </p>
    </div>

    <div class="signature-container">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: bottom; font-size: 8.5pt; color: #64748b;">
                    <strong>Ημερομηνία Παραγωγής:</strong> {{ date('d/m/Y') }}
                </td>
                <td style="width: 50%; text-align: right; vertical-align: bottom; font-size: 8.5pt; color: #64748b;">
                    <strong>Σύστημα:</strong> ΠΕΚΥΔΗ
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break"></div>

<!-- PART A: PERSONAL DETAILS -->
<div class="section-header">
    <h3 class="section-title">ΜΕΡΟΣ Α'</h3>
    <p class="section-subtitle">Προσωπικά Στοιχεία Δηλούντος</p>
</div>

<table class="kv-table">
    <tr>
        <td class="label">Ονοματεπώνυμο:</td>
        <td class="value font-bold">{{ $declaration->full_name }}</td>
    </tr>
    <tr>
        <td class="label">Ιδιότητα - Αξίωμα:</td>
        <td class="value">{{ $declaration->name }}</td>
    </tr>
    <tr>
        <td class="label">Διεύθυνση Κατοικίας:</td>
        <td class="value">{{ $hideSensitiveInfo ? '******' : $declaration->home_address }}</td>
    </tr>
    <tr>
        <td class="label">Ημερομηνία Γεννήσεως:</td>
        <td class="value">{{ $declaration->born_at ? \Carbon\Carbon::parse($declaration->born_at)->format('d/m/Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="label">Αριθμός Ταυτότητας:</td>
        <td class="value">{{ $hideSensitiveInfo ? '******' : ($member->national_id ?? '-') }}</td>
    </tr>
    <tr>
        <td class="label">Οικογενειακή Κατάσταση:</td>
        <td class="value">{{ $declaration->hasSpouse() ? 'Έγγαμος/η' : 'Άγαμος/η' }}</td>
    </tr>
    <tr>
        <td class="label">Αριθμός Ανήλικων Τέκνων:</td>
        <td class="value">{{ $declaration->minorChildrenCount() }}</td>
    </tr>
</table>

<div class="signature-container">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 45%; vertical-align: top;">
                <p style="margin: 0; font-size: 9pt;"><strong>Ημερομηνία:</strong> {{ date('d/m/Y') }}</p>
            </td>
            <td style="width: 10%;"></td>
            <td style="width: 45%; vertical-align: top;">
                <div style="height: 40px;"></div>
                <div class="signature-box">
                    Υπογραφή Δηλούντος
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="page-break"></div>

<!-- PART B: SPOUSE & MINOR CHILDREN DETAILS -->
<div class="section-header">
    <h3 class="section-title">ΜΕΡΟΣ Β'</h3>
    <p class="section-subtitle">Προσωπικά Στοιχεία Συζύγου και Ανήλικων Τέκνων</p>
</div>

<table class="data-table">
    <thead>
    <tr style="background-color: #f1f5f9;">
        <th style="width: 35%; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;">Ονοματεπώνυμο</th>
        <th style="width: 20%; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;" class="text-center">Ημ. Γεννήσεως</th>
        <th style="width: 20%; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;" class="text-center">Αρ. Ταυτότητας</th>
        <th style="width: 25%; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;">Ιδιότητα / Σχέση</th>
    </tr>
    </thead>
    <tbody>
    @forelse($declaration->familyMembers as $member)
        <tr>
            <td class="font-bold">{{ $member->full_name }}</td>
            <td class="text-center">
                {{ $member->born_at ? \Carbon\Carbon::parse($member->born_at)->format('d/m/Y') : '-' }}
            </td>
            <td class="text-center">
                {{ $hideSensitiveInfo ? '******' : ($member->national_id ?? '-') }}
            </td>
            <td>{{ $member->profession ?? $member->relationship?->value ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center muted-color" style="padding: 15px; font-style: italic;">
                Δεν υπάρχουν καταγεγραμμένα στοιχεία συζύγου ή ανήλικων τέκνων.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="page-break"></div>

<!-- PART C: DECLARANT'S ASSETS & DEBTS (SELF) -->
@includeWhen($includePersonalAssets, 'documents.partials.friendly_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Self,
    'title' => "ΜΕΡΟΣ Γ'",
    'subtitle' => 'Περιουσιακά Στοιχεία Δηλούντος (Εντός και εκτός της Δημοκρατίας)',
])

<!-- PART D: SPOUSE'S ASSETS & DEBTS -->
@includeWhen($includeSpouseAssets, 'documents.partials.friendly_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Spouse,
    'title' => "ΜΕΡΟΣ Δ'",
    'subtitle' => 'Περιουσιακά Στοιχεία Συζύγου (Εντός και εκτός της Δημοκρατίας)',
])

<!-- PART E: CHILDREN'S ASSETS & DEBTS -->
@includeWhen($includeChildrenAssets, 'documents.partials.friendly_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Child,
    'title' => "ΜΕΡΟΣ Ε'",
    'subtitle' => 'Περιουσιακά Στοιχεία Ανήλικων Τέκνων (Εντός και εκτός της Δημοκρατίας)',
])

<!-- FINANCIAL OVERVIEW SUMMARY -->
<div style="page-break-inside: avoid; margin-top: 25px;">
    <div class="section-header">
        <h3 class="section-title">ΣΥΝΟΨΗ ΠΕΡΙΟΥΣΙΑΚΗΣ ΚΑΤΑΣΤΑΣΗΣ</h3>
        <p class="section-subtitle">Συγκεντρωτικός Πίνακας Ενεργητικού και Παθητικού (Οικογενειακό Σύνολο)</p>
    </div>

    <table class="data-table summary-table">
        <thead>
        <tr>
            <th>Κατηγορία</th>
            <th class="text-right" style="width: 30%;">Σύνολο (€)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Σύνολο Αξίας Ακινήτων</td>
            <td class="text-right">€{{ number_format($totals->realEstates->totalValue, 2) }}</td>
        </tr>
        <tr>
            <td>Σύνολο Αξίας Οχημάτων</td>
            <td class="text-right">€{{ number_format($totals->vehicles->totalValue, 2) }}</td>
        </tr>
        <tr>
            <td>Σύνολο Επιχειρηματικών Συμμετοχών</td>
            <td class="text-right">€{{ number_format($totals->businesses->totalValue, 2) }}</td>
        </tr>
        <tr>
            <td>Σύνολο Επενδύσεων &amp; Χρεογράφων</td>
            <td class="text-right">€{{ number_format($totals->investments->totalValue, 2) }}</td>
        </tr>
        <tr>
            <td>Σύνολο Τραπεζικών Καταθέσεων</td>
            <td class="text-right">€{{ number_format($totals->deposits->totalValue, 2) }}</td>
        </tr>
        <tr class="row-assets">
            <td>ΣΥΝΟΛΟ ΕΝΕΡΓΗΤΙΚΟΥ (ASSETS)</td>
            <td class="text-right">€{{ number_format($totals->totalAssetsValue, 2) }}</td>
        </tr>
        <tr class="row-liabilities">
            <td>ΣΥΝΟΛΟ ΥΠΟΧΡΕΩΣΕΩΝ (DEBTS)</td>
            <td class="text-right">€{{ number_format($totals->totalLiabilitiesValue, 2) }}</td>
        </tr>
        <tr class="row-networth">
            <td>ΚΑΘΑΡΗ ΘΕΣΗ (NET WORTH - FAMILY)</td>
            <td class="text-right">€{{ number_format($totals->netWorth->family, 2) }}</td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>
