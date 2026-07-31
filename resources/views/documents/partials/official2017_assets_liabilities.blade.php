@props(['declaration', 'owner', 'title', 'subtitle'])

<h3 class="text-center">{{ $title }}</h3>
<h4 class="text-center mb-2">{{ $subtitle }}</h4>

<!-- 1. Real Estate -->
<h4>1. Ακίνητη Ιδιοκτησία</h4>
@forelse($declaration->realEstatesOfOwner($owner) as $realEstate)
    <table class="form-table">
        <tr>
            <td class="label">Τοποθεσία:</td>
            <td>{{ $realEstate->location ?? $realEstate->address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Είδος / Έκταση:</td>
            <td>{{ $realEstate->type ?? '-' }} - {{ $realEstate->area ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Τοπογραφικά στοιχεία:</td>
            <td>{{ $realEstate->topographical_details ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Εμπράγματα δικαιώματα & βάρη:</td>
            <td>{{ $realEstate->encumbrances ?? 'Κανένα' }}</td>
        </tr>
        <tr>
            <td class="label">Τρόπος & Χρόνος απόκτησης:</td>
            <td>{{ $realEstate->acquisition_method ?? '-' }} ({{ $realEstate->acquisition_year ?? '-' }})</td>
        </tr>
        <tr>
            <td class="label">Αξία (Αρχική & Τρέχουσα):</td>
            <td>
                Αρχική: €{{ number_format((float) ($realEstate->acquisition_value ?? 0), 2) }} <br/>
                Τρέχουσα: €{{ number_format((float) ($realEstate->current_value ?? 0), 2) }}
            </td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένα στοιχεία ακίνητης ιδιοκτησίας.</p>
@endforelse

<!-- 2. Vehicles -->
<h4>2. Μηχανοκίνητα Μεταφορικά Μέσα</h4>
@forelse($declaration->vehiclesOfOwner($owner) as $vehicle)
    <table class="form-table">
        <tr>
            <td class="label">Περιγραφή μεταφορικού μέσου:</td>
            <td>{{ $vehicle->description ?? $vehicle->make_model ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Αξία:</td>
            <td>€{{ number_format((float) ($vehicle->value ?? 0), 2) }}</td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένα μεταφορικά μέσα.</p>
@endforelse

<!-- 3. Businesses -->
<h4>3. Συμμετοχή σε Επιχειρήσεις</h4>
@forelse($declaration->businessesOfOwner($owner) as $business)
    <table class="form-table">
        <tr>
            <td class="label">Επωνυμία επιχείρησης:</td>
            <td>{{ $business->name ?? $business->company_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Είδος συμμετοχής / Αξία:</td>
            <td>€{{ number_format((float) ($business->value ?? 0), 2) }}</td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένες συμμετοχές σε επιχειρήσεις.</p>
@endforelse

<!-- 4. Investments -->
<h4>4. Χρεόγραφα & Μετοχές</h4>
@forelse($declaration->investmentsOfOwner($owner) as $investment)
    <table class="form-table">
        <tr>
            <td class="label">Περιγραφή επένδυσης / τίτλου:</td>
            <td>{{ $investment->description ?? $investment->title ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Αξία:</td>
            <td>€{{ number_format((float) ($investment->value ?? 0), 2) }}</td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένες επενδύσεις ή χρεόγραφα.</p>
@endforelse

<!-- 5. Deposits -->
<h4>5. Καταθέσεις σε Τράπεζες / Ταμιευτήρια</h4>
@forelse($declaration->depositsOfOwner($owner) as $deposit)
    <table class="form-table">
        <tr>
            <td class="label">Όνομα τραπεζικού οργανισμού:</td>
            <td>{{ $deposit->bank_name ?? $deposit->institution ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Ποσό καταθέσεων:</td>
            <td>€{{ number_format((float) ($deposit->value ?? 0), 2) }}</td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένες καταθέσεις.</p>
@endforelse

<!-- 6. Debts -->
<h4>6. Χρέη & Οφειλές</h4>
@forelse($declaration->debtsOfOwner($owner) as $debt)
    <table class="form-table">
        <tr>
            <td class="label">Όνομα πιστωτή:</td>
            <td>{{ $debt->creditor_name ?? $debt->creditor ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Είδος χρέους:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $debt->debt_type ?? '')) }}</td>
        </tr>
        <tr>
            <td class="label">Ποσό χρέους:</td>
            <td>€{{ number_format((float) ($debt->value ?? 0), 2) }}</td>
        </tr>
    </table>
@empty
    <p>Δεν υπάρχουν καταγεγραμμένες οφειλές.</p>
@endforelse

<div class="page-break"></div>

