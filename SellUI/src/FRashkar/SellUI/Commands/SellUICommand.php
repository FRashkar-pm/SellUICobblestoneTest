<?php

namespace FRashkar\SellUI\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

use FRashkar\SellUI\Main;

class SellUICommand extends Command {

    public function __construct()
    {
        parent::__construct("sellui", "Sellui command", "/sellui", ["sui"]);
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Use it in-game please!");
        }else{
            $this->openSellUI($sender);
        }
    }
 }
