<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\MutasiFilterRequest;
use App\Services\WealthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MutasiController extends Controller
{
    public function __construct(
        private readonly WealthService $wealthService
    ) {}

    /**
     * SRS-BNK-002: Mutasi Rekening
     * Show paginated transaction history with filters.
     */
    public function index(MutasiFilterRequest $request): InertiaResponse
    {
        $userId  = $request->user()->id;
        $account = Account::where('user_id', $userId)->first();

        $transactions = null;

        if ($account) {
            $filters = $request->only([
                'date_from',
                'date_to',
                'transaction_type',
                'direction',
            ]);

            $transactions = $this->wealthService->getMutasi(
                accountId: $account->id,
                filters: $filters,
                perPage: 15
            )->withQueryString();
        }

        return Inertia::render('wealth/mutasi', [
            'account'      => $account,
            'transactions' => $transactions,
            'filters'      => $request->only(['date_from', 'date_to', 'transaction_type', 'direction']),
        ]);
    }

    /**
     * Export mutasi rekening as a CSV file.
     * Applies the same filters as the index page.
     */
    public function exportCsv(MutasiFilterRequest $request): StreamedResponse
    {
        $userId  = $request->user()->id;
        $account = Account::where('user_id', $userId)->first();

        abort_unless($account, 404, 'Rekening tidak ditemukan.');

        $filters = $request->only([
            'date_from',
            'date_to',
            'transaction_type',
            'direction',
        ]);

        $transactions = $this->wealthService->getMutasiAll(
            accountId: $account->id,
            filters: $filters,
        );

        $filename = 'mutasi_' . $account->nomor_rekening . '_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($transactions, $account) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM agar Excel membaca karakter Indonesia dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            // Baris info rekening
            fputcsv($handle, ['Mutasi Rekening CIMB Niaga']);
            fputcsv($handle, ['No. Rekening', $account->nomor_rekening]);
            fputcsv($handle, ['Jenis Rekening', $account->account_type_label ?? $account->account_type]);
            fputcsv($handle, ['Diekspor pada', now()->format('d M Y, H:i:s') . ' WIB']);
            fputcsv($handle, []); // baris kosong pemisah

            // Header kolom
            fputcsv($handle, [
                'Tanggal',
                'Reference ID',
                'Tipe Transaksi',
                'Arah',
                'Jumlah (IDR)',
                'Saldo Sebelum (IDR)',
                'Saldo Sesudah (IDR)',
                'Status',
                'Keterangan',
            ]);

            // Baris data
            foreach ($transactions as $trx) {
                fputcsv($handle, [
                    $trx->created_at->format('d/m/Y H:i:s'),
                    $trx->reference_id,
                    $trx->transaction_type,
                    $trx->direction === 'credit' ? 'Kredit' : 'Debit',
                    number_format($trx->amount, 2, '.', ''),
                    number_format($trx->balance_before, 2, '.', ''),
                    number_format($trx->balance_after, 2, '.', ''),
                    $trx->status,
                    $trx->description ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}

