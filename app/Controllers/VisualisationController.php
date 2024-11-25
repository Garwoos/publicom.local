<?php
namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\Controller;

class VisualisationController extends Controller
{
    public function visualize()
    {
        $id = $this->request->getGet('id');
        $model = new MessageModel();
        $data['message'] = $model->where('idMessage', $id)->first();

        if (empty($data['message'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Message not found');
        }

        return view('visualisationMessage', $data);
    }

    private function getEventIds()
    {
        $model = new MessageModel();
        return $model->select('idMessage')->findAll();
    }

    public function navigateEvent()
    {
        $direction = $this->request->getGet('direction');
        $currentEventId = $this->request->getGet('currentEventId');
        $eventIds = $this->getEventIds();
        $currentIndex = array_search($currentEventId, array_column($eventIds, 'idMessage'));

        if ($direction === 'prev') {
            $newIndex = max(0, $currentIndex - 1);
        } else {
            $newIndex = min(count($eventIds) - 1, $currentIndex + 1);
        }

        $newEventId = $eventIds[$newIndex]['idMessage'];
        $model = new MessageModel();
        $event = $model->where('idMessage', $newEventId)->first();

        return $this->response->setJSON($event);
    }




}
?>