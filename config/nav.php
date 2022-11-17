<?php 

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
      //  'active' => 'dashboard.dashboard',
    ],
    [
        'icon' => 'fas fa-tags nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
      //  'active' => 'dashboard.categories.*',
    ],
    /*
    [
        'icon' => 'fas fa-box nav-icon',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
    //    'active' => 'dashboard.products.*',
    ],
    */
    [
        'icon' => 'fas fa-receipt nav-icon',
        'route' => 'dashboard.categories.create',
        'title' => 'Orders',
     //   'active' => 'dashboard.orders.*',
    ],

    [
      'icon' => 'fas fa-tags nav-icon',
      'route' => 'dashboard.categories.trash',
      'title' => 'Teash Categories',
      'badge' => 'New',
    //  'active' => 'dashboard.categories.*',
  ],
];