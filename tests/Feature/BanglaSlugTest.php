<?php

namespace Alkafi1\BanglaSlug\Tests\Feature;

use Alkafi1\BanglaSlug\Facades\BanglaSlug;
use Alkafi1\BanglaSlug\Tests\TestCase;

class BanglaSlugTest extends TestCase
{
    public function test_it_can_generate_slug_from_bengali_text()
    {
        $text = 'আমার সোনার বাংলা';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('আমার-সোনার-বাংলা', $slug);
    }

    public function test_it_removes_special_characters_but_keeps_bengali()
    {
        $text = 'আমার *সোনার* বাংলা!!!';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('আমার-সোনার-বাংলা', $slug);
    }

    public function test_it_handles_mixed_english_and_bengali_text()
    {
        $text = 'Hello আমার সোনার বাংলা World 123';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('hello-আমার-সোনার-বাংলা-world-123', $slug);
    }

    public function test_it_uses_custom_separator()
    {
        config(['bangla-slug.separator' => '_']);

        $text = 'আমার সোনার বাংলা';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('আমার_সোনার_বাংলা', $slug);
    }

    public function test_it_handles_multiple_spaces()
    {
        $text = 'আমার    সোনার     বাংলা';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('আমার-সোনার-বাংলা', $slug);
    }

    public function test_it_handles_bengali_numbers_and_complex_conjuncts()
    {
        $text = '১২৩৪৫৬৭৮৯০ যুক্তাক্ষর ও ড় ঢ য় ৎ ং ঃ ঁ';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('১২৩৪৫৬৭৮৯০-যুক্তাক্ষর-ও-ড়-ঢ-য়-ৎ-ং-ঃ-ঁ', $slug);
    }

    public function test_it_strips_emojis_and_other_language_characters()
    {
        $text = 'hello 👋 আমার সোনার বাংলা 😊 你好';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('hello-আমার-সোনার-বাংলা', $slug);
    }

    public function test_it_returns_empty_when_no_valid_characters_present()
    {
        $text = '!!! @@@ ### 👋😊';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('', $slug);
    }

    public function test_it_handles_strings_with_only_separators_and_spaces()
    {
        $text = ' -  -- - ';
        $slug = BanglaSlug::make($text);

        $this->assertEquals('', $slug);
    }

    public function test_it_prevents_concatenation_when_special_chars_are_removed()
    {
        // "আমার@#$সোনার" becomes "আমারসোনার" because special chars are stripped.
        // If there are spaces around them: "আমার @#$ সোনার" becomes "আমার-সোনার"
        $text1 = 'আমার@#$সোনার';
        $slug1 = BanglaSlug::make($text1);
        $this->assertEquals('আমারসোনার', $slug1);

        $text2 = 'আমার @#$ সোনার';
        $slug2 = BanglaSlug::make($text2);
        $this->assertEquals('আমার-সোনার', $slug2);
    }
}
