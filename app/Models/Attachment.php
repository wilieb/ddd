<?php

namespace App\Models;

use CodeIgniter\Model;

class Attachment extends Model
{
    public $user_id;
    public $name;
    public $link;
    public $created_at;

    protected $DBGroup          = 'default';
    protected $table            = 'attachments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowedFields = ['name', 'link', 'user_id'];
    

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}

public function index()
    {
        $session = session();
        $id = $session->get('id');
        $userId = intval($id);

        $logs_id = new ChatLogs();
        // $chat_msg = new ChatMessages();

        // $chat_ids = $logs_id->where('user_id', $userId)->findColumn('id');
        $logs = $logs_id->where('user_id', $userId)->get();
        // $chat_messages = $chat_msg->whereIn('chat_id', $chat_ids)->get();
        // 'chats' => $chat_messages, 
        return view('index', ['logs' => $logs]);
    }

    public function getChatMessages($id)
    {
        $chat_msg = new ChatMessages();
        $chat_messages = $chat_msg->where('chat_id', $id)->findAll();

        $output = '';
        foreach ($chat_messages as $message) {
            $output .= '<div class="chat-message">';
            $output .= '<p>' . $message['message'] . '</p>';
            $output .= '<span class="chat-time">' . $message['created_at'] . '</span>';
            $output .= '<span class="chat-sender">' . $message['sender_t'] == 'v' . '</span>';
            $output .= '<span class="chat-reciver">' . $message['sender_t'] == 'a' || $message['sender_t'] == 's' . '</span>';
            $output .= '</div>';
        }

        return $this->response->setContentType('text/html')->setBody($output);
    }