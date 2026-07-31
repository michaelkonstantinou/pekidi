<!DOCTYPE html>
<html lang="el">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Δήλωση Περιουσιακών Στοιχείων</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mt-4 { margin-top: 1.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }

        table.form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        table.form-table td, table.form-table th {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }

        table.form-table td.label {
            width: 35%;
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- COVER PAGE -->
<div class="text-center">
    <h4 style="margin-bottom: 5px;">
        Ο ΠΕΡΙ ΤΟΥ ΠΡΟΕΔΡΟΥ, ΤΩΝ ΥΠΟΥΡΓΩΝ ΚΑΙ ΤΩΝ ΒΟΥΛΕΥΤΩΝ ΤΗΣ ΚΥΠΡΙΑΚΗΣ ΔΗΜΟΚΡΑΤΙΑΣ (ΔΗΛΩΣΗ ΚΑΙ ΕΛΕΓΧΟΣ ΠΕΡΙΟΥΣΙΑΣ) ΝΟΜΟΣ
    </h4>
    <p>[49(Ι), 269(Ι) του 2004 και 68(Ι) του 2017]</p>
    <p style="margin-top: 20px;">(Άρθρο 4)</p>

    <h2 style="margin-top: 50px;">ΔΗΛΩΣΗ<br/>ΠΕΡΙΟΥΣΙΑΚΩΝ ΣТОΙΧΕΙΩΝ</h2>
</div>

<div class="page-break"></div>

<!-- PART A: PERSONAL DETAILS -->
<h3 class="text-center">ΜΕΡΟΣ Α'</h3>
<h4 class="text-center mb-2">ΠΡΟΣΩΠΙΚΑ ΣΤΟΙΧΕΙΑ ΔΗΛΟΥΝΤΟΣ</h4>

<table class="form-table mt-4">
    <tr>
        <td class="label">Ονοματεπώνυμο:</td>
        <td>{{ $declaration->full_name }}</td>
    </tr>
    <tr>
        <td class="label">Ιδιότητα - Αξίωμα:</td>
        <td>{{ $declaration->name }}</td>
    </tr>
    <tr>
        <td class="label">Διεύθυνση κατοικίας:</td>
        <td>{{ $declaration->home_address }}</td>
    </tr>
    <tr>
        <td class="label">Ημερομηνία γεννήσεως:</td>
        <td>{{ $declaration->born_at ? \Carbon\Carbon::parse($declaration->born_at)->format('d/m/Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="label">Αριθμός ταυτότητας:</td>
        <td>{{ $declaration->national_id }}</td>
    </tr>
    <tr>
        <td class="label">Έγγαμος / Άγαμος:</td>
        <td>{{ $declaration->hasSpouse() ? 'Έγγαμος/η' : 'Άγαμος/η' }}</td>
    </tr>
    <tr>
        <td class="label">Αριθμός ανήλικων τέκνων:</td>
        <td>{{ $declaration->minorChildrenCount() }}</td>
    </tr>
</table>

<div style="margin-top: 40px;">
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 50%; border: none;">
                <strong>Ημερομηνία:</strong> {{ date('d/m/Y') }}
            </td>
            <td style="width: 50%; border: none; text-align: right;">
                <strong>Υπογραφή:</strong> ....................................
            </td>
        </tr>
    </table>
</div>

<div class="page-break"></div>

<!-- PART B: SPOUSE & MINOR CHILDREN DETAILS -->
<h3 class="text-center">ΜΕΡΟΣ Β'</h3>
<h4 class="text-center mb-2">
    ΠΡΟΣΩΠΙΚΑ ΣΤΟΙΧΕΙΑ ΤΟΥ/ΤΗΣ ΣΥΖΥΓΟΥ ΚΑΙ ΤΩΝ ΑΝΗΛΙΚΩΝ ΤΕΚΝΩΝ<br/>
    ΠΡΟΕΔΡΟΥ, ΥΠΟΥΡΓΟΥ Ή ΒΟΥΛΕΥΤΗ
</h4>

<table class="form-table mt-4">
    <thead>
    <tr style="background-color: #f9f9f9;">
        <th style="width: 35%;">Ονοματεπώνυμο</th>
        <th style="width: 20%;" class="text-center">Ημερομηνία Γεννήσεως</th>
        <th style="width: 20%;" class="text-center">Αριθμός Ταυτότητας</th>
        <th style="width: 25%;">Ιδιότητα</th>
    </tr>
    </thead>
    <tbody>
    @forelse($declaration->familyMembers as $member)
        <tr>
            <td>{{ $member->full_name }}</td>
            <td class="text-center">
                {{ $member->born_at ? \Carbon\Carbon::parse($member->born_at)->format('d/m/Y') : '-' }}
            </td>
            <td class="text-center">{{ $member->national_id ?? '-' }}</td>
            <td>{{ $member->profession ?? $member->relationship?->value ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center" style="font-style: italic; padding: 12px;">
                Δεν υπάρχουν καταγεγραμμένα στοιχεία συζύγου ή ανήλικων τέκνων.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="page-break"></div>

<!-- PART C: DECLARANT'S ASSETS & DEBTS (SELF) -->
@includeWhen($includePersonalAssets, 'documents.partials.official2017_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Self,
    'title' => "ΜΕΡΟΣ Γ'",
    'subtitle' => 'ΠΕΡΙΟΥΣΙΑΚΑ ΣΤΟΙΧΕΙΑ ΔΗΛΟΥΝΤΟΣ (Εντός και εκτός της Δημοκρατίας)',
])

<!-- PART D: SPOUSE'S ASSETS & DEBTS -->
@includeWhen($includeSpouseAssets, 'documents.partials.official2017_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Spouse,
    'title' => "ΜΕΡΟΣ Δ'",
    'subtitle' => 'ΠΕΡΙΟΥΣΙΑΚΑ ΣΤΟΙΧΕΙΑ ΣΥΖΥΓΟΥ (Εντός και εκτός της Δημοκρατίας)',
])

<!-- PART E: CHILDREN'S ASSETS & DEBTS -->
@includeWhen($includeChildrenAssets, 'documents.partials.official2017_assets_liabilities', [
    'declaration' => $declaration,
    'owner' => \App\Types\OwnerType::Child,
    'title' => "ΜΕΡΟΣ Ε'",
    'subtitle' => 'ΠΕΡΙΟΥΣΙΑΚΑ ΣΤΟΙΧΕΙΑ ΑΝΗΛΙΚΩΝ ΤΕΚΝΩΝ (Εντός και εκτός της Δημοκρατίας)',
])

<!-- FINANCIAL OVERVIEW SUMMARY -->
<h3 class="text-center">ΣΥΝΟΨΗ ΠΕΡΙΟΥΣΙΑΚΗΣ ΚΑΤΑΣΤΑΣΗΣ</h3>
<table class="form-table mt-4">
    <thead>
    <tr style="background-color: #eee;">
        <th>Κατηγορία</th>
        <th class="text-right">Σύνολο (€)</th>
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
        <td>Σύνολο Επενδύσεων & Χρεογράφων</td>
        <td class="text-right">€{{ number_format($totals->investments->totalValue, 2) }}</td>
    </tr>
    <tr>
        <td>Σύνολο Τραπεζικών Καταθέσεων</td>
        <td class="text-right">€{{ number_format($totals->deposits->totalValue, 2) }}</td>
    </tr>
    <tr style="font-weight: bold; background-color: #f0f0f0;">
        <td>ΣΥΝΟΛΟ ΕΝΕΡΓΗΤΙΚΟΥ (ASSETS)</td>
        <td class="text-right">€{{ number_format($totals->totalAssetsValue, 2) }}</td>
    </tr>
    <tr style="font-weight: bold; background-color: #fbeaea;">
        <td>ΣΥΝΟΛΟ ΥΠΟΧΡΕΩΣΕΩΝ (DEBTS)</td>
        <td class="text-right">€{{ number_format($totals->totalLiabilitiesValue, 2) }}</td>
    </tr>
    <tr style="font-weight: bold; font-size: 12pt; background-color: #e2f0d9;">
        <td>ΚΑΘΑΡΗ ΘΕΣΗ (NET WORTH - FAMILY)</td>
        <td class="text-right">€{{ number_format($totals->netWorth->family, 2) }}</td>
    </tr>
    </tbody>
</table>

</body>
</html>
