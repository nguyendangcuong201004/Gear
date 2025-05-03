<?php
class ContactAdminModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllContactMessages() {
        $query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
        $result = mysqli_query($this->db->con, $query);
        $contacts = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $contacts[] = $row;
            }
        }
        
        return $contacts;
    }

    public function getContactMessageById($id) {
        $id = mysqli_real_escape_string($this->db->con, $id);
        
        $query = "SELECT * FROM contact_messages WHERE id = '$id'";
        $result = mysqli_query($this->db->con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        
        return null;
    }

    public function updateContactStatus($id, $status) {
        try {
            $id = mysqli_real_escape_string($this->db->con, $id);
            $status = mysqli_real_escape_string($this->db->con, $status);
            
            $updateQuery = "UPDATE contact_messages SET status = '$status'";
            
            // If status is 'replied', update replied_at timestamp
            if ($status === 'replied') {
                $updateQuery .= ", replied_at = CURRENT_TIMESTAMP";
            }
            
            $updateQuery .= " WHERE id = '$id'";
            
            $result = mysqli_query($this->db->con, $updateQuery);
            
            if (!$result) {
                error_log("Database error in updateContactStatus: " . mysqli_error($this->db->con));
                return false;
            }
            
            return mysqli_affected_rows($this->db->con) > 0;
        } catch (Exception $e) {
            error_log("Error in updateContactStatus: " . $e->getMessage());
            return false;
        }
    }

    public function saveReply($contactId, $replyMessage) {
        $contactId = mysqli_real_escape_string($this->db->con, $contactId);
        $replyMessage = mysqli_real_escape_string($this->db->con, $replyMessage);
        
        // Update the contact message with reply and set status to replied
        $query = "UPDATE contact_messages SET 
                  admin_reply = '$replyMessage', 
                  status = 'replied', 
                  replied_at = CURRENT_TIMESTAMP 
                  WHERE id = '$contactId'";
        
        $result = mysqli_query($this->db->con, $query);
        return $result;
    }

    public function deleteContactMessage($id) {
        $id = mysqli_real_escape_string($this->db->con, $id);
        
        $query = "DELETE FROM contact_messages WHERE id = '$id'";
        $result = mysqli_query($this->db->con, $query);
        
        return $result;
    }

    public function getContactStats() {
        $stats = [
            'total' => 0,
            'unread' => 0,
            'read' => 0,
            'replied' => 0
        ];
        
        // Total count
        $totalQuery = "SELECT COUNT(*) as count FROM contact_messages";
        $result = mysqli_query($this->db->con, $totalQuery);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $stats['total'] = $row['count'];
        }
        
        // Count by status
        $statusQuery = "SELECT status, COUNT(*) as count FROM contact_messages GROUP BY status";
        $result = mysqli_query($this->db->con, $statusQuery);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stats[$row['status']] = $row['count'];
            }
        }
        
        return $stats;
    }
} 