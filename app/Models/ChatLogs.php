<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatLogs extends Model
{
    // ALTER TABLE chat_logs ADD UNIQUE (id); ALTER TABLE chat_messages ADD UNIQUE (time);

    protected $DBGroup          = 'default';
    protected $table            = 'chat_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'id',
                                    'user_id', 
                                    'type', 
                                    'page_id', 
                                    'visitor_name', 
                                    'visitor_id', 
                                    'visitor_email', 
                                    'location_countryCode', 
                                    'location_city', 
                                    'message_count', 
                                    'chat_duration', 
                                    'rating', 
                                    'created_on', 
                                    'domain'
                                ];
  
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
