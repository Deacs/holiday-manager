<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

use Laracasts\TestDummy\Factory as TestDummy;


class UsersTableSeeder extends Seeder {

    public function run()
    {
        $users = [
            ['David', 'Ives', 'david-ives', 'CTO', 'david@crowdcube.com', '$2y$10$zLy5FZbaSejvRE7NbIxjwe098nirGClXxPtz7JcaSbc4BMcmtFr0y', '01392 348473', 118, 'david.crowdcube', 1, 1, 0, 1, NULL, 'NEyvgHptR2vgkgmX0bQw1AyuTBuCZsEE5rLXfb8ZfrSau5JrdoyrSkkhPDax', '0000-00-00 00:00:00', '2015-06-22 21:58:48'],
	        ['Rob', 'Crowe', 'rob-crowe', 'Head of Engineering', 'rob@crowdcube.com', '$2y$10$0Yprz9gmvfb6vqvVsUF14eqC007zvFXG2.zDpgyfwJPRONogVXsxK', NULL, NULL, NULL, 1, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:57'],
            ['Ben', 'Christine', 'ben-christine', 'Design Lead', 'ben@crowdcube.com', '$2y$10$W/bIKNrkJuHKRH6bgJyH1.sngcbNVkI5CFe9KW2QLxUO6mcEEYN3G', NULL, NULL, 'crowdcubeben', 1, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:57'],
	        ['Luke', 'Lang', 'luke-lang', 'CMO', 'luke@crowdcube.com', '$2y$10$gezO.vwZCCDH2s1FLrbzN.DXJxw.mlUpyo5fHzmV5ymu7JjJ8U1Hm', '01392 348461', 107, 'luke-lang', 2, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['James', 'Roberts', 'james-roberts', 'Head of Communication', 'james.roberts@crowdcube.com', '$2y$10$nAS.YDHvQyQTbGKGrrRQM.9tHwgW8mPoz/R3D5hnF47SvtCAb.sL.', '01392 348456', 108, 'crowdcubejames', 2, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Becca', 'Lewis', 'becca-lewis', 'Communications & PR Manager', 'becca.lewis@crowdcube.com', '$2y$10$AEUKDpCMgunhIcsoCoTps.iPz5ofBEt4v3aCCxDjG4/SzGY4m8/G6', '01392 348471', 124, 'crowdcube.becca', 2, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Bill', 'Simmons', 'bill-simmons', 'CFO', 'bill@crowdcube.com', '$2y$10$CiNHXJhYBbs2qI4fZCgpYuLHpIlyQnrEj0LWJPdJcxrpX94Xf/NjC', '01392 348468', NULL, 'crowdcube.bill', 6, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Rebecca', 'Hand', 'rebecca-hand', 'Financial Controller', 'rebecca@crowdcube.com', '$2y$10$H3TSI2y/cD/DhROeWjThUuWtvevpHzuYvric6LEVCXb.IluplFGke', '01392 348451', 102, 'crowdcube.rebecca', 6, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Matt', 'Cooper', 'matt-cooper', 'Commercial Director', 'matt.cooper@crowdcube.com', '$2y$10$oRYBaxVfSX3njMDAaPaeAu3F5VIOPKvUhHa/1aYqWrz/CddSBhjxO', '07545 203534', NULL, NULL, 9, 2, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Tom', 'Leigh', 'tom-leigh', 'Business Development Manager', 'tom.leigh@crowdcube.com', '$2y$10$gP4yJqu.S3KO8Lj41Apdb.RLjAuzdMLiTrQVGgD8QFTo721VdSG3u', '07834 757780', NULL, NULL, 9, 2, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Paul', 'Massey', 'paul-massey', 'General Counsel', 'paul.massey@crowdcube.com', '$2y$10$YxxqC4deBUt73HhCT0Xka.YuAOcDNno//yt/ZEk9h3JpybG/s3hNe', '01392 123456', NULL, 'paul-massey', 7, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Dean', 'Mayer', 'dean-mayer', 'Head of Debt', 'dean.mayer@crowdcube.com', '$2y$10$ATJ.Ob4l6U1l973mDo5hYOZ10NxUrREDrRwS9MPct9O0VoDfhFLyq', '07931 382807', NULL, NULL, 8, 2, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Michael', 'Wilkinson', 'michael-wilkinson', 'Head of Equity Investment', 'michael.wilkinson@crowdcube.com', '$2y$10$4pdIrHsq36NydegDkC8sBOyTbPkT9NLPYAFZuvNOZpL.ge2Lt4tAa', '01392 348453', 105, 'micwilkinson1', 3, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Thor', 'Mitchell', 'thor-mitchell', 'Head of Product', 'thor.mitchell@crowdcube.com', '$2y$10$IaaKpAKBIfpZc.jPVZNTge/3ZTIuA4JBEBXnd/chEJ2f3jEtB7UdW', NULL, NULL, NULL, 4, 1, 0, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'],
	        ['Darren', 'Westlake', 'darren-westlake', 'CEO', 'darren.westlake@crowdcube.com', '$2y$10$9mx5MivxlRfGkrGdo2NFrO/tZEwKjduqm8bY8h2NlivDzTLjhEBTa', '01392 348450 ', 101, 'dazwest', 4, 1, 1, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58']
        ];

        foreach ($users as $user) {

            DB::table('users')->insert([
                'first_name'            => $user[0],
                'last_name'             => $user[1],
                'slug'                  => $user[2],
                'role'                  => $user[3],
                'email'                 => $user[4],
                'password'              => $user[5],
                'telephone'             => $user[6],
                'extension'             => $user[7],
                'skype_name'            => $user[8],
                'department_id'         => $user[9],
                'location_id'           => $user[10],
                'super_user'            => $user[11],
                'confirmed'             => $user[12],
                'confirmation_token'    => $user[13],
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now(),
            ]);
        }

    }

}
