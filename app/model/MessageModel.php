<?php


	namespace HS\app\model;


	use HS\libs\collection\Collection;
	use HS\libs\core\Model;

	class MessageModel extends Model
	{
		public function Add(int $user_id, int $contact_id, ?string $text, ?string $img): bool {
			try {
				return !is_null($this->Execute('SELECT user_SendMessage(:uid, :cid, :text, :img)', [
					'uid' => $user_id,
					'cid' => $contact_id,
					'text' => $text ?? '',
					'img' => $img
				]));
			} catch (\PDOException $ex) {
				return false;
			}
		}

		public function GetConversations(int $user_id): ?Collection {
			try {
				return $this->SelectAll('CALL user_GetConversations(:user_id, NULL)', [
					'user_id' => $user_id
				]);
			} catch (\PDOException $ex) {
				return null;
			}
		}

		public function GetOneConversation(int $user_id, int $contact_id) {
			try {
				return $this->SelectOnly('CALL user_GetConversations(:user_id, :contact_id)', [
					'user_id' => $user_id,
					'contact_id' => $contact_id
				]);
			} catch (\PDOException $ex) {
				return null;
			}
		}

		public function GetUnreceivedMessages(int $user_id): ?Collection {
			try {
				return $this->SelectAll('CALL user_GetUnreceiveMessages(:user)', [
					'user' => $user_id
				]);
			} catch (\PDOException $ex) {
				return null;
			}
		}

		public function GetMessagesWithContact(int $user_id, int $contact_id): ?Collection {
			try {
				return $this->SelectAll('CALL user_GetConversationWithContact(:user, :contact)', [
					'user' => $user_id,
					'contact' => $contact_id
				]);
			} catch (\PDOException $ex) {
				return null;
			}
		}

		public function SetReadStateInMsg(int $user_id, int $idMsg) : bool {
			try {
				return $this->SelectOnly('select user_SetStateReadInMessages(:UID, :IDMsg)', [
					'UID' => $user_id,
					'IDMsg' => $idMsg
				]);
			} catch (\PDOException $ex) {
				return false;
			}
		}
	}