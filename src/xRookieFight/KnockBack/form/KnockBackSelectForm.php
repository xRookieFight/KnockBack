<?php

namespace xRookieFight\KnockBack\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\Server;

class KnockBackSelectForm implements Form {

    public array $worldIndex = [];

    public function jsonSerialize(): array
    {
       $arr = [];
       foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) $arr[] = $world->getFolderName();
       $this->worldIndex = $arr;

       return [
           "type" => "custom_form",
           "title" => "Knockback Menu",
           "content" => [
               ["type" => "dropdown", "text" => "Select a world:", "options" => $arr],
           ]
       ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if (is_null($data)) return;
        $world = $this->worldIndex[$data[0]];
        if ($world === null) return;
        $player->sendForm(new KnockBackForm($world));
    }
}
