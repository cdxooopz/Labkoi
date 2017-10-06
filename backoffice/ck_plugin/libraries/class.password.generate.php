<?php
class PasswordGenerate
{
	public $user;
	public $pass;
	public $hash;
	
	public function pwHash()
	{
		return password_hash($this->pass.$this->user,PASSWORD_DEFAULT);
	}
	public function pwHashSalt()
	{
		$this->prepareSalt();
		$options = [
		    'cost' => 10,
		    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		return password_hash($this->pass.$this->user,PASSWORD_BCRYPT,$options);
	}
	private function prepareSalt()
	{
		$this->salt = base64_encode($this->salt);
		$this->salt = str_replace('+', '.', $this->salt);
	}
	public function verify()
	{
		return password_verify($this->pass.$this->user, $this->hash);
	}
}