<?php

namespace xRookieFight\KnockBack\form;

use JsonException;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use xRookieFight\KnockBack\Main;

class KnockBackForm implements Form {

    public function __construct(public string $world) {}

    public function jsonSerialize(): array
    {
       $config = new Config(Main::getInstance()->getDataFolder() . "/worlds/" . $this->world . ".yml");
       return [
           "type" => "custom_form",
           "title" => "Knockback Menu",
           "content" => [
               ["type" => "label", "text" => "World: $this->world\n"],
               ["type" => "input", "text" => "Knockback:", "placeholder" => "EX: 0.4", "default" => (string) $config->get("knockback") ?? (string) 0.4],
               ["type" => "input", "text" => "Attack Cooldown:", "placeholder" => "EX: 8", "default" => (string) $config->get("attack-cooldown") ?? (string) 8],
           ]
       ];
    }

    /**
     * @throws JsonException
     */
    public function handleResponse(Player $player, $data): void
    {
        if (is_null($data)) return;
        $kb = $data[0];
        $ac = $data[1];
        if (empty($kb) || empty($ac)) {
            $player->sendMessage(TextFormat::RED."Fill all the sections.");
            return;
        }
        $config = new Config(Main::getInstance()->getDataFolder(). "/worlds/". $this->world. ".yml", Config::YAML);
        $config->set("knockback", $kb);
        $config->set("attack-cooldown", $ac);
        $config->save();
        $player->sendMessage(TextFormat::GREEN . "World " . TextFormat::DARK_GREEN . $this->world . TextFormat::GREEN . "'s knockback/attack cooldown is now $kb/$ac");
    }
}
