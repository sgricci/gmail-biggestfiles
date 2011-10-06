#!/usr/local/bin/php
<?php
$address  = "email@example.com"; // Email
$password = "password"; // Password
$server   = "imap.gmail.com";
$port     = 993;
$ssl      = true;

$hostname = sprintf("{%s:%s/imap/ssl/novalidate-cert}[Gmail]/All Mail", $server, $port);

$inbox = imap_open($hostname, $address, $password) OR DIE('Cannot connect to Gmail: '.imap_last_error());

$emails = imap_search($inbox, 'ALL');

if ($emails) {
	rsort($emails);
	foreach($emails as $email_number) {
		$overview = imap_fetch_overview($inbox, $email_number, 0);
		$mail[$email_number] = $overview;
		$sizes[str_pad($overview[0]->size, 10, "0", STR_PAD_LEFT)."_".$email_number] = $email_number;
		echo '#';
	}
}
echo '\n';
krsort($sizes);
$i = 0;
foreach($sizes as $val)
{
	echo $mail[$val][0]->subject.'-'.$mail[$val][0]->size;
	$i++;
	if ($i == 2)
	   break;	
}
imap_close($inbox);
?>
