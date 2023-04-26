<?php

namespace KnockBack;

use form\CustomForm;
use pocketmine\player\Player;

class KnockBackForm{
    public static function send(Player $player){
        $form = new CustomForm(function (Player $player, array $data = null) {
           if (is_null($data)) return true;
           if ($data[0] == null) {
               $data[0] = 0.4;
           }
           if ($data[1] == null) {
               $data[1] = 8;
           }
           Main::getInstance()->getConfig()->set("knockback", $data[0]);
           Main::getInstance()->getConfig()->set("attack-cooldown", $data[1]);
           Main::getInstance()->getConfig()->save();
           $player->sendMessage("§8» §bSettings was saved successfully.");
           return true;
        });
        $form->setTitle("KnockBack Menu");
        $form->addInput("KnockBack:", "Example: 0.5", Main::getInstance()->getConfig()->get("knockback"));
        $form->addInput("Attack Cooldown:", "Example: 8", Main::getInstance()->getConfig()->get("attack-cooldown"));
        $form->sendToPlayer($player);
    }
}
