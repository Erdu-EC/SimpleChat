<?php


    namespace HS\app\model;


    use HS\libs\core\Model;

    class MessageModel extends Model
    {
        public function Add(int $user_id, int $contact_id, string $text): bool
        {
            try {
                return !is_null($this->Execute('SELECT user_SendMessage(:uid, :cid, :text)', [
                    'uid' => $user_id,
                    'cid' => $contact_id,
                    'text' => $text
                ]));
            } catch (\PDOException $ex) {
                return false;
            }
        }
    }