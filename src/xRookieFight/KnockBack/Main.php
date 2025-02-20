<?php

namespace xRookieFight\KnockBack;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use xRookieFight\KnockBack\command\KnockBackCommand;

class Main extends PluginBase implements Listener{

    private static Main $instance;

    public static function getInstance() : ?self{
        return self::$instance;
    }

    protected function onEnable(): void
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder()."worlds");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("knockback", new KnockBackCommand());
    }

    public function onDamage(EntityDamageByEntityEvent $event): void
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "/worlds/" . $event->getDamager()->getWorld()->getFolderName() . ".yml");
        if ($config->get("knockback")) {
            $event->setKnockBack($config->get("knockback"));
            $event->setAttackCooldown($config->get("attack-cooldown"));
        }
    }

}