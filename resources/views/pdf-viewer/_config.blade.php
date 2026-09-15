@php
    $documentTitle = request('title', 'Dokumen');
    $pdfSource = $pdfPath ?: '';
    $documentType = request('document_type', 'Tesis');
@endphp

<div
    id="pdf-config"
    data-pdf-url="{{ $pdfSource ? route('pdf.proxy', ['url' => $pdfSource]) : '' }}"
    data-source-url="{{ $pdfSource }}"
    data-title="{{ $documentTitle }}"
    data-document-type="{{ $documentType }}"
    data-nama="{{ request('nama', '-') }}"
    data-nim="{{ request('nim', '-') }}"
    data-bab="{{ request('bab', $documentTitle) }}"
    data-work-title="{{ request('tesis', request('skripsi', '-')) }}"
    hidden>
</div>