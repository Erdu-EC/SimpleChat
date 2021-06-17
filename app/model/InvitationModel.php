<?php

    namespace HS\app\model;

    use HS\libs\core\Model;

    class InvitationModel extends Model
    {
        public function HasInvitation(int $user_id, int $contact_id) : ?bool{
            try {
                return $this->SelectOnly('SELECT user_HasInvitation(:user, :contact)', [
                    'user' => $user_id,
                    'contact' => $contact_id
                ]);
            }catch (\PDOException $ex){
                return false;
            }
        }
    }