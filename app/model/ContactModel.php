<?php

	namespace HS\app\model;

	use HS\libs\collection\Collection;
	use HS\libs\core\Logger;
	use HS\libs\core\Model;
	use HS\libs\core\Session;
	use HS\libs\core\TModel;

	class ContactModel extends Model
	{
		use TModel;

		const C_UID = 'user_id';
		const C_CID = 'contact_id';
		const C_IID = 'invitation_id';

		public static function _st_init() {
			self::$ALLOW_READ_VALUES = [self::C_UID, self::C_CID, self::C_IID];
		}

		public function GetAll($user_contact_fields = null): ?Collection {
			try {
				$allow_values = array_merge(UserModel::$ALLOW_READ_VALUES, ContactModel::$ALLOW_READ_VALUES);
				$user_contact_fields = self::FilterAllowedFields($user_contact_fields, '*', $allow_values);
				return self::SelectAll("select $user_contact_fields from contacts c inner join users u on c.contact_id = u.id where c.user_id = :user", [
					'user' => (new Session())->user_id
				]);
			} catch (\PDOException $ex) {
				return null;
			}
		}

		public function AddContact(int $user_id, int $contact_id): bool {
			try {
				return !is_null($this->Execute('SELECT user_AddContact(:user, :contact)', [
					'user' => $user_id,
					'contact' => $contact_id
				]));
			} catch (\PDOException $x) {
				return false;
			}
		}

		public function IsContactOfUser(int $user_id, int $contact): ?bool {
			try {
				return self::SelectOnly('select user_is_contact(:user, :contact)', [
					'user' => $user_id,
					'contact' => $contact
				]);
			} catch (\PDOException $x) {
				return null;
			}
		}

		public function GetActiveContacts(int $user_id): ?Collection {
			try{
				return $this->SelectAll('CALL user_getActiveContacts(:user)', [
					'user' => $user_id
				]);
			}catch (\PDOException $ex){
				Logger::Log('sql', 'user_getActiveContacts', $ex->getMessage());
				return null;
			}
		}
	}