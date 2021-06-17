<?php


    namespace HS\app\model;


    use HS\libs\collection\Collection;
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

        public function GetConversations(int $user_id) : ?Collection{
            try {
                return $this->SelectAll('CALL user_GetConversations(:user_id)', [
                    'user_id' => $user_id
                ]);
            }catch (\PDOException $ex){
                return null;
            }
        }
    }