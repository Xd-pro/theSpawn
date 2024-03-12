<?php

namespace supercrafter333\theSpawn\commands\warp;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use supercrafter333\theSpawn\theSpawn;

class WarpBanCommand implements CommandExecutor {

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!isset($args[1])) return self::usageFail($sender);
                
        $cfg = new Config(theSpawn::getInstance()->getDataFolder() . "bans/" . strtolower($args[0]) . ".yml", default: ["bans" => []]);

        if (!\in_array($args[1], $cfg->get("bans"))) {
            $cfg->set("bans", [$args[1], ...$cfg->get("bans")]);
            $sender->sendMessage(TextFormat::GREEN . "Banned " . $args[0] . " from warp " . $args[1]);
        } else {
            $cfg->set("bans", \array_filter($cfg->get("bans"), fn($x) => $x !== $args[1]));
            $sender->sendMessage(TextFormat::BLUE . "Unbanned " . $args[0] . " from warp " . $args[1]);
        }
        
        $cfg->save();

        
        
        

        return false;
    }

    public static function usageFail(CommandSender $sender): bool {
        $sender->sendMessage(TextFormat::RED . "Usage: /warpban <username> <warp>");
        $sender->sendMessage(TextFormat::GRAY . "If the username isn't working, try wrapping it in quotes");
        return false;
    }

}