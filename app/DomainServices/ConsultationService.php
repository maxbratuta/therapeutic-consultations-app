<?php

namespace App\DomainServices;

use App\Exceptions\Consultation\ConsultationException;
use App\Http\Resources\Consultation\ConsultationResourceCollection;
use App\Models\Consultation;
use App\Repositories\ConsultationRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ConsultationService
 * @package App\DomainServices
 */
class ConsultationService extends BaseService
{
    /**
     * Constant of the available time ranges in UTC.
     */
    public const AVAILABLE_TIME_RANGES_IN_UTC = [
        [
            'start' => '08:00:00',
            'end' => '09:00:00'
        ],
        [
            'start' => '09:00:00',
            'end' => '10:00:00'
        ],
        [
            'start' => '10:00:00',
            'end' => '11:00:00'
        ],
        [
            'start' => '12:00:00',
            'end' => '13:00:00'
        ],
        [
            'start' => '13:00:00',
            'end' => '14:00:00'
        ],
        [
            'start' => '14:00:00',
            'end' => '15:00:00'
        ],
        [
            'start' => '15:00:00',
            'end' => '16:00:00'
        ]
    ];

    /**
     * Constant of the background display type for the element.
     */
    public const ELEMENT_DISPLAY_TYPE_BACKGROUND = 'background';

    /** @var ConsultationRepository */
    private ConsultationRepository $consultationRepository;

    /** @var UserRepository */
    private UserRepository $userRepository;

    /**
     * ConsultationService constructor.
     *
     * @param ConsultationRepository $consultationRepository
     * @throws BindingResolutionException
     */
    public function __construct(ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;

        $this->userRepository = app()->make(UserRepository::class);

        parent::__construct();
    }

    /**
     * Method creates a new consultation.
     *
     * @param array $data
     * @return Consultation
     * @throws ConsultationException
     */
    public function store(array $data): Consultation
    {
        DB::beginTransaction();

        try {
            $dates = $this->preformDates($data['date']);

            if ($this->checkTimeRangeAvailability($dates['start']['time'], $dates['end']['time'])) {
                if (!$this->consultationRepository->checkConsultationAvailability($dates['start']['date'], $dates['end']['date'])) {
                    $data['user_id'] = $this->userRepository->getRandomUserId();
                    $data['start_at'] = $dates['start']['date'];
                    $data['end_at'] = $dates['end']['date'];

                    $record = $this->storeConsultationModel($data);
                } else {
                    throw ConsultationException::failInsert('The consultation has already been booked at this time.');
                }
            } else {
                throw ConsultationException::failInsert('You cannot book a consultation for this time.');
            }

        } catch (ConsultationException $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $record;
    }

    /**
     * Method preforms the start and end dates.
     *
     * @param string $rawDate
     * @return array[]
     */
    private function preformDates(string $rawDate): array
    {
        $date = date('Y-m-d H:00:00', strtotime($rawDate));

        $startDate = Carbon::createFromDate($date);
        $endDate = Carbon::createFromDate($date)->addHour();

        return [
            'start' => [
                'date' => $startDate,
                'time' => $startDate->toTimeString()
            ],
            'end' => [
                'date' => $endDate,
                'time' => $endDate->toTimeString()
            ]
        ];
    }

    /**
     * Method checks the availability of the time range by start and end times.
     *
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    private function checkTimeRangeAvailability(string $startTime, string $endTime): bool
    {
        foreach (self::AVAILABLE_TIME_RANGES_IN_UTC as $timeRange) {
            if ($timeRange['start'] === $startTime && $timeRange['end'] === $endTime) {
                return true;
            }
        }

        return false;
    }

    /**
     * Method stores a new consultation model.
     *
     * @param array $data
     * @return Consultation
     * @throws ConsultationException
     */
    private function storeConsultationModel(array $data): Consultation
    {
        try {
            $record = Consultation::create($data);
        } catch (Exception $e) {
            throw ConsultationException::failInsert($e);
        }

        return $record;
    }

    /**
     * Method get all consultation app service data.
     *
     * @param Request $request
     * @return array
     */
    public function getAllConsultations(Request $request): array
    {
        $consultations = $this->consultationRepository->getAllConsultations(['id', 'user_id', 'start_at', 'end_at']);

        return (new ConsultationResourceCollection($consultations))->toArray($request);
    }

    /**
     * Method gets the default timeline table styles.
     *
     * @return string
     */
    public function getDefaultTimeLineStyles(): string
    {
        return 'color: #1E3A8A;background-color: #EFF6FF;border-left: 1px solid #2563EB;border-right: 1px solid #2563EB;';
    }
}
