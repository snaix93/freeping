<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Support;

use Illuminate\Support\Str;
use Stringable;

class PortService implements Stringable
{
    private $serviceLookup = [
        7    => 'echo',
        20   => 'ftp',
        21   => 'ftp',
        22   => 'ssh',
        23   => 'telnet',
        25   => 'smtp',
        37   => 'time',
        43   => 'whois',
        53   => 'dns',
        67   => 'dhcp',
        68   => 'dhcp',
        69   => 'tftp',
        80   => 'http',
        102  => 'ms exchange',
        110  => 'pop3',
        115  => 'sftp',
        123  => 'ntp',
        143  => 'imap',
        161  => 'snmp',
        194  => 'irc',
        199  => 'smux',
        201  => 'appletalk',
        220  => 'imap',
        389  => 'ldap',
        401  => 'ups',
        443  => 'https',
        465  => 'smtps',
        587  => 'smtp',
        636  => 'ldaps',
        989  => 'ftps',
        990  => 'ftps',
        993  => 'imaps',
        995  => 'pop3s',
        1080 => 'socks',
        1701 => 'L2TP',
        1812 => 'radius',
        1813 => 'radius',
        3306 => 'mysql',
        3389 => 'rdp',
        8080 => 'http',
        8443 => 'plesk',
    ];

    public function __construct(public int $port) { }

    public static function forPort(int $port)
    {
        return new self($port);
    }

    public function name(): ?string
    {
        $name = Str::upper($this->serviceLookup[$this->port] ?? '');

        return $this->port . ($name ? "/{$name}" : '');
    }

    public function __toString()
    {
        return $this->name();
    }
}
