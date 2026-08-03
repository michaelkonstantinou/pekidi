@props(['declaration', 'owner', 'title', 'subtitle'])

<div style="page-break-inside: avoid;">
    <div class="section-header">
        <h3 class="section-title">{{ $title }}</h3>
        <p class="section-subtitle">{{ $subtitle }}</p>
    </div>
</div>

<!-- 1. Real Estate -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        1. Ακίνητη Ιδιοκτησία
    </h4>

    @forelse($declaration->realEstatesOfOwner($owner) as $realEstate)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Τοποθεσία:</td>
                <td class="value font-bold">{{ $realEstate->location ?? $realEstate->address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Είδος / Έκταση:</td>
                <td class="value">{{ $realEstate->type ?? '-' }} - {{ $realEstate->area ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Τοπογραφικά στοιχεία:</td>
                <td class="value">{{ $realEstate->topographical_details ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Εμπράγματα δικαιώματα &amp; βάρη:</td>
                <td class="value">{{ $realEstate->encumbrances ?? 'Κανένα' }}</td>
            </tr>
            <tr>
                <td class="label">Τρόπος &amp; Χρόνος απόκτησης:</td>
                <td class="value">{{ $realEstate->acquisition_method ?? '-' }} ({{ $realEstate->acquisition_year ?? '-' }})</td>
            </tr>
            <tr>
                <td class="label">Αξία (Αρχική &amp; Τρέχουσα):</td>
                <td class="value">
                    <span style="color: #64748b;">Αρχική:</span> €{{ number_format((float) ($realEstate->acquisition_value ?? 0), 2) }} <br/>
                    <span style="color: #0f172a; font-weight: bold;">Τρέχουσα:</span> €{{ number_format((float) ($realEstate->current_value ?? 0), 2) }}
                </td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένα στοιχεία ακίνητης ιδιοκτησίας.
        </div>
    @endforelse
</div>

<!-- 2. Vehicles -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        2. Μηχανοκίνητα Μεταφορικά Μέσα
    </h4>

    @forelse($declaration->vehiclesOfOwner($owner) as $vehicle)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Περιγραφή μεταφορικού μέσου:</td>
                <td class="value font-bold">{{ $vehicle->description ?? $vehicle->make_model ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Αξία:</td>
                <td class="value">€{{ number_format((float) ($vehicle->value ?? 0), 2) }}</td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένα μεταφορικά μέσα.
        </div>
    @endforelse
</div>

<!-- 3. Businesses -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        3. Συμμετοχή σε Επιχειρήσεις
    </h4>

    @forelse($declaration->businessesOfOwner($owner) as $business)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Επωνυμία επιχείρησης:</td>
                <td class="value font-bold">{{ $business->name ?? $business->company_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Είδος συμμετοχής / Αξία:</td>
                <td class="value">€{{ number_format((float) ($business->value ?? 0), 2) }}</td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένες συμμετοχές σε επιχειρήσεις.
        </div>
    @endforelse
</div>

<!-- 4. Investments -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        4. Χρεόγραφα &amp; Μετοχές
    </h4>

    @forelse($declaration->investmentsOfOwner($owner) as $investment)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Περιγραφή επένδυσης / τίτλου:</td>
                <td class="value font-bold">{{ $investment->description ?? $investment->title ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Αξία:</td>
                <td class="value">€{{ number_format((float) ($investment->value ?? 0), 2) }}</td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένες επενδύσεις ή χρεόγραφα.
        </div>
    @endforelse
</div>

<!-- 5. Deposits -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        5. Καταθέσεις σε Τράπεζες / Ταμιευτήρια
    </h4>

    @forelse($declaration->depositsOfOwner($owner) as $deposit)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Όνομα τραπεζικού οργανισμού:</td>
                <td class="value font-bold">{{ $deposit->bank_name ?? $deposit->institution ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Ποσό καταθέσεων:</td>
                <td class="value">€{{ number_format((float) ($deposit->value ?? 0), 2) }}</td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένες καταθέσεις.
        </div>
    @endforelse
</div>

<!-- 6. Debts -->
<div style="margin-top: 18px; page-break-inside: avoid;">
    <h4 style="margin: 0 0 8px 0; font-size: 10pt; color: #0f172a; font-weight: bold; text-transform: uppercase; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; letter-spacing: 0.3px;">
        6. Χρέη &amp; Οφειλές
    </h4>

    @forelse($declaration->debtsOfOwner($owner) as $debt)
        <table class="kv-table" style="page-break-inside: avoid; margin-bottom: 12px;">
            <tr>
                <td class="label">Όνομα πιστωτή:</td>
                <td class="value font-bold">{{ $debt->creditor_name ?? $debt->creditor ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Είδος χρέους:</td>
                <td class="value">{{ ucfirst(str_replace('_', ' ', $debt->debt_type ?? '')) }}</td>
            </tr>
            <tr>
                <td class="label">Ποσό χρέους:</td>
                <td class="value">€{{ number_format((float) ($debt->value ?? 0), 2) }}</td>
            </tr>
        </table>
    @empty
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; text-align: center; font-style: italic; color: #64748b; font-size: 8.5pt; margin-bottom: 15px;">
            Δεν υπάρχουν καταγεγραμμένες οφειλές.
        </div>
    @endforelse
</div>

<div class="page-break"></div>
