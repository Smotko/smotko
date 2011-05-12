<?php

return array(

    array(
      'label' => 'Index',
      'uri' => '/',
    ),
    array(
      'label' => 'Blog',
      'uri' => '/blogs'
    ),
    array(
      'label' => 'Debate',
      'uri' => '/debate'
    ),
    array(
      'label' => 'PNP',
      'uri' => '/pnp'
    ),

    array(
        'label' => 'Admin',
        'uri' => '/admin',
        'resource' => 'admin',
        'privilage' => 'index',
        'pages' => array(
            array(
                'label' => 'Admin',
                'uri' => '/admin',
            ),
            array(
                'label' => 'Site settings',
                'uri' => '/admin/settings',
            ),

            array(
                'label' => 'Blog',
                'uri' => '/admin/blog'
            ),

//            array(
//                'label' => 'Klepet',
//                'uri' => '/admin/klepet'
//            ),

            array(
                'label' => 'PNP',
                'uri' => '/admin/pnp'
            ),

            array(
                'label' => 'Go to site',
                'uri' => '/'
            ),
            
            array(
                'label' => 'Logout',
                'uri' => '/admin/user/logout',
            ),
        ),
    ),
    array(
      'label' => '',
      'class' => 'rss',
      'uri' => '/blogs/rss'
    ),
    array(
      'label' => '',
      'class' => 'twitter',
      'uri' => 'http://www.twitter.com/smotko',
      'title' => 'Spremljaj moje čivkanje!'
    ),
);