<?php

namespace Tests;

use App\Character;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase{
    public function testCharacterStartingWit1000Andlevel1AndIsAlive() 
    {
        $character = new Character();
        $this-> assertEquals(1000, $character->health);
        $this-> assertEquals(1, $character->level);
        $this-> assertTrue($character->isAlive);
    }
    public function testDamageSubstractedForHealth()
    {
        $characterAttackant = new Character();
        $characterVictim = new Character();
        $damage = 10;
        $characterAttackant-> attacking($characterVictim, $damage, $characterVictim->distance);
        $this-> assertEquals(990, $characterVictim -> health);
    }
    public function testWhenReciveExeciveDamageHealhBecomes0AndTheCharacterDied()
    {
        $characterAttackant = new Character();
        $characterVictim = new Character();
        $damage = 1000;
        $characterAttackant-> attacking($characterVictim, $damage, $characterVictim->distance);
        $this-> assertFalse($characterVictim->isAlive);
    }

    public function testCharacterIsMax1000()
    {
        $characterHealer = new Character();
        $characterAttackant = new Character();
        $heal = 40;
        $damage= 20;
        $characterAttackant-> attacking($characterHealer, $damage, $characterHealer->distance);
        $characterHealer->healing($characterHealer, $heal);
        $this->assertEquals(1000, $characterHealer->health);
    }
    public function testCharacterCanNotAutoDamage()
    {
        $character = new Character();
        $damage = 20;
        $character->attacking($character, $damage, $character->distance);
        $this->assertEquals(1000, $character->health);
    }
    public function testCharacterCanOnlyAutoHeal()
    {
        $characterAttackant = new Character();
        $characterHealer = new Character();
        $heal = 20;
        $damage= 30;
        $characterAttackant->attacking($characterHealer, $damage, $characterHealer->distance);
        $characterHealer->healing($characterHealer, $heal);
        $this->assertEquals(990, $characterHealer->health);
        $characterAttackant->healing($characterHealer, $heal);
        $this->assertEquals(990, $characterHealer->health);
    }
    public function testIsDamage50porcentLessIfVictimIs5LevelesHaier()
    {
        $characterAttackant = new Character();
        $characterVictim = new Character();
        $characterVictim->level = 6;
        $damage = 50;
        $characterAttackant->attacking($characterVictim, $damage, $characterVictim->distance);
        $this->assertEquals(975, $characterVictim->health);
    }
    public function testIsDamage50porcentM0reIfVictimIs5LevelesLower()
    {
        $characterAttackant = new Character();
        $characterVictim = new Character();
        $characterAttackant->level = 6;
        $damage = 50;
        $characterAttackant->attacking($characterVictim, $damage, $characterVictim->distance);
        $this->assertEquals(900, $characterVictim->health);
    }
    public function testCanOnlyDamageWithinRange()
    {
        $characterMelee = new Character();
        $characterRanged = new Character();
        $characterMelee->range = 2;
        $characterRanged->range = 20;
        $characterRanged->distance = 2;
        $damage = 50;
        $characterMelee->attacking($characterRanged, $damage, $characterRanged->distance);
        $this->assertEquals(950, $characterRanged->health);
        
    } 
    public function testCanNotDamageOutOfRange()
    {
        $characterMelee = new Character();
        $characterRanged = new Character();
        $characterMelee->range = 2;
        $characterRanged->range = 20;
        $characterMelee->distance = 21;
        $damage = 50;
        $characterRanged->attacking($characterMelee, $damage, $characterMelee->distance);
        $this->assertEquals(1000, $characterMelee->health);
    } 
    public function testAlliesCantDamageEachOther(){
        $characterMelee = new Character();
        $characterRanged = new Character();
        $characterMelee->faction ="Elf";
        $characterRanged->faction ="Elf";
        $damage=50;
        $characterMelee-> attacking($characterRanged, $damage, $characterRanged->distance);
        $this-> assertEquals(1000, $characterRanged->health);
    }
    public function testAlliesCanOnlyHealEachOther(){
        $characterMelee = new Character();
        $characterRanged = new Character();
        $characterMelee->faction ="Dwarf";
        $characterRanged->faction ="Elf";
    }
}
  