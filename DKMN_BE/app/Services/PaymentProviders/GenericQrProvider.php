<?php

namespace App\Services\PaymentProviders;

use App\Contracts\PaymentProviderInterface;
use App\Models\Payment;
use Illuminate\Support\Str;

class GenericQrProvider implements PaymentProviderInterface
{
    public function __construct(
        protected string $key,
        protected string $label,
        protected string $account,
        protected string $baseUrl = 'https://img.vietqr.io/image'
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function generateQr(int $amount, Payment $payment): array
    {
        $note = $this->buildQrNote($payment);
        $payload = urlencode($note);
        $qrImageUrl = sprintf(
            '%s/%s-compact.png?amount=%d&addInfo=%s',
            rtrim($this->baseUrl, '/'),
            $this->account,
            $amount,
            $payload
        );

        return [
            'qrImageUrl' => $qrImageUrl,
            'providerRef' => strtoupper(sprintf('%s-%s', $this->key, $payment->id)),
            'metadata' => [
                'amount' => $amount,
                'ticket_id' => $payment->ticket_id,
                'note' => $note,
            ],
        ];
    }

    protected function buildQrNote(Payment $payment): string
    {
        $payment->loadMissing([
            'ticket.donHang',
            'ticket.trip.tramDi.tinhThanh',
            'ticket.trip.tramDen.tinhThanh',
        ]);

        $ticket = $payment->ticket;

        $from = null;
        $to = null;
        $seats = '';

        if ($ticket) {
            $order = $ticket->donHang;
            $trip = $ticket->trip;

            $from = $order->noi_di
                ?? $trip?->tramDi?->tinhThanh?->ten
                ?? $trip?->tramDi?->ten;
            $to = $order->noi_den
                ?? $trip?->tramDen?->tinhThanh?->ten
                ?? $trip?->tramDen?->ten;

            $seats = $this->formatSeatList($ticket->seat_numbers);
        }

        $message = 'Đặt vé tại DKMN';
        return Str::upper(Str::ascii($message));
    }

    protected function formatSeatList(?string $seatNumbers): ?string
    {
        if (!$seatNumbers) {
            return null;
        }

        $parts = array_filter(array_map(static function ($seat) {
            return trim($seat);
        }, explode(',', $seatNumbers)));

        if (empty($parts)) {
            return null;
        }

        return implode('-', $parts);
    }

}
