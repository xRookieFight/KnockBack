<?php

namespace KnockBack;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    private static $instance;

    public static function getInstance() : ?self{
        return self::$instance;
    }

    protected function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onDamage(EntityDamageByEntityEvent $event){
        $event->setKnockBack($this->getConfig()->get("knockback"));
        $event->setAttackCooldown($this->getConfig()->get("attack-cooldown"));
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($command->getName() == "knockback"){
            KnockBackForm::send($sender);
        }
        return true;
    }

}