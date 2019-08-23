<?php
// Construct new Adldap instance.
require __DIR__ . '/vendor/autoload.php';
$ad = new Adldap\Adldap();
// Create a configuration array.
$config = [
    // An array of your LDAP hosts. You can use either
    // the host name or the IP address of your host.
    'hosts'    => ['172.31.15.251'],
    // 'hosts'    => ['172.31.12.188'],

    // The base distinguished name of your domain to perform searches upon.
    'base_dn'  => 'dc=openemr,dc=test,dc=com',
    // 'base_dn'  => 'dc=openemrstoked,dc=com',

    // The account to use for querying / modifying LDAP records. This
    // does not need to be an admin account. This can also
    // be a full distinguished name of the user account.
    'username' => 'admin@openemr.test.com',
    // 'username' => 'admin@openemrstoked.com',
    'password' => 'Upwork*123',
];
try {
    // Add a connection provider to Adldap.
    $ad->addProvider($config);
    // If a successful connection is made to your server, the provider will be returned.
    $provider = $ad->connect();

    $valid = $provider->auth()->attempt('kap@openemr.test.com', 'Upwork*123');
    if (!$valid) {
        exit();
    }
    $ad_userinfo = active_directory_userinfo('kap@openemr.test.com');
    var_dump($ad_userinfo);
} catch (Exception $e) {
    echo $e;
    // There was an issue binding / connecting to the server.
}


function active_directory_userinfo($user)
{
    // Create class instance
    $ad = new Adldap\Adldap();

    // Create a configuration array.
    $config = [
        // An array of your LDAP hosts. You can use either
        // the host name or the IP address of your host.
        'hosts'    => ['172.31.15.251'],
        // 'hosts'    => ['172.31.12.188'],

        // The base distinguished name of your domain to perform searches upon.
        'base_dn'  => 'dc=openemr,dc=test,dc=com',
        // 'base_dn'  => 'dc=openemrstoked,dc=com',

        // The account to use for querying / modifying LDAP records. This
        // does not need to be an admin account. This can also
        // be a full distinguished name of the user account.
        'username' => 'admin@openemr.test.com',
        // 'username' => 'admin@openemrstoked.com',
        'password' => 'Upwork*123',
    ];

    // Add a connection provider to Adldap.
    $ad->addProvider($config);
    try {
        $provider = $ad->connect();

        $parts = explode("@", $user);
        $username = $parts[0];

        $user = $provider->search()->users()->find($username);

        $userinfo = array();

        $firstname = $user->getFirstName();
        $lastname = $user->getLastName();
        $groupnames = $user->getGroupNames();

        return array(
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'groupnames' => $groupnames
        );
    } catch (Exception $e) {
        return array();
    }
}
