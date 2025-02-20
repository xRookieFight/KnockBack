<?php


namespace xRookieFight\KnockBack\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use xRookieFight\KnockBack\form\KnockBackSelectForm;

class KnockBackCommand extends Command
{

    public function __construct()
    {
        parent::__construct("knockback", "Knockback command", "/knockback", ["hit", "sethit", "setkb"]);
        $this->setPermission("knockback.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if ($sender instanceof Player) {
            if ($this->testPermission($sender)){
                $sender->sendForm(new KnockBackSelectForm());
            }
        }
        return true;
    }

}