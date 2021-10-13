<?php


	namespace HS\app\model;


	use HS\libs\collection\Collection;
	use HS\libs\core\Logger;
	use HS\libs\core\Model;
	use PDOException;

	class MessageModel extends Model
	{
		public function Add(int $user_id, int $contact_id, string $idFake, ?string $text, ?string $img): bool {
			try {
				return !is_null($this->Execute('SELECT msg_Send(:idf, :uid, :cid, :text, :img)', [
					'idf' => $idFake,
					'uid' => $user_id,
					'cid' => $contact_id,
					'text' => $text ?? '',
					'img' => $img
				]));
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_send', $ex->getMessage());
				return false;
			}
		}

		public function GetConversations(int $user_id): ?Collection {
			try {
				return $this->SelectAll('CALL user_GetConversations(:user_id, NULL)', [
					'user_id' => $user_id
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_conversations', $ex->getMessage());
				return null;
			}
		}

		public function GetOneConversation(int $user_id, int $contact_id) {
			try {
				return $this->SelectOnly('CALL user_GetConversations(:user_id, :contact_id)', [
					'user_id' => $user_id,
					'contact_id' => $contact_id
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_oneconversations', $ex->getMessage());
				return null;
			}
		}

		public function GetUnreceivedMessages(int $user_id): ?Collection {
			try {
				return $this->SelectAll('CALL user_GetUnreceiveMessages(:user)', [
					'user' => $user_id
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_unreceives', $ex->getMessage());
				return null;
			}
		}

		public function GetUnreceivedStatesChanged(int $user_id): ?Collection {
			try {
				return $this->SelectAll('CALL msg_GetUnreceiveStatusChanges(:user)', [
					'user' => $user_id
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_statuschanges', $ex->getMessage());
				return null;
			}
		}

		public function GetMessagesWithContact(int $user_id, int $contact_id): ?Collection {
			try {
				return $this->SelectAll('CALL msg_GetConversationWithContact(:user, :contact)', [
					'user' => $user_id,
					'contact' => $contact_id
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_getallwithcontact', $ex->getMessage());
				return null;
			}
		}

		public function SetReadStateInMsg(int $user_id, int $idMsg): bool {
			try {
				return $this->SelectOnly('select msg_SetStateRead(:UID, :IDMsg)', [
					'UID' => $user_id,
					'IDMsg' => $idMsg
				]);
			} catch (PDOException $ex) {
				Logger::Log('sql', 'msg_setstatus', $ex->getMessage());
				return false;
			}
		}
	}