<?php

namespace Liamone;


use pocketmine\event\Listener;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {


    private static  $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getLogger()->info("ArcPunch par Liamone3065 a été activé!");
        $this->getServer()->getPluginManager()->registerEvents(new Item\Arc(), $this);
    }

    public static function getInstance(): Main
    {
        return self::$instance;
    }

}