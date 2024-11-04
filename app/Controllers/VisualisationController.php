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
}
?>