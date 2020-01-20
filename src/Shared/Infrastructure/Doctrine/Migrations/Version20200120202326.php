<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200120202326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE VIEW view_opening_hours AS (select `p`.`id` AS `parking`,concat(\'[\',group_concat(concat(\'{"day":"\',`o`.`week_day`,\'", "open":"\',`o`.`open`,\'", "close":"\',`o`.`close`,\'"}\') order by `o`.`week_day` ASC separator \',\'),\']\') AS `opening_hours` from (`parking` `p` join `parkingopening_hours` `o` on((`o`.`parking_id` = `p`.`id`))) group by `p`.`id`) ;');
        $this->addSql('CREATE VIEW view_parking_space AS (select `p`.`id` AS `parking`,concat(\'[\',group_concat(concat(\'{"type":"\',`t1`.`name`,\'", "count":"\',`p_s`.`count`,\'"}\') separator \',\'),\']\') AS `parking_space` from ((`parking` `p` join `parking_space` `p_s` on((`p_s`.`parking_id` = `p`.`id`))) join `parking_space_type` `t1` on((`p_s`.`type_id` = `t1`.`id`))) group by `p`.`id`) ;');
        $this->addSql('CREATE VIEW view_price_list AS (select `p`.`id` AS `parking`,concat(\'[\',group_concat(concat(\'{"type":"\',`t2`.`name`,\'", "period":"\',`p_p`.`period`,\'", "price":"\',`p_p`.`price`,\'", "unit":"\',`p_p`.`unit`,\'"}\') order by `p_p`.`price` ASC separator \',\'),\']\') AS `price_list` from ((`parking` `p` join `price_list` `p_p` on((`p_p`.`parking_id` = `p`.`id`))) join `parking_space_type` `t2` on((`p_p`.`type_id` = `t2`.`id`))) group by `p`.`id`) ;');
        $this->addSql('CREATE VIEW view_parking AS (select `p`.`id` AS `id`,`p`.`name` AS `name`,`p`.`owner` AS `owner`,`p`.`coordinate_latitude` AS `lat`,`p`.`coordinate_longitude` AS `lng`,`p`.`address_street` AS `street`,`p`.`address_number` AS `number`,`p`.`address_post_code` AS `post_code`,`p`.`address_city` AS `city`,avg(`op`.`rate`) AS `rate`,`o`.`opening_hours` AS `opening_hours`,`p_l`.`price_list` AS `price_list`,`p_s`.`parking_space` AS `parking_space` from ((((`parking` `p` join `view_opening_hours` `o` on((`o`.`parking` = `p`.`id`))) join `view_price_list` `p_l` on((`p_l`.`parking` = `p`.`id`))) join `view_parking_space` `p_s` on((`p_s`.`parking` = `p`.`id`))) left join `opinion` `op` on((`op`.`parking_id` = `p`.`id`))) group by `p`.`id`) ;');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
