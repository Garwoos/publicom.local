<?php
namespace App\Controllers;

use App\Models\messageModel;
use CodeIgniter\Controller;

class VisualisationController extends Controller
{
    public function visualize()
    {
        $id = $this->request->getGet('id');
        $model = new messageModel();
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

        // Sanitize input data
        $direction = filter_var($direction, FILTER_SANITIZE_STRING);
        $currentEventId = filter_var($currentEventId, FILTER_SANITIZE_NUMBER_INT);

        $eventIds = $this->getEventIds();
        $currentIndex = array_search($currentEventId, array_column($eventIds, 'idMessage'));

        if ($direction === 'prev') {
            $newIndex = max(0, $currentIndex - 1);
        } else {
            $newIndex = min(count($eventIds) - 1, $currentIndex + 1);
        }

        $newEventId = $eventIds[$newIndex]['idMessage'];
        $model = new messageModel();
        $event = $model->where('idMessage', $newEventId)->first();

        $fontFamilies = [
            1 => 'Arial',
            2 => 'Times New Roman',
            3 => 'Verdana',
            4 => 'Georgia',
            5 => 'Courier New',
            6 => 'Comic Sans MS',
        ];
    
        $response = [
            'Title' => $event['Title'],
            'fontTitle' => $fontFamilies[$event['fontTitle']] ?? 'default-font',
            'sizeTitle' => $event['sizeTitle'],
            'Text' => $event['Text'],
            'fontText' => $fontFamilies[$event['fontText']] ?? 'default-font',
            'sizeText' => $event['sizeText'],
            'alignmentText' => $event['alignmentText'],
            'image' => htmlspecialchars($event['image']),
            'idMessage' => $event['idMessage']
        ];
    

        return $this->response->setJSON($response);
    }

}
?>