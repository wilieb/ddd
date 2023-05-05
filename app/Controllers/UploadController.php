<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Attachment;
use App\Models\ChatLogs;
use App\Models\ChatMessages;

class UploadController extends Controller
{
    public function index()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid() && ! $file->hasMoved())
        {
            $session = session();
            $id = $session->get('id');
            $userId = intval($id);

            $username = strtolower(str_replace(' ', '', $session->get('name')));
            $originalName =  $file->getName();
            $timestamp = time();
            $newName = "{$username}-{$timestamp}-{$originalName}";
            
            $file->move(ROOTPATH . 'public/uploads', $newName);

            $file_type = $file->getClientMimeType();
            if ($file_type === 'application/json') {

                $json_data = file_get_contents(ROOTPATH . 'public/uploads/' . $newName);
                $jsn_data = json_decode($json_data, true);

                $chatlog = new ChatLogs();

                $chat_data = [
                    'id' => $jsn_data['id'],
                    'user_id' => $userId,
                    'type' => $jsn_data['type'],
                    'page_id' => $jsn_data['pageId'],
                    'visitor_name' => $jsn_data['visitor']['name'], 
                    'visitor_id' => $jsn_data['visitor']['id'], 
                    'visitor_email' => $jsn_data['visitor']['email'],
                    'location_countryCode' => $jsn_data['location']['countryCode'], 
                    'location_city' => $jsn_data['location']['city'],
                    'message_count' => $jsn_data['messageCount'],
                    'chat_duration' => $jsn_data['chatDuration'],
                    'rating' => $jsn_data['rating'],
                    'created_on' => date('Y-m-d H:i:s', strtotime($jsn_data['createdOn'])),
                    'domain' => $jsn_data['domain']
                ];
                
                $chatlog->replace($chat_data);
                foreach ($jsn_data['messages'] as $message) {
    
                    $chatmesagge = new ChatMessages();
    
                    $message_data = array(
                        'chat_id' => $jsn_data['id'],
                        'sender_t' => $message['sender']['t'],
                        'sender_n' => $message['sender']['n'] ?? null,
                        'type' => $message['type'],
                        'time' => date('Y-m-d H:i:s', strtotime($message['time'])),
                        'message' => $message['msg']
                    );
                    
                    $chatmesagge->replace($message_data);
    
                }

                unlink(ROOTPATH . 'public/uploads/' . $newName);

            } elseif ($file_type === 'application/zip' || $file_type === 'application/x-zip-compressed') {

                try {
                    $zip = new \ZipArchive;
                    $zipPath = ROOTPATH . 'public/uploads/' . $newName;
                    $extractPath = ROOTPATH . 'public/uploads/extracted/' . $newName;
                
                    if ($zip->open($zipPath) == true) {
                        $zip->extractTo($extractPath);
                        $zip->close();
                
                        $jsonFiles = [];
                        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extractPath));
                        foreach ($iterator as $file) {
                            $filename = basename($file->getPathname());
                            if ($file->isFile() && $file->getExtension() === 'json' && strpos($filename, '.') !== 0 && $file->isReadable()) {
                                $jsonFiles[] = $file->getPathname();
                            }
                        }
                        if (count($jsonFiles) > 0) {
                            foreach ($jsonFiles as $jfile) {

                                $json_data = file_get_contents($jfile);
                                $jsn_data = json_decode($json_data, true);

                                $chatlog = new ChatLogs();

                                $chat_data = [
                                    'id' => $jsn_data['id'],
                                    'user_id' => $userId,
                                    'type' => $jsn_data['type'],
                                    'page_id' => $jsn_data['pageId'],
                                    'visitor_name' => $jsn_data['visitor']['name'], 
                                    'visitor_id' => $jsn_data['visitor']['id'], 
                                    'visitor_email' => $jsn_data['visitor']['email'],
                                    'location_countryCode' => $jsn_data['location']['countryCode'], 
                                    'location_city' => $jsn_data['location']['city'],
                                    'message_count' => $jsn_data['messageCount'],
                                    'chat_duration' => $jsn_data['chatDuration'],
                                    'rating' => $jsn_data['rating'],
                                    'created_on' => date('Y-m-d H:i:s', strtotime($jsn_data['createdOn'])),
                                    'domain' => $jsn_data['domain']
                                ];

                                
                                $chatlog->replace($chat_data);
                    
                                foreach ($jsn_data['messages'] as $message) {
                    
                                    $chatmesagge = new ChatMessages();
                                    $message_data = null;
                                    if (isset($message['msg'])) {
                                        $message_data = array(
                                            'chat_id' => $jsn_data['id'],
                                            'sender_t' => $message['sender']['t'],
                                            'sender_n' => $message['sender']['n'] ?? null,
                                            'type' => $message['type'],
                                            'time' => date('Y-m-d H:i:s', strtotime($message['time'])),
                                            'message' => $message['msg']
                                        );
                                    } else {
                                        continue;
                                    }
                                    
                                    $chatmesagge->replace($message_data);
                    
                                }
                            }

                            echo "Files found: " . count($jsonFiles);
                        } else {
                            $data = [
                                'title' => 'File upload failed',
                                'message' => 'The uploaded ZIP file does not contain any valid JSON file.',
                            ];
                            echo view('upload_error', $data);
                            return $data;
                        }
                    } else {
                        $data = [
                            'title' => 'File upload failed',
                            'message' => 'The uploaded file is not a valid ZIP file.',
                        ];
                        echo view('upload_error', $data);
                        return $data;
                    }
                    unlink(ROOTPATH . 'public/uploads/' . $newName);
                    function deleteDirectory($dir) {
                        if (!is_dir($dir)) {
                            return;
                        }
                
                        $files = array_diff(scandir($dir), array('.','..'));
                        foreach ($files as $file) {
                            $path = $dir . '/' . $file;
                            if (is_dir($path)) {
                                deleteDirectory($path);
                            } else {
                                unlink($path);
                            }
                        }
                        rmdir($dir);
                    }
                    deleteDirectory($extractPath);
                    
                } catch (\Exception $ex) {
                    echo $ex;
                }
                
            }
        }
        else
        {
            echo 'Unable to upload the file.';
        }
    }
} 