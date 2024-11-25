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

    public function navigate()
    {
        $id = $this->request->getGet('id');
        $direction = $this->request->getGet('direction');
        $model = new MessageModel();

        if ($id && $direction) {
            if ($direction === 'next') {
                $message = $model->where('idMessage >', $id)->orderBy('idMessage', 'ASC')->first();
            } else {
                $message = $model->where('idMessage <', $id)->orderBy('idMessage', 'DESC')->first();
            }

            if ($message) {
                return $this->response->setJSON(['success' => true, 'message' => $message]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'No more messages in this direction.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid parameters']);
        }
    }
}
?>