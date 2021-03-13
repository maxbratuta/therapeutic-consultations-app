<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ConsultationController
 * @package App\Http\Controllers
 */
class ConsultationController extends Controller
{
    /** @var string */
    private const ELEMENT_DISPLAY_TYPE_BACKGROUND = 'background';

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = $this->getData();

        return view('index', compact('data'));
    }

    /**
     * Method returns a consultation data.
     *
     * @return array[]
     */
    private function getData(): array
    {
        $data = [];

        $consultations = $this->getAllConsultations(['id', 'user_id', 'start_at', 'end_at']);

        foreach ($consultations as $key => $consultation) {
            $data[$key]['id'] = $consultation->id;
            $data[$key]['content'] = $consultation->user->name;
            $data[$key]['start'] = $consultation->start_at;
            $data[$key]['end'] = $consultation->end_at;
            $data[$key]['type'] = self::ELEMENT_DISPLAY_TYPE_BACKGROUND;
            $data[$key]['style'] = '
                color: #1E3A8A;
                background-color: #EFF6FF;
                border-left: 1px solid #2563EB;
                border-right: 1px solid #2563EB;
            ';
        }

        return $data;
    }

    /**
     * Method gets all consultations.
     *
     * @param array|string[] $columns
     * @return Collection
     */
    private function getAllConsultations(array $columns = ['*']): Collection
    {
        return Consultation::with('user')->get($columns);
    }
}
