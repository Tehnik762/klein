<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Http\Router\AdvertsPath;
use App\Models\Advert;
use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use App\Models\Regions;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Kalnoy\Nestedset\Collection;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Blog
Breadcrumbs::for('profil.home', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Profil', route('profil.home'));
});

Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});

Breadcrumbs::for('passreset', function (BreadcrumbTrail $trail) {
    $trail->parent('login');
    $trail->push('Password Reset', route('login'));
});

// Admin USERS
Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.index'));
});

Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('New User', route('users.create'));
});


Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users.index');
    $trail->push($user->name, route('users.show', [$user->id]));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users.index');
    $trail->push('Edit User '.$user->name, route('users.edit', [$user->id]));
});

//Admin Regions
Breadcrumbs::for('regions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Regions', route('regions.index'));
});

Breadcrumbs::for('regions.show', function (BreadcrumbTrail $trail, Regions $region) {
    if ($parent = $region->parent()->first()) {
        $trail->parent('regions.show', $parent);
    } else {
        $trail->parent('regions.index');
    }

    $trail->push($region->name, route('regions.show', [$region->id]));
});

//Admin Advert Categories

Breadcrumbs::for('categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Advert Categories', route('categories.index'));
});

Breadcrumbs::for('categories.inside', function (BreadcrumbTrail $trail, AdvertCategory $category) {
    if ($parent = $category->parent()->first()) {
        $trail->parent('categories.inside', $parent);
    } else {
        $trail->parent('categories.index');
    }

    $trail->push($category->name, route('categories.inside', [$category->id]));
});

Breadcrumbs::for('categories.show', function (BreadcrumbTrail $trail, AdvertCategory $category) {
    $trail->parent('categories.index');
    $trail->push('Show Category '.$category->name, route('categories.show', [$category->id]));
});

Breadcrumbs::for('categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories.index');
    $trail->push('Create new Category', route('categories.create'));
});

Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $trail, AdvertCategory $category) {
    $trail->parent('categories.index');
    $trail->push('Edit Category '.$category->name, route('categories.edit', [$category->id]));
});

// Admin Advert Attributes 

Breadcrumbs::for('attributes.show', function (BreadcrumbTrail $trail, AdvertCategory $category, AdvertAttributes $attribute) {
    $trail->parent('categories.show', $category);
    $trail->push('Show Attribute '.$attribute->name, route('attributes.show', [$attribute->id]));
});

Breadcrumbs::for('attributes.create', function (BreadcrumbTrail $trail, AdvertCategory $category) {
    $trail->parent('categories.show', $category);
    $trail->push('Create Attribute ', route('attributes.create'));
});

Breadcrumbs::for('attributes.edit', function (BreadcrumbTrail $trail, AdvertCategory $category, AdvertAttributes $attribute) {
    $trail->parent('categories.show', $category);
    $trail->push('Edit Attribute '.$attribute->name, route('attributes.edit', [$attribute->id]));
});


// Profil 

Breadcrumbs::for('profil.personal', function (BreadcrumbTrail $trail) {
    $trail->parent('profil.home');
    $trail->push('Personal', route('profil.personal'));
});

Breadcrumbs::for('profil.personal.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('profil.personal');
    $trail->push('Edit', route('profil.personal.edit'));
});

Breadcrumbs::for('profil.personal.verify', function (BreadcrumbTrail $trail) {
    $trail->parent('profil.personal.edit');
    $trail->push('Verify Phone', route('profil.personal.verifyform'));
});

Breadcrumbs::for('profil.personal.advert', function (BreadcrumbTrail $trail) {
    $trail->parent('profil.personal');
    $trail->push('Adverts', route('profil.adverts'));
});

Breadcrumbs::for('profil.advert.create', function (BreadcrumbTrail $trail) {
    $trail->parent('profil.personal.advert');
    $trail->push('Create', route('profil.advert.create'));
});

Breadcrumbs::for('profil.adverts.show', function (BreadcrumbTrail $trail, Advert $advert) {
    $trail->parent('profil.personal.advert');
    $trail->push($advert->title, route('profil.adverts.show', [$advert]));
});

Breadcrumbs::for('profil.edit_attr', function (BreadcrumbTrail $trail, Advert $advert) {
    $trail->parent('profil.adverts.show', $advert);
    $trail->push("Edit attributes - ". $advert->title, route('profil.attributes', $advert));
});


// Admin Adverts
Breadcrumbs::for('adverts.manage', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Adverts', route('manage.index'));
});

Breadcrumbs::for('adverts.show', function (BreadcrumbTrail $trail, Advert $advert) {
    $trail->parent('adverts.manage');
    $trail->push($advert->title, route('manage.show', [$advert]));
});

Breadcrumbs::for('adverts.edit_attr', function (BreadcrumbTrail $trail, Advert $advert) {
    $trail->parent('adverts.show', $advert);
    $trail->push("Edit attributes - ". $advert->title, route('manage.attributes.admin', $advert));
});



// Front
Breadcrumbs::for('list', function (BreadcrumbTrail $trail, AdvertsPath $path) {

    if ($path->category != null) {
        if ($parent_cat = $path->category->parent) {
            $trail->parent('list', $path->withCategory($parent_cat));
        } else {
            $trail->parent('list', $path->withCategory(NULL));
        }
        $name = $path->category->name;
        $dest = $path;
    }

    
    if (!isset($name) && !isset($dest)) {
        if ($path->region != null) { 
            if ($parent_reg = $path->region->parent) {
                $trail->parent('list', $path->withRegion($parent_reg));
            }
            $name = $path->region->name;
            $dest = $path;           
        }
    }
    if (isset($name)) {
        $trail->push($name, route('index.filtered', $dest));
    }
    
    
});

Breadcrumbs::for('list.show', function (BreadcrumbTrail $trail, Advert $advert) {
    $region = $advert->region;
    $category = $advert->category;
    $trail->parent('list', adverts_path($region, $category));
    $trail->push($advert->title, route('advert.show', [$advert]));
    
});

/*
Breadcrumbs::for('list.inner_region', function (BreadcrumbTrail $trail, Regions $region) {
    if ($parent = $region->parent) {
        $trail->parent('list.inner_region', $parent);
    } else {
        $trail->parent('home');        
    }
    $trail->push($region->name, route('index.filtered', $region));
    
});

Breadcrumbs::for('list.inner_category', function (BreadcrumbTrail $trail, Regions $region, AdvertCategory $category) {
    if ($parent = $category->parent) {
        $trail->parent('list.inner_category', $region, $parent);
    } else {
        $trail->parent('list.inner_region', $region);        
    }
    $trail->push($category->name, route('index.filtered', [$region, $category]));
    
});

Breadcrumbs::for('list.all', function (BreadcrumbTrail $trail) {
    $trail->parent('home');  
    $trail->push(__('main.all'), route('index.filteredAll'));
});

Breadcrumbs::for('list.inner_category.all', function (BreadcrumbTrail $trail, AdvertCategory $category) {
    if ($parent = $category->parent) {
        $trail->parent('list.inner_category.all', $parent);
    } else {
        $trail->parent('list.all');        
    }
    $trail->push($category->name, route('index.filteredAll', [$category]));
    
});


*/