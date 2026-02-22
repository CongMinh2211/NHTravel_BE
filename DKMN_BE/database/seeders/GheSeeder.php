<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GheSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ghes')->delete();
        Schema::enableForeignKeyConstraints();

        $now = now();

        $trips = DB::table('chuyen_dis')
            ->join('nha_van_hanhs', 'chuyen_dis.nha_van_hanh_id', '=', 'nha_van_hanhs.id')
            ->select('chuyen_dis.id', 'chuyen_dis.gia_co_ban', 'chuyen_dis.tong_ghe', 'nha_van_hanhs.loai')
            ->orderBy('chuyen_dis.id')
            ->get();

        $seatRows = [];
        $availableByTrip = [];

        foreach ($trips as $trip) {
            $seatCount = (int) $trip->tong_ghe;

            for ($i = 1; $i <= $seatCount; $i++) {
                $status = $this->seatStatus($i);
                $seatRows[] = [
                    'chuyen_di_id' => $trip->id,
                    'so_ghe' => $this->seatLabel($trip->loai, $i),
                    'loai_ghe' => $this->seatType($trip->loai),
                    'gia' => $trip->gia_co_ban,
                    'trang_thai' => $status,
                    'ngay_tao' => $now,
                ];

                if ($status === 'trong') {
                    $availableByTrip[$trip->id] = ($availableByTrip[$trip->id] ?? 0) + 1;
                }
            }
        }

        foreach (array_chunk($seatRows, 1000) as $chunk) {
            DB::table('ghes')->insert($chunk);
        }

        foreach ($availableByTrip as $tripId => $available) {
            DB::table('chuyen_dis')
                ->where('id', $tripId)
                ->update([
                    'ghe_con' => $available,
                    'ngay_cap_nhat' => now(),
                ]);
        }
    }

    private function seatLabel(string $vehicleType, int $index): string
    {
        return $this->twoDeckSeatLabel($index);
    }

    private function twoDeckSeatLabel(int $index): string
    {
        $deckSize = 20;
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];

        $deck = intdiv(max(0, $index - 1), $deckSize);
        $letter = $letters[$deck] ?? chr(ord('A') + $deck);
        $number = (($index - 1) % $deckSize) + 1;

        return sprintf('%s%d', $letter, $number);
    }

    private function seatType(string $vehicleType): string
    {
        return match ($vehicleType) {
            'may_bay' => 'thuong_gia',
            'tau_hoa' => 'vip',
            default => 'thuong',
        };
    }

    private function seatStatus(int $index): string
    {
        if ($index % 13 === 0) {
            return 'da_dat';
        }

        if ($index % 29 === 0) {
            return 'khoa';
        }

        return 'trong';
    }
}
