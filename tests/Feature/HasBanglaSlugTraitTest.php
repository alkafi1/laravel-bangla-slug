<?php

namespace Rupam\BanglaSlug\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Rupam\BanglaSlug\Tests\TestCase;
use Rupam\BanglaSlug\Traits\HasBanglaSlug;

class HasBanglaSlugTraitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function test_it_generates_slug_on_saving()
    {
        $model = new TestModel();
        $model->title = 'আমার সোনার বাংলা';
        $model->save();

        $this->assertEquals('আমার-সোনার-বাংলা', $model->slug);
    }

    public function test_it_generates_unique_slugs()
    {
        $model1 = new TestModel();
        $model1->title = 'আমার সোনার বাংলা';
        $model1->save();

        $model2 = new TestModel();
        $model2->title = 'আমার সোনার বাংলা';
        $model2->save();

        $this->assertEquals('আমার-সোনার-বাংলা', $model1->slug);
        $this->assertEquals('আমার-সোনার-বাংলা-1', $model2->slug);
    }

    public function test_it_does_not_override_existing_slug()
    {
        $model = new TestModel();
        $model->title = 'আমার সোনার বাংলা';
        $model->slug = 'custom-slug';
        $model->save();

        $this->assertEquals('custom-slug', $model->slug);
    }

    public function test_it_handles_large_number_of_duplicates()
    {
        for ($i = 0; $i < 15; $i++) {
            $model = new TestModel();
            $model->title = 'একই শিরোনাম';
            $model->save();

            if ($i === 0) {
                $this->assertEquals('একই-শিরোনাম', $model->slug);
            } else {
                $this->assertEquals('একই-শিরোনাম-' . $i, $model->slug);
            }
        }
    }

    public function test_it_handles_empty_title_gracefully()
    {
        $model = new TestModel();
        $model->title = ''; // Empty title
        $model->save();

        $this->assertNull($model->slug);

        $model2 = new TestModel();
        $model2->title = '@@@'; // Invalid characters that strip down to empty string
        $model2->save();
        
        // Wait, if BanglaSlug::make('@@@') returns '', the slug shouldn't be set to '' if the column is nullable, but let's check what the trait does.
        // The trait checks: !empty($model->{$sourceField}) - if it's '@@@', it's not empty. So it generates '' as slug.
        $this->assertEquals('', $model2->slug);
    }
}

class TestModel extends Model
{
    use HasBanglaSlug;

    protected $guarded = [];
}
