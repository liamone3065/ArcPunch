<?php

namespace Liamone\Item;

use Liamone\Main;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\Bow;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Arc extends Item implements Listener
{
    private $cooldowns = [];

    public function __construct(int $meta = 0)
    {
        parent::__construct(new ItemIdentifier(261, $meta), "ArcPunch");
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onBowUse(PlayerItemUseEvent $event)
    {
        $item = $event->getItem();
        $player = $event->getPlayer();

        if ($item->hasEnchantment(VanillaEnchantments::PUNCH()) && $item->getTypeId() === VanillaItems::BOW()->getTypeId()) {
            if (!$this->hasCooldown($player)) {
                $this->setCooldown($player, Main::getInstance()->getConfig()->get("cooldown"));

                $event->cancel();
                $player->setMotion($player->getDirectionVector()->multiply(Main::getInstance()->getConfig()->get("valeur-boost")));
            } else {
                $player->sendPopup(Main::getInstance()->getConfig()->get("cooldown-message"));
            }
        }
    }

    private function hasCooldown(Player $player): bool
    {
        $playerName = $player->getName();
        return isset($this->cooldowns[$playerName]) && $this->cooldowns[$playerName] > time();
    }

    private function setCooldown(Player $player, int $seconds)
    {
        $playerName = $player->getName();
        $this->cooldowns[$playerName] = time() + $seconds;
    }

}
