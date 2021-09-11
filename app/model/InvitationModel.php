<?php

    namespace HS\app\model;

    use HS\libs\collection\Collection;
    use HS\libs\core\Model;
    use PDOException;

    class InvitationModel extends Model
    {
        public function HasInvitation(int $user_id, int $contact_id): ?bool
        {
            try {
                return $this->SelectOnly('SELECT user_HasInvitation(:user, :contact)', [
                    'user' => $user_id,
                    'contact' => $contact_id
                ]);
            } catch (PDOException $ex) {
                return false;
            }
        }

        public function ChangeStateOfLastInvitation(int $user_id, int $contact_id, bool $accept): bool
        {
            try {
                return !is_null($this->Execute('CALL user_ChangeInvitationState(:UID, :CID, :state)', [
                    'UID' => $user_id,
                    'CID' => $contact_id,
                    'state' => $accept
                ]));
            } catch (PDOException $ex) {
                return false;
            }
        }

        public function GetUnreceive(int $user_id) : ?Collection{
            try{
                return $this->SelectAll('CALL user_GetUnreceiveInvitations(:user)', [
                    'user' => $user_id
                ]);
            }catch (\PDOException $ex){
                return null;
            }
        }
    }