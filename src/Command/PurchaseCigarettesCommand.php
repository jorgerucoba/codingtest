<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\CigarettePurchase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 *
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount = (float)\str_replace(',', '.', $input->getArgument('amount'));

        try {
            if ($itemCount === 0 || $amount == 0) {
                throw new \Exception('Please verify the amount typed :(');
            }

            $cigaretteMachine = new CigaretteMachine();
            $transaction = $cigaretteMachine->execute(new CigarettePurchase($itemCount, $amount));

        } catch (\Exception $e) {
            $output->writeln(sprintf('Oops! Something went wrong: %s', $e->getMessage()));

            return;
        }

        $output->writeln(
            sprintf(
                'You bought <info>%d</info> packs of cigarettes for <info>%.2f</info>, each for <info>%.2f</info>. ',
                $transaction->getItemQuantity(),
                $transaction->getTotalAmount(),
                $cigaretteMachine::ITEM_PRICE
            )
        );
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(['Coins', 'Count'])
            ->setRows($transaction->getChange());

        $table->render();

    }
}
