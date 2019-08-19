<?php
// Construct new Adldap instance.
require __DIR__ . '/vendor/autoload.php';
$ad = new Adldap\Adldap();
// Create a configuration array.
$config = [
    // An array of your LDAP hosts. You can use either
    // the host name or the IP address of your host.
    // 'hosts'    => ['172.31.15.251'],
    'hosts'    => ['172.31.12.188'],

    // The base distinguished name of your domain to perform searches upon.
    // 'base_dn'  => 'dc=openemr,dc=test,dc=com',
    'base_dn'  => 'dc=openemrstoked,dc=com',

    // The account to use for querying / modifying LDAP records. This
    // does not need to be an admin account. This can also
    // be a full distinguished name of the user account.
    // 'username' => 'admin@openemr.test.com',
    'username' => 'admin@openemrstoked.com',
    'password' => 'Upwork*123',
];
try {
    // Add a connection provider to Adldap.
    $ad->addProvider($config);
    // If a successful connection is made to your server, the provider will be returned.
    $provider = $ad->connect();

    // Performing a query.
    // $results = $provider->search()->where('cn', '=', 'Kap Dev')->get();
    $groups = $provider->search()->groups()->where('cn', '=', 'Medical Director')->get();
    foreach ($groups as $group) {
        foreach ($group->getMembers() as $member) {
            echo $member->getCommonName();
            echo $member->getEmail();
        }
    }
} catch (Exception $e) {
    echo $e;
    // There was an issue binding / connecting to the server.
}
