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

    public function getAllProjectIds()
    {
        $model = new MessageModel();
        $model->select();
        return $model->select('idMessage')->orderBy('idMessage', 'ASC')->findAll();
    }

    public function navigate()
    {
        $id = $this->request->getGet('id');
        $direction = $this->request->getGet('direction');
        $model = new MessageModel();

        $projectIds = array_column($model->getAllProjectIds(), 'idMessage');

        if ($id && $direction) {
            $currentIndex = array_search($id, $projectIds);
            if ($currentIndex !== false) {
                if ($direction === 'next' && isset($projectIds[$currentIndex + 1])) {
                    $nextId = $projectIds[$currentIndex + 1];
                } elseif ($direction === 'prev' && isset($projectIds[$currentIndex - 1])) {
                    $nextId = $projectIds[$currentIndex - 1];
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'No more messages in this direction.']);
                }

                $message = $model->find($nextId);
                return $this->response->setJSON(['success' => true, 'message' => $message]);
            } else {
                return $this->response->setJSON(['success' => false, 'error' => 'Invalid ID']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid parameters']);
        }
    }
}
?>