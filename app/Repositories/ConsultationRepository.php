<?php

namespace App\Repositories;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ConsultationRepository
 * @package App\Repositories
 */
class ConsultationRepository extends BaseRepository
{
    /**
     * Method gets all consultations.
     *
     * @param array|string[] $columns
     * @return Collection
     */
    public function getAllConsultations(array $columns = ['*']): Collection
    {
        return Consultation::with('user')->get($columns);
    }

    /**
     * Method checks a consultation availability.
     *
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    public function checkConsultationAvailability(string $startDate, string $endDate): bool
    {
        return Consultation::whereStartAt($startDate)->whereEndAt($endDate)->exists();
    }
}
