<?php

use App\User;
use App\Department;

class CrowdcubeTester extends TestCase {

    protected $fake;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh');
//        Artisan::call('db:seed');
    }

    /**
     * Helper method to create a User and log it in
     *
     * @param int $super_user
     * @param bool $dept_lead
     * @return mixed
     */
    protected function createUserAndLogin($super_user = 0, $dept_lead = false)
    {
        $department = factory(Department::class)->create();
        $user       = factory(User::class)->create([
            'department_id' => $department->id,
            'super_user'    => $super_user
        ]);

        if ($dept_lead) {
            $department->lead_id = $user->id;
            $department->save();
        }

        Auth::loginUsingId($user->id);

        return $user;
    }
}
