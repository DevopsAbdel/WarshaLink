<?php

use App\Models\BonCommande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/bon-commande/{id}/pdf', function ($id) {
    $bc = BonCommande::with(['fournisseur', 'demandeAchat.chantier.ville', 'demandeAchat.lignesAchat.article'])->findOrFail($id);
    
    $pdf = Pdf::loadView('pdf.bon_commande', compact('bc'))
        ->setPaper('a4', 'portrait');

    return $pdf->download("Bon_de_Commande_{$bc->numero_bc}.pdf");
})->name('bon-commande.pdf');

Route::get('/dossier-client-pdf', function () {
    $pdf = Pdf::loadView('pdf.dossier_commercial_mme_ghita')
        ->setPaper('a4', 'portrait');

    return $pdf->stream("Dossier_Proposition_BTP_Madame_Ghita.pdf");
})->name('dossier.client.pdf');
