<?php

namespace Database\Seeders;

use App\DomainServices\ConsultationService;
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
        $daysCount = 4;

        $consultationsByDays = [];

        for ($i = 0; $i < $daysCount; $i++) {
            $day = Carbon::now()->addDays($i)->toDateString();

            foreach (ConsultationService::AVAILABLE_TIME_RANGES_IN_UTC as $key => $timeRange) {
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
