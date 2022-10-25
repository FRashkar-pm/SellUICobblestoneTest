<?php

namespace FRashkar\SellUI\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use jojoe77777\FormAPI\SimpleForm;
use onebone\economyapi\EconomyAPI;

class SellUICommand extends Command {

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
            $this->openSellUI($sender);
            }
        }
    }
    
    public function openSellUI(Player $player)
    {
        $form = new SimpleForm(function(Player $player, int $result = null) {
            if ($result === null) {
                return;
            }
            // Button 1
            if ($result === 0) {
                
                // Get item in hand
                $item = $player()->getInventory()->getIntemInHand();

                $price = 0.1; // 1 cobblestone = 0.1 money

                // Total item
                $total = $item->getCount() * $price;

                // Give money to player
                EconomyAPI::getInstance()->addMoney($player, $total);

                // Send message to player
                $player->sendMessage("You have recieved " . $total . "for selling Cobblestone x" . $item->getCount());

                // Reset item
                $player->getInventory()->remove($item);
                
            }});

        $item = $player()->getInventory()->getIntemInHand();

        if ($item->getId() != 4) {
            $player->sendMessage("You can only sell cobblestone!");
            return;
        }

        // Form
        $form->setTitle( title: "Sell UI");
        $form->setContent( content: "Do you want to sell cobblestone x" . $item->getCount() . " ?");
        $form->addButton( text: "Sell now!");

        // Send form to player
        $player->sendForm($form);
    }
 }
