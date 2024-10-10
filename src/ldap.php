<?php

// LDAP variables
$ldap_host = "ldap://172.30.0.3:389";  // your ldap-uri

// Set your LDAP credentials
$ldap_user = "cn=admin,dc=example,dc=com"; // Your admin user
$ldap_password = "adminpassword";

// Connect to the LDAP server
$ldap_conn = ldap_connect($ldap_host);

if ($ldap_conn === false) {
    throw new RuntimeException("Could not connect to LDAP server.");
}

// Set LDAP options
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3); // Use LDAPv3

// Bind to the LDAP server (authentication)
$ldap_bind = ldap_bind($ldap_conn, $ldap_user, $ldap_password);

if ($ldap_bind === false) {
    throw new RuntimeException("LDAP bind failed.");
}

// Define the base DN (Distinguished Name) for the search
$base_dn = "cn=IT,dc=example,dc=com";

// Define cn  group
$filter = "(cn=*)";

// Perform the search
$search = ldap_search($ldap_conn, $base_dn, $filter);

if ($search === false) {
    throw new RuntimeException("LDAP search failed.");
}

// Get search results
$entries = ldap_get_entries($ldap_conn, $search);

// echo '<pre>';
// print_r($entries);
// echo '</pre>';
if ($entries["count"] > 0) {
    // Loop through the entries and display the results
    for ($i = 0; $i < $entries["count"]; $i++) {
        echo "DN: " . $entries[$i]["dn"] . "<br>";
        echo "CN: " . $entries[$i]["cn"][0] . "<br>";
        echo "--------------------------<br>";
        echo "<br>";
    }
} else {
    echo "No entries found.\n";
}




// $user_info = [
//     "cn" => "johndoe", // Common Name
//     "sn" => "Doe",      // Surname
//     "mail" => "johndoe@example.com", // Email
//     "objectClass" => ["top", "person", "organizationalPerson", "inetOrgPerson"], // Object classes
//     "uid" => "johndoe", // User ID
//     "userPassword" => "{SHA}" . base64_encode(pack('H*', sha1("password123"))), // Password (hashed using SHA)
// ];

// $new_user_dn = "cn=johndoe,cn=IT,dc=example,dc=com";

// // Add the new user to the LDAP server
// ldap_add($ldap_conn, $new_user_dn, $user_info);

// Close the LDAP connection
ldap_unbind($ldap_conn);

