<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\ChatLogs;
use App\Models\ChatMessages;
  
class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        $id = $session->get('id');
        $userId = intval($id);

        $logs_id = new ChatLogs();

        $logs = $logs_id->where('user_id', $userId)->get();

        return view('index', ['logs' => $logs]);
    }
    public function chats($userId) {

        $chat_messages = new ChatMessages();
        
        $chat_messages = $chat_messages->where('chat_id', $userId)->get();
        
        return view('chats', ['messages' => $chat_messages]);
    }
    // public function index()
    // {
    //     $session = session();
    //     $userId = $session->get('id');

    //     $logs = $this->db->table('chat_logs')
    //                           ->where('user_id', $userId)
    //                           ->get()
    //                           ->getResult();

    //     return view('index', ['logs' => $logs]);
    // }

    // public function chats($chatId)
    // {
    //     $chat_messages = $this->db->table('chat_messages')
    //                                ->where('chat_id', $chatId)
    //                                ->get()
    //                                ->getResult();

    //     return view('chats', ['chat_messages' => $chat_messages]);
    // }
    
}