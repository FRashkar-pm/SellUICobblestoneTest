<?php

namespace FRashkar\SellUI;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use FRashkar\SellUI\Commands\SellUICommand;

use jojoe77777\FormAPI\SimpleForm;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("sellui" new SellUICommand($this));
        $this->getLogger()->info("Actived");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch ($command->getName()) {
            case "sellui":
                if ($sender instanceof Player) {
                    $this->openSellUI($sender);
                }
                break;
        }
        return true;
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
