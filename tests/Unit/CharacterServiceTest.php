<?php

namespace Tests\Unit;

use App\Models\Character;
use App\Services\CharacterService;
use Tests\TestCase;

class CharacterServiceTest extends TestCase
{
    protected $characterService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->characterService = new CharacterService();
    }

    public function test_can_add_currency_to_character()
    {
        $character = Character::factory()->create(['money' => 1000]);

        $this->characterService->addCurrency($character, 'money', 500);

        $this->assertEquals(1500, $character->refresh()->money);
    }

    public function test_can_remove_currency_from_character()
    {
        $character = Character::factory()->create(['money' => 1000]);

        $this->characterService->removeCurrency($character, 'money', 300);

        $this->assertEquals(700, $character->refresh()->money);
    }

    public function test_cannot_remove_more_currency_than_available()
    {
        $character = Character::factory()->create(['money' => 100]);

        $this->expectException(\Exception::class);
        $this->characterService->removeCurrency($character, 'money', 500);
    }

    public function test_can_update_character_level()
    {
        $character = Character::factory()->create(['level' => 1]);

        $this->characterService->updateLevel($character, 50);

        $this->assertEquals(50, $character->refresh()->level);
    }

    public function test_level_cannot_exceed_max()
    {
        $character = Character::factory()->create(['level' => 1]);

        $this->characterService->updateLevel($character, 200);

        $this->assertEquals(150, $character->refresh()->level);
    }
}
