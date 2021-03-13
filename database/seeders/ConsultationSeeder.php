<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class ConsultationSeeder
 * @package Database\Seeders
 */
class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Поскольку сиды в Laravel рабатают через транзакции пришлось упростить заполнение БД через них.
         *
         * В другом случае рандомное заполнение БД выглядело бы так и был бы в отдельном файле фабрики:
         *
         * do {
         *      $day = Carbon::now()->addDays(rand(0, 4))->toDateString();
         *
         *      $timeRange = $availableTimeRanges[array_rand($availableTimeRanges)];
         *
         *      $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeRange['start']);
         *      $endAt = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeRange['end']);
         *
         * } while (Consultation::whereStartAt($startAt)->whereEndAt($endAt)->exists());
         */

        $daysCount = 4;

        $consultationsByDays = [];

        $availableTimeRanges = [
            [
                'start' => '10:00:00',
                'end' => '11:00:00'
            ],
            [
                'start' => '11:00:00',
                'end' => '12:00:00'
            ],
            [
                'start' => '12:00:00',
                'end' => '13:00:00'
            ],
            [
                'start' => '14:00:00',
                'end' => '15:00:00'
            ],
            [
                'start' => '15:00:00',
                'end' => '16:00:00'
            ],
            [
                'start' => '16:00:00',
                'end' => '17:00:00'
            ],
            [
                'start' => '17:00:00',
                'end' => '18:00:00'
            ]
        ];

        for ($i = 0; $i < $daysCount; $i++) {
            $day = Carbon::now()->addDays($i)->toDateString();

            foreach ($availableTimeRanges as $key => $timeRange) {
                $userId = User::all()->random()->id;

                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeRange['start']);
                $endAt = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeRange['end']);

                $isConsultationExists = Consultation::whereStartAt($startAt)->whereEndAt($endAt)->exists();

                if (!$isConsultationExists) {
                    $consultationsByDays[$i][$key]['userId'] = $userId;
                    $consultationsByDays[$i][$key]['startAt'] = $startAt->toDateTimeString();
                    $consultationsByDays[$i][$key]['endAt'] = $endAt->toDateTimeString();
                }
            }
        }

        foreach ($consultationsByDays as $consultations) {
            foreach ($consultations as $consultation) {
                $record = new Consultation();

                $record->user_id = $consultation['userId'];
                $record->start_at = $consultation['startAt'];
                $record->end_at = $consultation['endAt'];

                $record->save();
            }
        }
    }
}
