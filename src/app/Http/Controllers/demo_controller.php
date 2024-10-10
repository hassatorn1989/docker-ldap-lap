<?php

namespace App\Http\Controllers;

use App\Ldap\User as LdapUser;
use App\Models\Employee;
use LdapRecord\Connection;
use LdapRecord\Container;

class demo_controller extends Controller
{
    function index()
    {
        $connection = new Connection([
            'hosts' => [env('LDAP_HOST', '127.0.0.1')],
            'username' => env('LDAP_USERNAME', 'cn=IT,dc=local,dc=com'),
            'password' => env('LDAP_PASSWORD', 'secret'),
            'port' => env('LDAP_PORT', 389),
            'base_dn' => "cn=IT,dc=example,dc=com",
            'timeout' => env('LDAP_TIMEOUT', 5),
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),
            'use_sasl' => env('LDAP_SASL', false),
        ]);

        Container::addConnection($connection);
        $employee = Employee::all();
        if ($employee) {
            foreach ($employee as $item) {
                $user = new LdapUser();
                $user->cn = $item->code;
                $user->sn = $item->first_name . " " . $item->last_name;
                $user->mail = $item->email;
                $user->objectClass = ["top", "person", "organizationalPerson", "inetOrgPerson"];
                $user->uid = $item->code;
                $user->userPassword = "{MD5}" . base64_encode(pack('H*', md5("password123")));
                $user->save();
            }
            echo "Done";
        }else{
            echo "No data";
        }
    }
}
