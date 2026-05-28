<?php declare(strict_types=1);
/*
	This file is part of KD2FW -- <http://dev.kd2.org/>

	Copyright (c) 2001-2019 BohwaZ <http://bohwaz.net/>
	All rights reserved.

	KD2FW is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	Foobar is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with Foobar.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace KD2;

use KD2\Mail_Message;

class SMTP_Exception extends \RuntimeException
{
	protected ?string $recipient = null;

	public function getRecipient(): ?string
	{
		return $this->recipient;
	}

	public function setRecipient(?string $recipient): void
	{
		$this->recipient = $recipient;
	}
}

class SMTP
{
	const NONE = null;
	const TLS = 'tls';
	const STARTTLS = 'starttls';
	const SSL = 'ssl';

	const EOL = "\r\n";
	const MAX_REPLY_LENGTH = 512;

	const SUCCESS_CODE = 250;
	const GREYLISTING_CODE = 451;

	protected string $server;
	protected int $port;
	protected ?string $username = null;
	protected ?string $password = null;
	protected ?string $secure = null;
	protected ?string $servername = 'localhost';

	protected $conn = null;
	protected $last_line = null;

	protected $log_pointer = null;

	protected int $timeout = 15;
	protected int $count = 0;
	protected int $max = 50;

	public function setTimeout(int $timeout): void
	{
		$this->timeout = $timeout;
	}

	public function setMax(int $max): void
	{
		$this->max = $max;
	}

	public function count(): int
	{
		return $this->count;
	}

	public function isConnected(): bool
	{
		return $this->conn !== null;
	}

	protected function _read(): string
	{
		$data = '';

		while ($str = fgets($this->conn, self::MAX_REPLY_LENGTH)) {
			$data .= $str;

			if ($str[3] == ' ') {
				break;
			}
		}

		$this->last_line = trim($data);

		if ($this->log_pointer !== null) {
			fwrite($this->log_pointer, '< ' . $this->last_line);
		}

		return $this->last_line;
	}

	protected function _readCode(?string $data = null): int
	{
		if (is_null($data)) {
			$data = $this->_read();
		}

		return (int) substr($data, 0, 3);
	}

	protected function _write(string $data): void
	{
		fputs($this->conn, $data . self::EOL);

		if ($this->log_pointer !== null) {
			fwrite($this->log_pointer, '> ' . $data . self::EOL);
		}
	}

	protected function _writeAndGetCode(string $data): int
	{
		$this->_write($data);
		$return = $this->_read();
		return $this->_readCode($return);
	}

	/**
	 * SMTP class instance constructor
	 * @param string  $server     SMTP Server address
	 * @param integer $port       SMTP server port
	 * @param string  $username   SMTP AUTH username (or null to disable AUTH)
	 * @param string  $password   SMTP AUTH password
	 * @param integer $secure     either SMTP::NONE, SMTP::SSL, SMTP::TLS or SMTP::STARTTLS
	 * @param string  $servername Internal server name used for Message-ID generation and HELO commands (if null will use SERVER_NAME or hostname)
	 */
	public function __construct(
		string $server = 'localhost',
		int $port = 25,
		?string $username = null,
		#[\SensitiveParameter]
		?string $password = null,
		?string $secure = self::NONE,
		?string $servername = null
	)
	{
		$prefix = '';

		if ($secure && $secure !== self::STARTTLS) {
			$prefix = $secure . '://';
		}

		$this->server = $prefix . $server;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->secure = $secure;
		$this->servername = $servername ?: (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : gethostname());
	}

	public function __destruct()
	{
		$this->disconnect();
	}

	public function disconnect(): void
	{
		if (is_null($this->conn)) {
			return;
		}

		$this->_write('QUIT');
		$this->_read();
		fclose($this->conn);
		$this->conn = null;
		$this->last_line = null;
		$this->count = 0;
	}

	public function connect(): void
	{
		/* $this->log = ''; */
		$this->conn = stream_socket_client($this->server . ':' . $this->port, $errno, $errstr, $this->timeout);
		stream_set_timeout($this->conn, $this->timeout);

		if (!$this->conn) {
			throw new SMTP_Exception('Unable to connect to server ' . $this->server . ': ' . $errno . ' - ' . $errstr);
		}

		if ($this->_readCode() != 220) {
			throw new SMTP_Exception($this->last_line);
		}
	}

	public function authenticate(): void
	{
		$code = $this->_writeAndGetCode(sprintf('EHLO %s', $this->servername));

		if ($code !== self::SUCCESS_CODE) {
			if ($this->secure === self::STARTTLS) {
				throw new SMTP_Exception('Can\'t use STARTTLS on this server: server doesn\'t support ESMTP');
			}

			$code = $this->_writeAndGetCode('HELO');

			if ($code !== self::SUCCESS_CODE) {
				throw new SMTP_Exception('SMTP error on HELO: ' . $this->last_line, $code);
			}
		}

		if ($this->secure === self::STARTTLS) {
			$code = $this->_writeAndGetCode('STARTTLS');

			if ($code !== 220) {
				throw new SMTP_Exception('Can\'t start TLS session: ' . $this->last_line, $code);
			}

			stream_socket_enable_crypto($this->conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

			$code = $this->_writeAndGetCode(sprintf('EHLO %s', $this->servername));

			if ($code !== self::SUCCESS_CODE) {
				throw new SMTP_Exception('SMTP error on EHLO: ' . $this->last_line, $code);
			}
		}

		if (!is_null($this->username) && !is_null($this->password)) {
			$code = $this->_writeAndGetCode('AUTH LOGIN');

			if ($code !== 334) {
				throw new SMTP_Exception('SMTP AUTH error: ' . $this->last_line, $code);
			}

			$code = $this->_writeAndGetCode(base64_encode($this->username));

			if ($code !== 334) {
				throw new SMTP_Exception('SMTP AUTH error: ' . $this->last_line, $code);
			}

			$code = $this->_writeAndGetCode(base64_encode($this->password));

			if ($code !== 235) {
				throw new SMTP_Exception('SMTP AUTH error: ' . $this->last_line, $code);
			}
		}
	}

	/**
	 * Send a raw email
	 * @param  string $from From address (MAIL FROM:)
	 * @param  mixed  $to   To address (RCPT TO:), can be a string (single recipient)
	 *                      or an array (multiple recipients)
	 * @param  string $data Mail data (DATA)
	 * @return string Message returned by SMTP
	 */
	public function rawSend(string $from, $to, string $data): string
	{
		// Reconnect if max allowed messages per session is reached
		if ($this->count >= $this->max) {
			$this->disconnect();
		}

		if (is_null($this->conn)) {
			$this->connect();
			$this->authenticate();
		}

		$code = $this->_writeAndGetCode('RSET');

		if ($code !== self::SUCCESS_CODE && $code !== 200) {
			throw new SMTP_Exception('SMTP RSET error: ' . $this->last_line, $code);
		}

		$code = $this->_writeAndGetCode('MAIL FROM: <'.$from.'>');

		if ($code !== self::SUCCESS_CODE) {
			throw new SMTP_Exception('SMTP MAIL FROM error: ' . $this->last_line, $code);
		}

		if (is_string($to)) {
			$to = array($to);
		}

		if (!count($to)) {
			throw new SMTP_Exception('There are no recipients to the message');
		}

		foreach ($to as $dest) {
			$code = $this->_writeAndGetCode('RCPT TO: <'.$dest.'>');

			if ($code !== self::SUCCESS_CODE && $code !== 251) {
				$e = new SMTP_Exception($this->last_line, $code);
				$e->setRecipient($dest);
				throw $e;
			}
		}

		$data = rtrim($data) . self::EOL;

		// if first character of a line is a period, then append another period
		// to avoid confusion with "end of data marker"
		// see https://tools.ietf.org/html/rfc5321#section-4.5.2
		$data = preg_replace('/^\./m', '..', $data);

		$code = $this->_writeAndGetCode('DATA');

		if ($code !== 354) {
			throw new SMTP_Exception('SMTP DATA error: '  . $this->last_line, $code);
		}

		$code = $this->_writeAndGetCode($data . '.');
		$message = $this->last_line;

		if ($code !== 250) {
			throw new SMTP_Exception($message, $code);
		}

		$this->count++;

		return $message;
	}

	/**
	 * Send an email to $to, using $subject as a subject and $message as content
	 * @param  mixed  $to      List of recipients, as an array or string of email addresses
	 * @param  string $subject Message subject
	 * @param  string $message Message content
	 * @param  mixed  $headers Additional headers, either as an array of key=>value pairs or a string
	 */
	public function buildMessage($to, string $subject, string $message, $headers = []): array
	{
		// Parse $headers if it's a string
		if (is_string($headers)) {
			preg_match_all('/^(\\S.*?):(.*?)\\s*(?=^\\S|\\Z)/sm', $headers, $match, PREG_SET_ORDER);
			$headers = [];

			foreach ($match as $header) {
				$headers[$header[1]] = $header[2];
			}
		}

		// Normalize headers
		$headers_normalized = [];

		foreach ($headers as $key => $value) {
			$key = preg_replace_callback('/^.|(?<=-)./', function ($m) { return ucfirst($m[0]); }, strtolower(trim($key)));
			$headers_normalized[$key] = $value;
		}

		$headers = $headers_normalized;
		unset($headers_normalized);

		// Set default headers if they are missing
		if (!isset($headers['Date']))
		{
			$headers['Date'] = date(DATE_RFC2822);
		}

		$headers['Subject'] = (trim($subject) == '') ? '' : '=?UTF-8?B?'.base64_encode($subject).'?=';

		if (!isset($headers['Mime-Version'])) {
			$headers['Mime-Version'] = '1.0';
		}

		if (!isset($headers['Content-Type'])) {
			$headers['Content-Type'] = 'text/plain; charset=UTF-8';
		}

		if (!isset($headers['From'])) {
			$headers['From'] = 'mail@' . $this->servername;
		}

		if (!isset($headers['Message-Id'])) {
			// With headers + uniqid, it is presumed to be sufficiently unique
			// so that two messages won't have the same ID
			$headers['Message-Id'] = sprintf('<%s.%s@%s>', uniqid(), substr(sha1(var_export($headers, true)), 0, 10), $this->servername);
		}

		// Extract and filter recipients addresses
		$to = self::extractEmailAddresses($to);
		$headers['To'] = '<' . implode('>, <', $to) . '>';

		if (isset($headers['Cc'])) {
			$headers['Cc'] = self::extractEmailAddresses($headers['Cc']);
			$to = array_merge($to, $headers['Cc']);

			$headers['Cc'] = implode(', ', $headers['Cc']);
		}

		if (isset($headers['Bcc'])) {
			$headers['Bcc'] = self::extractEmailAddresses($headers['Bcc']);
			$to = array_merge($to, $headers['Bcc']);

			$headers['Bcc'] = implode(', ', $headers['Bcc']);
		}

		$content = '';

		foreach ($headers as $name => $value) {
			$content .= $name . ': ' . $value . self::EOL;
		}

		$content = trim($content) . self::EOL . self::EOL . $message . self::EOL;
		$content = preg_replace("#(?<!\r)\n#si", self::EOL, $content);
		$content = wordwrap($content, 998, self::EOL, true);

		return [
			'message' => $content,
			'headers' => $headers,
			'to'      => $to,
			'from'    => current(self::extractEmailAddresses($headers['From'])),
		];
	}

	/**
	 * Send an email to $to, using $subject as a subject and $message as content
	 * @param  array|string|Mail_Message  $r      List of recipients, as an array or a string, OR a Mail_Message object
	 * @param  string $subject Message subject
	 * @param  string $message Message content
	 * @param  mixed  $headers Additional headers, either as an array of key=>value pairs or a string
	 * @return string Message returned by SMTP server for queueing message
	 */
	public function send($r, ?string $subject = null, ?string $message = null, $headers = []): string
	{
		if (is_object($r) && $r instanceof Mail_Message) {
			$message = $r->output(true);
			$to = $r->getRecipientsAddresses();
			$from = $r->getSenderAddress();
		}
		else {
			$msg = $this->buildMessage($r, $subject, $message, $headers);
			extract($msg);
		}

		// Send email
		return $this->rawSend($from, $to, $message);
	}

	/**
	 * Takes a string like a From, Cc, To or Bcc header and gets out all the email
	 * addresses it can find out of it.
	 * This is not perfect as it won't handle addresses like "uncommon,email"@email.tld
	 * because of the comma, but FILTER_VALIDATE_EMAIL doesn't accept it as an email address either
	 * (though it's perfectly valid if you follow the RFC).
	 */
	public static function extractEmailAddresses(string $str): array
	{
		if (is_array($str)) {
			$out = [];

			// Filter invalid email addresses
			foreach ($str as $email) {
				if ($list = self::extractEmailAddresses($email)) {
					$out = array_merge($out, $list);
				}
			}

			return $out;
		}

		$str = explode(',', $str);
		$out = [];

		foreach ($str as $s)
		{
			$s = trim($s);
			if (preg_match('/(?:([\'"])(?!\\").*?\1\s*)?<([^>]*)>/', $s, $match) && self::checkEmailIsValid(trim($match[2]), false)) {
				$out[] = trim($match[2]);
			}
			elseif (self::checkEmailIsValid($s, false)) {
				$out[] = $s;
			}
			else {
				// unrecognized, skip
			}
		}

		return $out;
	}

	public static function checkEmailIsValid(string $email, bool $validate_mx = true): bool
	{
		$host = substr($email, strpos($email, '@') + 1);

		// Compatibility with IDN domains
		if (function_exists('idn_to_ascii')) {
			$host = idn_to_ascii($host);
			$email = substr($email, 0, strpos($email, '@')+1) . $host;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}

		if (!$validate_mx) {
			return true;
		}

		return checkdnsrr($host, 'MX');
	}

	public function setLogPointer($pointer)
	{
		$this->log_pointer = $pointer;
	}
}