# Laravel BanglaSlug

A powerful, robust, and easy-to-use Laravel package for generating slugs from Bengali text. It seamlessly removes special characters, supports English-Bengali mixed strings, and safely handles Emojis, numbers, and complex conjuncts (যুক্তাক্ষর).

## Features

- **Accurate Slug Generation**: Keeps Bengali characters, letters, and numbers intact.
- **Eloquent Trait included**: Automatically generate unique slugs in your database models on saving.
- **Customizable**: Set maximum slug length, strip or keep English characters, and define custom string replacements.
- **Global Helper Function**: Use `bangla_slug('text')` anywhere in your application.
- **Tested & Reliable**: Extensive test coverage including difficult edge cases.

## Installation

You can install the package via composer:

```bash
composer require rupam/bangla-slug
```

*(Note: Since this is currently a local package, make sure to add it to your project's repository list or publish it to Packagist first).*

### Publish Configuration

Optionally, you can publish the config file to customize the default behavior:

```bash
php artisan vendor:publish --tag="bangla-slug-config"
```

This will create a `config/bangla-slug.php` file in your application where you can change the default separator, toggle English characters, set a max length, and define custom character replacements.

---

## Usage

### 1. Using the Facade

```php
use Rupam\BanglaSlug\Facades\BanglaSlug;

$slug = BanglaSlug::make('আমার সোনার বাংলা'); 
// Result: 'আমার-সোনার-বাংলা'
```

### 2. Using the Helper Function

You can quickly generate a slug anywhere using the global helper function:

```php
$slug = bangla_slug('Laravel এর সাথে বাংলা Slug'); 
// Result: 'laravel-এর-সাথে-বাংলা-slug'
```

### 3. Passing Options Dynamically

You can pass an array of options to customize the behavior on the fly:

```php
$slug = bangla_slug('আমার সোনার বাংলা @ 2026', [
    'separator' => '_',          // Use underscore instead of hyphen
    'max_length' => 15,          // Truncate length
    'keep_english' => false,     // Strip out English letters
    'replacements' => [          // Custom replacements before slugifying
        '@' => 'at'
    ]
]);
```

---

## Eloquent Model Integration

The package comes with a handy trait `HasBanglaSlug` to automatically generate **unique** slugs when you create or update an Eloquent model.

### Basic Setup

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rupam\BanglaSlug\Traits\HasBanglaSlug;

class Post extends Model
{
    use HasBanglaSlug;
    
    protected $fillable = ['title', 'slug', 'content'];
}
```
Now, whenever you create a `Post`, the `slug` field will be automatically populated based on the `title` field. If a duplicate exists, it will append a number (e.g., `আমার-সোনার-বাংলা-1`).

### Customizing the Fields

If your database columns are named differently (e.g., `name` instead of `title`, or `url_slug` instead of `slug`), you can easily override the default methods in your model:

```php
class Category extends Model
{
    use HasBanglaSlug;
    
    // The field in the DB to save the slug to
    public function getSlugField(): string 
    { 
        return 'url_slug'; 
    }
    
    // The field to generate the slug from
    public function getSlugSourceField(): string 
    { 
        return 'name'; 
    }
}
```

## Testing

This package is thoroughly tested. To run the tests, clone the repository and run:

```bash
composer install
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see License File for more information.
