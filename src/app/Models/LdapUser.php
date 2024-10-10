<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LdapUser extends Model
{
    use HasFactory;

    protected $dn = 'cn=admin,dc=example,dc=com'; // Optional: Specify your distinguished name (DN)

}
