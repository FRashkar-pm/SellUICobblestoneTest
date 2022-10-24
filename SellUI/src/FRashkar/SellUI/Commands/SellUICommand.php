<?php

namespace FRashkar\SellUI\Commands\SellUICommand;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SellUICommand extends Command
{

    public function __construct()
    {
        parent::__construct("sellui", "Sellui command", "/sellui", ["sui"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            if($sender->hasPermission("sellui.use")) {
                    $sender->sendMessage(TextFormat::RED . "Please use this command in-game!");
        } else {
            $sender->sendMessage(TextFormat::GREEN . "Success!");
            }
        }
    }
 }
