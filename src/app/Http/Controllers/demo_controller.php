<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;  // ใช้สำหรับเพิ่มข้อมูลใน LDAP
use Illuminate\Http\Request;

class demo_controller extends Controller
{
    function index(Request $request) {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            try {
                // ตรวจสอบว่าผู้ใช้อยู่ใน LDAP แล้วหรือไม่
                $ldapUser = LdapUser::findOrFail($employee->ldap_uid);
                echo "User {$employee->first_name} {$employee->last_name} already exists in LDAP. \n";
            } catch (ModelNotFoundException $e) {
                // หากผู้ใช้ไม่พบใน LDAP จะทำการสร้างใหม่
                $ldapUser = new LdapUser();
                $ldapUser->cn = "{$employee->first_name} {$employee->last_name}";
                $ldapUser->sn = $employee->last_name;
                $ldapUser->givenName = $employee->first_name;
                $ldapUser->mail = $employee->email;
                $ldapUser->uid = $employee->id;
                $ldapUser->userPrincipalName = $employee->email;
                // Save to LDAP
                $ldapUser->save();

                echo "User {$employee->first_name} {$employee->last_name} created in LDAP. \n";
            }
        }

        echo "Done. \n";
    }
}
