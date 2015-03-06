<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TokenRenew\Command;

use Thelia\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Model\ConfigQuery;

/**
 * Class RenewalToken
 * @package TokenRenew\Command
 * @author Manuel Raynaud <manu@thelia.net>
 */
class RenewalToken extends ContainerAwareCommand
{

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName("token:renew")
            ->setDescription("Renew the form.secret config parameter. This parameter is used for generating the CSRF token")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ConfigQuery::write('form.secret', $this->generateToken(), 0, 0);

        $output->writeln([
            "<info>New token generated with success.</info>",
            "<info>It is recommended to remove existing sessions</info>"
        ]);
    }

    private function generateToken()
    {
        $secret = null;

        if (!function_exists("openssl_random_pseudo_bytes")) {
            $firstValue = (float) (mt_rand(1, 0xFFFF) * rand(1, 0x10001));
            $secondValues = (float) (rand(1, 0xFFFF) * mt_rand(1, 0x10001));

            $secret = microtime() . ceil($firstValue / $secondValues) . uniqid();
        } else {
            $secret = openssl_random_pseudo_bytes(40);
        }

        return md5($secret);
    }
}
