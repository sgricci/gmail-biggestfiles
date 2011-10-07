#!/usr/local/bin/php
<?php
$address  = "mail@example.com"; // Email
$password = "password"; // Password
$server   = "imap.gmail.com";
$port     = 993;
$ssl      = true;
$results  = 5;

$hostname = sprintf("{%s:%s/imap/ssl/novalidate-cert}[Gmail]/All Mail", $server, $port);

$inbox = imap_open($hostname, $address, $password) OR DIE('Cannot connect to Gmail: '.imap_last_error());

$emails = imap_sort($inbox, SORTSIZE, 1);

if ($emails) {
	foreach($emails as $email_number) {
		$header = imap_header($inbox, $email_number, 0);
		$mail[$email_number] = $header;
		if (count($mail) == $results) break;
	}
}
echo "Largest Emails:\n";
foreach($mail as $email) {
	echo $email->subject.'-'.$email->Size."\n";
}
imap_close($inbox);
?>
